<?php

namespace App\Services;

use App\DateParser;
use App\Models\Event;
use Exception;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    /**
     * @throws Exception
     */
    public function createCalendarEvent(Event $event): \Spatie\GoogleCalendar\Event
    {
        try {
            $googleCalendarEvent = new \Spatie\GoogleCalendar\Event();
            $googleCalendarEvent->name = $this->generateEventName($event);
            $googleCalendarEvent->description = $this->generateEventDescription($event);
            $googleCalendarEvent->startDateTime = DateParser::parse($event->getStartTime());
            $googleCalendarEvent->endDateTime = DateParser::parse($event->getEndTime());

            return $googleCalendarEvent->save();
        } catch (Exception $e) {
            Log::error(__('messages.google_calendar_event_create_error'), [
                'error_message' => $e->getMessage(),
                'error' => $e,
            ]);

            throw new Exception(__('messages.google_calendar_event_create_error'));
        }
    }

    private function generateEventName(Event $event): string
    {
        return $event->getEventName() . ' - ' . $event->client->getFullName();
    }

    /**
     * @throws Exception
     */
    private function generateEventDescription(Event $event): string
    {
        $client = $event->client;

        return sprintf(
            "Imię i nazwisko: %s\n" .
            "Numer telefonu klienta: %s\n" .
            "Rozpoczęcie wydarzenia: %s\n" .
            "Zakończenie wydarzenia: %s\n" .
            "Adres dostarczenia: %s\n\n" .
            "%s",
            $client->getFullName(),
            $client->getPhone(),
            DateParser::parse($event->getStartTime())->format('d-m-Y H:i'),
            DateParser::parse($event->getEndTime())->format('d-m-Y H:i'),
            $event->deliveryAddress->getFullAddress(),
            $event->getNote()
        );
    }

    /**
     * @throws Exception
     */
    public function deleteCalendarEvent(int $calendarEventId): void
    {
        try {
            $calendarEvent = \Spatie\GoogleCalendar\Event::find($calendarEventId);

            if ($calendarEvent) {
                $calendarEvent->delete();
            }
        } catch (Exception $e) {
            Log::error(__('messages.google_calendar_event_delete_error'), [
                'error_message' => $e->getMessage(),
                'error' => $e,
            ]);

            throw new Exception(__('messages.google_calendar_event_delete_error'));
        }
    }
}
