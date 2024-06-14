<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GoogleCalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_event_id',
        'name',
        'description',
        'start_date',
        'end_date'
    ];

    public function event(): hasOne
    {
        return $this->hasOne(Event::class);
    }
}
