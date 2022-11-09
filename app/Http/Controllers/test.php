<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\GetExternalDataService;
use App\Http\Integrations\Products\Requests\ProductsRequest;
use App\Enums\ExternalDataRequestEnum;
use Illuminate\Http\Request;

class test extends Controller
{
    public function index(GetExternalDataService $externalDataService): JsonResponse
    {

        $request = ExternalDataRequestEnum::class('categories');
        $response = $externalDataService->get($request);
        return response()->json($response);
    }

}
