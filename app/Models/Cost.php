<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'event_id',
      'package_id',
      'transport_price',
      'addons_price',
      'total_cost'
    ];

    public function getTransportPrice(): float {
        return $this->getAttribute('transport_price');
    }

    public function setTransportPrice($value): void {
        $this->setAttribute('transport_price', $value);
    }

    public function getAddonsPrice(): float {
        return $this->getAttribute('addons_price');
    }

    public function setAddonsPrice($value): void {
        $this->setAttribute('addons_price', $value);
    }

    public function getTotalCost(): float {
        return $this->getAttribute('total_cost');
    }

    public function setTotalCost($value): void {
        $this->setAttribute('total_cost', $value);
    }

    public function event(): BelongsTo{
        return $this->belongsTo(Event::class);
    }

    public function package(): BelongsTo{
        return $this->belongsTo(Package::class);
    }
}
