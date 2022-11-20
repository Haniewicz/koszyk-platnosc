<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CartFactory extends Factory
{
    public function definition(): array
    {
        return [
            'token' => Str::random(32),
            'user_id' => User::factory(),
        ];
    }
}
