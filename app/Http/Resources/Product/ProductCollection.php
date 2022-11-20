<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{

    public function toArray($request): array
    {
        return [
            'data' => $this->collection
        ];
    }
}
