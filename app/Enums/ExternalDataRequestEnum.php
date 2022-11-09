<?php

namespace App\Enums;
use App\Http\Integrations\Products\Requests\ProductsRequest;
use App\Http\Integrations\Categories\Requests\CategoriesRequest;



enum ExternalDataRequestEnum: string
{
    case PRODUCTS = 'products';
    case CATEGORIES = 'categories';

    public static function class(string $ExternalData): object
    {
        return match(self::from($ExternalData)) {
            self::PRODUCTS => new ProductsRequest(),
            self::CATEGORIES => new CategoriesRequest(),
        };
    }
}
