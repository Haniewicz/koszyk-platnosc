<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Integrations\Products\Requests\ProductsRequest;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $request = new ProductsRequest();

        $response = $request->send();

        foreach ($response->json()['products'] as $value) {
            DB::table('Products')->insert([
                'name' => $value['title'],
                'description' => $value['description'],
                'price' => $value['price'],
            ]);
        }
    }
}
