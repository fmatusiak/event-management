<?php

namespace App\Services;

use App\DateParser;
use App\Exceptions\EventsOverlapException;
use App\Models\Address;
use App\Models\Client;
use App\Models\Cost;
use App\Models\Event;
use App\Models\GoogleCalendarEvent;
use App\Repositories\AddressRepository;
use App\Repositories\ClientRepository;
use App\Repositories\CostRepository;
use App\Repositories\EventRepository;
use App\Repositories\GoogleCalendarEventRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class EventService implements EventServiceInterface
{
    private EventRepository $eventRepository;
    private ClientRepository $clientRepository;

    private AddressRepository $addressRepository;

    private CostRepository $costRepository;

    private CostCalculatorService $costCalculatorService;

    private GoogleCalendarService $googleCalendarService;

    private GoogleCalendarEventRepository $googleCalendarEventRepository;

    public function __construct(
        EventRepository               $eventRepository,
        ClientRepository              $clientRepository,
        AddressRepository             $addressRepository,
        CostRepository                $costRepository,
        CostCalculatorService         $costCalculatorService,
        GoogleCalendarService         $googleCalendarService,
        GoogleCalendarEventRepository $googleCalendarEventRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->clientRepository = $clientRepository;
        $this->addressRepository = $addressRepository;
        $this->costRepository = $costRepository;
        $this->costCalculatorService = $costCalculatorService;
        $this->googleCalendarService = $googleCalendarService;
        $this->googleCalendarEventRepository = $googleCalendarEventRepository;
    }

    /**
     * @throws Exception
     */
    public function deleteEvent(int $eventId)
    {
        $event = $this->eventRepository->get($eventId);

        $this->deleteGoogleCalendar($event);

        return $event->delete();
    }

    /**
     * @throws Exception
     */
    private function deleteGoogleCalendar(Event $event): void
    {
        if ($event->google_calendar_event_id) {
            $this->googleCalendarService->deleteCalendarEvent($event->googleCalendarEvent->google_event_id);

            $googleCalendarEvent = $this->googleCalendarEventRepository->find($event->google_calendar_event_id);

            $event->google_calendar_event_id = null;
            $event->save();

            if ($googleCalendarEvent) {
                $googleCalendarEvent->delete();
            }
        }
    }

    /**
     * @throws EventsOverlapException
     * @throws Exception
     */
    public function createEvent(array $data): Event
    {
        $this->validateEventRange($data);

        try {
            DB::beginTransaction();

            $eventData = $this->prepareEventData($data);

            $eventCreated = $this->eventRepository->create($eventData);
            $cost = $eventCreated->cost;

            $totalCost = $this->costCalculatorService->calculateTotalCost($cost);
            $depositCost = $this->costCalculatorService->calculateDepositCost($totalCost);
            $remainingCost = $this->costCalculatorService->calculateRemainingCostAfterDeposit($totalCost, $depositCost);

            $cost->setTotalCost($totalCost);
            $cost->setDepositCost($depositCost);
            $cost->setRemainingCost($remainingCost);
            $cost->save();

            if (Arr::get($data, 'google-calendar-sync')) {
                $this->createGoogleCalendar($eventCreated);
            }

            DB::commit();

            return $eventCreated;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws EventsOverlapException
     * @throws Exception
     */
    public function validateEventRange(array $data, int $eventId = null): void
    {
        $startTime = DateParser::parse(Arr::get($data, 'start_time'));
        $endTime = DateParser::parse(Arr::get($data, 'end_time'));
        $additionalHours = Config::get('event.additional_hours');

        if (isset($startTime, $endTime)) {
            if (!$this->checkAvailableEventRange($startTime, $endTime, $additionalHours, $eventId)) {
                throw new EventsOverlapException(__('messages.events_overlap'));
            }
        }
    }

    public function checkAvailableEventRange(Carbon $StartTime, Carbon $endTime, int $additionalHours = 2, int $eventId = null): bool
    {
        $adjustedStartTime = $StartTime->subHours($additionalHours);
        $adjustedEndTime = $endTime->addHours($additionalHours);

        $query = Event::where('start_time', '>=', $adjustedStartTime)
            ->where('end_time', '<=', $adjustedEndTime);

        if ($eventId) {
            $query = $query->whereNot('id', $eventId);
        }

        return $query->doesntExist();
    }

    private function prepareEventData(array $data): array
    {
        $client = $this->createOrUpdateClient($data['client']);
        $clientAddress = $this->createOrUpdateAddress($data['client_address']);
        $deliveryAddress = $this->createOrUpdateAddress($data['client_delivery']);
        $cost = $this->createOrUpdateCost($data['cost']);

        return [
            'event_name' => Arr::get($data, 'event_name'),
            'note' => Arr::get($data, 'note'),
            'client_id' => $client->id,
            'client_address_id' => $clientAddress->id,
            'delivery_address_id' => $deliveryAddress->id,
            'cost_id' => $cost->id,
            'start_time' => Arr::get($data, 'start_time'),
            'end_time' => Arr::get($data, 'end_time'),
        ];
    }

    private function createOrUpdateClient(array $clientData): Client
    {
        $clientData = [
            'client_id' => Arr::get($clientData, 'client_id'),
            'first_name' => Arr::get($clientData, 'first_name'),
            'last_name' => Arr::get($clientData, 'last_name'),
            'email' => Arr::get($clientData, 'email'),
            'pesel' => Arr::get($clientData, 'pesel'),
            'phone' => Arr::get($clientData, 'phone'),
        ];

        if ($clientId = Arr::get($clientData, 'client_id')) {
            return $this->clientRepository->update($clientId, $clientData);
        }

        return $this->clientRepository->create($clientData);
    }

    private function createOrUpdateAddress(array $addressData): Address
    {
        $addressData = [
            'address_id' => Arr::get($addressData, 'address_id'),
            'street' => Arr::get($addressData, 'street'),
            'city' => Arr::get($addressData, 'city'),
            'postcode' => Arr::get($addressData, 'postcode'),
            'latitude' => Arr::get($addressData, 'latitude'),
            'longitude' => Arr::get($addressData, 'longitude'),
        ];

        if ($addressId = Arr::get($addressData, 'address_id')) {
            return $this->addressRepository->update($addressId, $addressData);
        }

        return $this->addressRepository->create($addressData);
    }

    private function createOrUpdateCost(array $costData): Cost
    {
        $costData = [
            'cost_id' => Arr::get($costData, 'cost_id'),
            'package_id' => Arr::get($costData, 'package_id'),
            'transport_price' => Arr::get($costData, 'transport_price', 0),
            'addons_price' => Arr::get($costData, 'addons_price', 0),
            'deposit_paid' => Arr::get($costData, 'deposit_paid', false),
        ];

        if ($costId = Arr::get($costData, 'cost_id')) {
            return $this->costRepository->update($costId, $costData);
        }

        return $this->costRepository->create($costData);
    }

    /**
     * @throws Exception
     */
    private function createGoogleCalendar(Event $event): GoogleCalendarEvent
    {
        $googleCalendarEventCreated = $this->googleCalendarService->createCalendarEvent($event);

        $googleCalendarEventData = [
            'google_event_id' => $googleCalendarEventCreated->id,
            'name' => $googleCalendarEventCreated->name,
            'description' => $googleCalendarEventCreated->description,
            'start_date' => DateParser::parse($googleCalendarEventCreated->startDateTime),
            'end_date' => DateParser::parse($googleCalendarEventCreated->endDateTime),
        ];

        $googleCalendarEvent = $this->googleCalendarEventRepository->create($googleCalendarEventData);

        $event->google_calendar_event_id = $googleCalendarEvent->id;
        $event->save();

        return $googleCalendarEvent;
    }

    /**
     * @throws EventsOverlapException
     * @throws Exception
     */
    public function updateEvent(int $eventId, array $data)
    {
        $this->validateEventRange($data, $eventId);

        try {
            DB::beginTransaction();

            $eventData = $this->prepareEventData($data);

            $eventUpdated = $this->eventRepository->update($eventId, $eventData);
            $cost = $eventUpdated->cost;

            $totalCost = $this->costCalculatorService->calculateTotalCost($cost);
            $depositCost = $this->costCalculatorService->calculateDepositCost($totalCost);
            $remainingCost = $this->costCalculatorService->calculateRemainingCostAfterDeposit($totalCost, $depositCost);

            $cost->setTotalCost($totalCost);
            $cost->setDepositCost($depositCost);
            $cost->setRemainingCost($remainingCost);
            $cost->save();

            if (Arr::get($data, 'google-calendar-sync')) {
                $this->createOrUpdateGoogleCalendar($eventUpdated);
            } else {
                $this->deleteGoogleCalendar($eventUpdated);
            }

            DB::commit();

            return $eventUpdated;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @throws Exception
     */
    private function createOrUpdateGoogleCalendar(Event $event): GoogleCalendarEvent
    {
        if ($event->google_calendar_event_id) {
            return $this->updateGoogleCalendar($event);
        }
        return $this->createGoogleCalendar($event);
    }

    /**
     * @throws Exception
     */
    private function updateGoogleCalendar(Event $event): GoogleCalendarEvent
    {
        $this->deleteGoogleCalendar($event);

        return $this->createGoogleCalendar($event);
    }
}
