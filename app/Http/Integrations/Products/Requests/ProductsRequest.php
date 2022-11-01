<?php

namespace App\Http\Integrations\Products\Requests;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use App\Http\Integrations\Products\ProductsConnector;

class ProductsRequest extends SaloonRequest
{
    protected ?string $connector = ProductsConnector::class;

    protected ?string $method = Saloon::GET;

}
