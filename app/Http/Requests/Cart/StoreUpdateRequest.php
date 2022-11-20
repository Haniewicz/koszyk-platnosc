<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'item_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer'],
        ];
    }
}
