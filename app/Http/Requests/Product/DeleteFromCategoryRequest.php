<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFromCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required','integer','exists:category_product,category_id'],
        ];
    }
}
