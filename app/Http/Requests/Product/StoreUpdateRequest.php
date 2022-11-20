<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:255','unique:products,name'],
            'description' => ['required','string','max:255'],
            'price' => ['required','numeric'],
            'category_id' => ['required','integer','exists:categories,id'],
        ];
    }
}
