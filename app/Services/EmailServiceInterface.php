<?php

namespace App\Services;

use App\Models\Event;

interface EmailServiceInterface
{
    public function sendContractEmail(Event $event): void;

}
