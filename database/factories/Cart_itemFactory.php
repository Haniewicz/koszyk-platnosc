<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Cart_item;
use Illuminate\Database\Eloquent\Factories\Factory;

class Cart_itemFactory extends Factory
{
    protected $model = Cart_item::class;

    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'item_id' => $this->faker->numberBetween(1, 10),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
