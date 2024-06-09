<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'street',
        'city',
        'postcode',
        'latitude',
        'longitude'
    ];

    public function getStreet(): string
    {
        return $this->getAttribute('street');
    }

    public function setStreet(string $street): void
    {
        $this->setAttribute('street', $street);
    }

    public function getCity(): string
    {
        return $this->getAttribute('city');
    }

    public function setCity(string $city): void
    {
        $this->setAttribute('city', $city);
    }

    public function getPostcode(): string
    {
        return $this->getAttribute('postcode');
    }

    public function setPostcode(string $postcode): void
    {
        $this->setAttribute('postcode', $postcode);
    }

    public function getLatitude(): ?float
    {
        return $this->getAttribute('latitude');
    }

    public function setLatitude(?float $latitude): void
    {
        $this->setAttribute('latitude', $latitude);
    }

    public function getLongitude(): ?float
    {
        return $this->getAttribute('longitude');
    }

    public function setLongitude(?float $longitude): void
    {
        $this->setAttribute('longitude', $longitude);
    }

    public function clientAddresses(): HasMany
    {
        return $this->hasMany(Event::class, 'client_address_id');
    }

    public function deliveryAddresses(): hasMany
    {
        return $this->hasMany(Event::class, 'delivery_address_id');
    }
}
