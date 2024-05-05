<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Carbon;

interface EventServiceInterface
{
    public function createEvent(array $data): Event;

    public function updateEvent(int $eventId, array $data);

    public function validateEventRange(array $data): void;

    public function checkAvailableEventRange(Carbon $StartTime, Carbon $endTime, int $additionalHours = 2, int $eventId = null): bool;
}
