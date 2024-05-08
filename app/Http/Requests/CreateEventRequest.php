<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_name' => 'required|string|max:255',
            'note' => 'nullable|string',

            'client' => 'required|array',
            'client.client_id' => 'nullable|exists:clients.id',
            'client.first_name' => 'required_without:client.client_id|string',
            'client.last_name' => 'required_without:client.client_id|string',
            'client.email' => 'required_without:client.client_id',
            'client.phone' => 'nullable|string',
            'client.pesel' => 'nullable|string|size:11',

            'client_address' => 'required|array',
            'client_address.address_id' => 'nullable|exists:addresses.id',
            'client_address.street' => 'required|string',
            'client_address.city' => 'required|string',
            'client_address.postcode' => 'required|string',
            'client_address.latitude' => 'nullable|string',
            'client_address.longitude' => 'nullable|string',

            'client_delivery' => 'required|array',
            'client_delivery.address_id' => 'nullable|exists:addresses.address_id',
            'client_delivery.street' => 'required|string',
            'client_delivery.city' => 'required|string',
            'client_delivery.postcode' => 'required|string',
            'client_delivery.latitude' => 'nullable|string',
            'client_delivery.longitude' => 'nullable|string',

            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'gmail_sync' => 'boolean',
        ];
    }
}
