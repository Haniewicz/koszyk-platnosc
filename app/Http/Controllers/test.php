<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Integrations\Products\Requests\ProductsRequest;

class test extends Controller
{
    public function index()
    {

        $request = new ProductsRequest();


        $response = $request->send();

        return $response->json()['products'];
    }
}
