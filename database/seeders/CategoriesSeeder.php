<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Integrations\Categories\Requests\CategoriesRequest;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $request = new CategoriesRequest();

        $response = $request->send();

        foreach ($response->json() as $value) {
            DB::table('categories')->insert([
                'name' => $value,
            ]);
        }
    }
}
