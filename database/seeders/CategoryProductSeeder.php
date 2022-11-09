<?php

namespace Database\Seeders;

use App\Enums\ExternalDataRequestEnum;
use App\Services\GetExternalDataService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Http\Integrations\Products\Requests\ProductsRequest;
use Sammyjo20\Saloon\Exceptions\SaloonException;

class CategoryProductSeeder extends Seeder
{
    public function run(GetExternalDataService $externalDataService): void
    {
        $categories = Category::all();

        $response = $externalDataService->get('products');

        foreach ($categories as $category) {
            foreach ($response['products'] as $product) {
                if($product['category'] === $category['name'])
                {
                    DB::table('category_product')->insert([
                        'category_id' => $category['id'],
                        'product_id' => Product::query()->where('name', $product['title'])->first('id')->id,
                    ]);
                }
            }
        }
    }
}
