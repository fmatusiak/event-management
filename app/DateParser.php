<?php

namespace App;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class DateParser
{
    /**
     * @throws Exception
     */
    public static function parse(string $dateString,string $timezone = 'Europe/Warsaw'): ?Carbon
    {
        try {
            return Carbon::parse($dateString,$timezone);
        } catch (Exception $e) {
            Log::error(__('messages.google_calendar_event_create_error'), [
                'error_message' => $e->getMessage(),
                'error' => $e,
            ]);

            throw new Exception(__('messages.date_parse_error', ['date' => $dateString]));
        }
    }
}
