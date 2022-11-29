<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country' => 'required|string',
            'city' => 'required|string',
            'street' => 'required|string',
            'house' => 'required|integer',
            'door_number' => 'required|integer',
        ];
    }
}
