<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'pesel',
        'email',
        'phone',
    ];

    public function getFirstName(): string
    {
        return $this->getAttribute('first_name');
    }

    public function setFirstName(string $firstName): void
    {
        $this->setAttribute('first_name', $firstName);
    }

    public function getLastName(): string
    {
        return $this->getAttribute('last_name');
    }

    public function setLastName(string $lastName): void
    {
        $this->setAttribute('last_name', $lastName);
    }

    public function getPesel(): ?string
    {
        return $this->getAttribute('pesel');
    }

    public function setPesel(?string $pesel): void
    {
        $this->setAttribute('pesel', $pesel);
    }

    public function getEmail(): string
    {
        return $this->getAttribute('email');
    }

    public function setEmail(string $email): void
    {
        $this->setAttribute('email', $email);
    }

    public function getPhone(): ?string
    {
        return $this->getAttribute('phone');
    }

    public function setPhone(?string $phone): void
    {
        $this->setAttribute('phone', $phone);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
