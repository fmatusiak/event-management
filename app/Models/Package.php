<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'rental_time',
        'price'
    ];

    public function getFullName(): string
    {
        return $this->getName() . ' - ' . $this->getRentalTime() . " ( " . $this->getPrice() . " )";
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function getRentalTime(): int
    {
        return $this->getAttribute('rental_time');
    }

    public function getPrice(): float
    {
        return $this->getAttribute('price');
    }

    public function setName(string $name): void
    {
        $this->setAttribute('name', $name);
    }

    public function setRentalTime(int $rentalTime): void
    {
        $this->setAttribute('rental_time', $rentalTime);
    }

    public function setPrice(float $price): void
    {
        $this->setAttribute('price', $price);
    }
}
