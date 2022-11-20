<?php

namespace App\Http\Resources\CartItem;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartItemCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
