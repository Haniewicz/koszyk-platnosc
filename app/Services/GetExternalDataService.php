<?php
//This is Service file. You should write your logic in here
namespace App\Services;

use App\Enums\ExternalDataRequestEnum;

class GetExternalDataService
{

    public static function get(string $enum): array
    {
        $request = ExternalDataRequestEnum::class($enum);
        return $request->send()->json();
    }



}

?>
