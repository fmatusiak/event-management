<?php

namespace App;

use Carbon\Carbon;
use Exception;

class DateParser
{
    /**
     * @throws Exception
     */
    public static function parse(string $dateString): ?Carbon
    {
        try {
            return Carbon::parse($dateString);
        } catch (Exception) {
            return null;
        }
    }
}
