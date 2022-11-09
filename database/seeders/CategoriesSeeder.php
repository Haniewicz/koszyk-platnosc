<?php

namespace Database\Seeders;

use App\Enums\ExternalDataRequestEnum;
use App\Services\GetExternalDataService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Integrations\Categories\Requests\CategoriesRequest;
use Sammyjo20\Saloon\Exceptions\SaloonException;

class CategoriesSeeder extends Seeder
{
    public function run(GetExternalDataService $externalDataService): void
    {
        $response = $externalDataService->get('categories');

        foreach ($response as $value) {
            DB::table('categories')->insert([
                'name' => $value,
            ]);
        }
    }
}
