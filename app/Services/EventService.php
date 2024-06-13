<?php

namespace App\Services;

use App\DateParser;
use App\Exceptions\EventsOverlapException;
use App\Models\Address;
use App\Models\Client;
use App\Models\Cost;
use App\Models\Event;
use App\Repositories\AddressRepository;
use App\Repositories\ClientRepository;
use App\Repositories\CostRepository;
use App\Repositories\EventRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventService implements EventServiceInterface
{
    private EventRepository $eventRepository;
    private ClientRepository $clientRepository;

    private AddressRepository $addressRepository;

    private CostRepository $costRepository;

    private CostCalculatorService $costCalculatorService;

    public function __construct(EventRepository $eventRepository, ClientRepository $clientRepository, AddressRepository $addressRepository, CostRepository $costRepository, CostCalculatorService $costCalculatorService)
    {
        $this->eventRepository = $eventRepository;
        $this->clientRepository = $clientRepository;
        $this->addressRepository = $addressRepository;
        $this->costRepository = $costRepository;
        $this->costCalculatorService = $costCalculatorService;
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

            $data['cost']['event_id'] = $eventCreated->id;

            $cost = $this->createOrUpdateCost($data['cost']);

            $totalCost = $this->costCalculatorService->calculateTotalCost($cost);
            $depositCost = $this->costCalculatorService->calculateDepositCost($totalCost);
            $remainingCost = $this->costCalculatorService->calculateRemainingCostAfterDeposit($totalCost, $depositCost);

            $cost->setTotalCost($totalCost);
            $cost->setDepositCost($depositCost);
            $cost->setRemainingCost($remainingCost);
            $cost->save();

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
        $client = $this->getOrCreateClient($data['client']);
        $clientAddress = $this->getOrCreateAddress($data['client_address']);
        $deliveryAddress = $this->getOrCreateAddress($data['client_delivery']);

        return [
            'event_name' => Arr::get($data, 'event_name'),
            'note' => Arr::get($data, 'note'),
            'client_id' => $client->id,
            'client_address_id' => $clientAddress->id,
            'delivery_address_id' => $deliveryAddress->id,
            'start_time' => Arr::get($data, 'start_time'),
            'end_time' => Arr::get($data, 'end_time'),
            'gmail_sync' => Arr::get($data, 'gmail_sync', false),
        ];
    }

    private function getOrCreateClient(array $clientData): Client
    {
        if ($clientId = Arr::get($clientData, 'client_id')) {
            return $this->clientRepository->get($clientId);
        }

        $clientData = [
            'first_name' => Arr::get($clientData, 'first_name'),
            'last_name' => Arr::get($clientData, 'last_name'),
            'email' => Arr::get($clientData, 'email'),
            'pesel' => Arr::get($clientData, 'pesel'),
            'phone' => Arr::get($clientData, 'phone'),
        ];

        return $this->clientRepository->create($clientData);
    }

    private function getOrCreateAddress(array $addressData): Address
    {
        if ($addressId = Arr::get($addressData, 'address_id')) {
            return $this->addressRepository->get($addressId);
        }

        $createAddressData = [
            'street' => Arr::get($addressData, 'street'),
            'city' => Arr::get($addressData, 'city'),
            'postcode' => Arr::get($addressData, 'postcode'),
            'latitude' => Arr::get($addressData, 'latitude'),
            'longitude' => Arr::get($addressData, 'longitude'),
        ];

        return $this->addressRepository->create($createAddressData);
    }

    private function createOrUpdateCost(array $costData): Cost
    {
        $attributes = [
            'event_id' => Arr::get($costData, 'event_id')
        ];

        $values = [
            'package_id' => Arr::get($costData, 'package_id'),
            'transport_price' => Arr::get($costData, 'transport_price', 0),
            'addons_price' => Arr::get($costData, 'addons_price', 0),
            'deposit_paid' => Arr::get($costData, 'deposit_paid', false),
        ];

        return $this->costRepository->updateOrCreate($attributes, $values);
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

            $data['cost']['event_id'] = $eventUpdated->id;

            $cost = $this->createOrUpdateCost($data['cost']);

            $totalCost = $this->costCalculatorService->calculateTotalCost($cost);
            $depositCost = $this->costCalculatorService->calculateDepositCost($totalCost);
            $remainingCost = $this->costCalculatorService->calculateRemainingCostAfterDeposit($totalCost, $depositCost);

            $cost->setTotalCost($totalCost);
            $cost->setDepositCost($depositCost);
            $cost->setRemainingCost($remainingCost);
            $cost->save();

            DB::commit();

            return $eventUpdated;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
