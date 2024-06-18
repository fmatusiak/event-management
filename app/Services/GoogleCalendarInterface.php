<?php

namespace App\Services;

use App\Models\Event;

interface GoogleCalendarInterface
{
    public function createCalendarEvent(Event $event): \Spatie\GoogleCalendar\Event;

    public function deleteCalendarEvent(string $calendarEventId): void;
}
