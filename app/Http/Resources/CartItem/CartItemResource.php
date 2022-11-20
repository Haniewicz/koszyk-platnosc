<?php

namespace App\Http\Resources\CartItem;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'quantity' => $this->quantity,
        ];
    }
}
