<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event_name',
        'note',
        'client_id',
        'client_address_id',
        'delivery_address_id',
        'start_time',
        'end_time',
        'gmail_sync'
    ];

    public function getEventName(): string
    {
        return $this->getAttribute('event_name');
    }

    public function setEventName(string $eventName): void
    {
        $this->setAttribute('event_name', $eventName);
    }

    public function getNote(): ?string
    {
        return $this->getAttribute('note');
    }

    public function setNote(?string $note): void
    {
        $this->setAttribute('note', $note);
    }

    public function getClientId(): ?int
    {
        return $this->getAttribute('client_id');
    }

    public function setClientId(?int $clientId): void
    {
        $this->setAttribute('client_id', $clientId);
    }

    public function getClientAddressId(): ?int
    {
        return $this->getAttribute('client_address_id');
    }

    public function setClientAddressId(?int $clientAddressId): void
    {
        $this->setAttribute('client_address_id', $clientAddressId);
    }

    public function getDeliveryAddressId(): ?int
    {
        return $this->getAttribute('delivery_address_id');
    }

    public function setDeliveryAddressId(?int $deliveryAddressId): void
    {
        $this->setAttribute('delivery_address_id', $deliveryAddressId);
    }

    public function getStartTime(): ?string
    {
        return $this->getAttribute('start_time');
    }

    public function setStartTime(?string $startTime): void
    {
        $this->setAttribute('start_time', $startTime);
    }

    public function getEndTime(): ?string
    {
        return $this->getAttribute('end_time');
    }

    public function setEndTime(?string $endTime): void
    {
        $this->setAttribute('end_time', $endTime);
    }

    public function getGmailSync(): bool
    {
        return $this->getAttribute('gmail_sync');
    }

    public function setGmailSync(bool $gmailSync): void
    {
        $this->setAttribute('gmail_sync', $gmailSync);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function clientAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'client_address_id');
    }

    public function deliveryAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'delivery_address_id');
    }

    public function cost(): HasOne
    {
        return $this->hasOne(Cost::class);
    }

    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }
}
