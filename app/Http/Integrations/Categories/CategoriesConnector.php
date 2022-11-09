<?php

namespace App\Http\Integrations\Categories;

use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;

class CategoriesConnector extends SaloonConnector
{
    use AcceptsJson;

    public function defineBaseUrl(): string
    {
        return 'https://dummyjson.com/products/categories';
    }

    public function defaultConfig(): array
    {
        return [
            'timeout' => 30,
        ];
    }
}
