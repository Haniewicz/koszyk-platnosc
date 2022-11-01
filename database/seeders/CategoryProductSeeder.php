<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Http\Integrations\Products\Requests\ProductsRequest;

class CategoryProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        $request = new ProductsRequest();

        $response = $request->send();

        foreach ($categories as $category) {
            foreach ($response->json()['products'] as $product) {
                if($product['category'] == $category['name'])
                {
                    DB::table('category_product')->insert([
                        'category_id' => $category['id'],
                        'product_id' => Product::where('name', $product['title'])->first('id')->id,
                    ]);
                }
            }
        }
    }
}
