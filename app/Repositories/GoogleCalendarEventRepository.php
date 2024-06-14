<?php

namespace App\Repositories;

use App\Models\GoogleCalendarEvent;

class GoogleCalendarEventRepository extends BasicRepository
{
    public function __construct(GoogleCalendarEvent $googleCalendarEvent)
    {
        parent::__construct($googleCalendarEvent);
    }
}
