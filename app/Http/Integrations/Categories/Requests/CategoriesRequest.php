<?php

namespace App\Http\Integrations\Categories\Requests;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use App\Http\Integrations\Categories\CategoriesConnector;

class CategoriesRequest extends SaloonRequest
{

    protected ?string $connector = CategoriesConnector::class;

    protected ?string $method = Saloon::GET;


}
