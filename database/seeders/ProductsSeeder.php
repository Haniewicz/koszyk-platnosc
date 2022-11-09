<?php

namespace Database\Seeders;

use App\Enums\ExternalDataRequestEnum;
use App\Services\GetExternalDataService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Integrations\Products\Requests\ProductsRequest;
use Sammyjo20\Saloon\Exceptions\SaloonException;

class ProductsSeeder extends Seeder
{
    public function run(GetExternalDataService $externalDataService): void
    {
        $response = $externalDataService->get('products');

        foreach ($response['products'] as $value) {
            DB::table('Products')->insert([
                'name' => $value['title'],
                'description' => $value['description'],
                'price' => $value['price'],
            ]);
        }
    }
}
