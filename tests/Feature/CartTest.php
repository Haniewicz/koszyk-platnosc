<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->cart = Cart::factory()->create([
            'user_id' => $this->user->id
        ]);

        $this->cartItem = CartItem::factory()->create([
            'cart_id' => $this->cart->id
        ]);
    }

    public function test_if_user_can_show_cart_if_it_has_items(): void
    {
        $response = $this->actingAs($this->user)->getJson(route('cart.index', [
            'cart' => $this->cart->token
        ]));

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'item_id',
                    'quantity',
                ]
            ]
        ]);
    }

    public function test_if_user_can_show_cart_if_does_not_exist(): void
    {
        $response = $this->getJson(route('cart.index', [
            'cart' => 'jdjvnjnkfnrj'
        ]));

        $response->assertStatus(404);
    }

    public function test_if_user_can_add_item_to_cart(): void
    {
        $response = $this->actingAs($this->user)->postJson(route('cart.add_item', [
            'cartToken' => $this->cart->token
        ]), [
            'item_id' => 1,
            'quantity' => 1
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'cart_token'
        ]);
    }

    public function test_if_user_can_add_item_to_cart_if_cart_does_not_exist(): void
    {
        $response = $this->postJson(route('cart.add_item', [
            'cartToken' => 'jdjvnjnkfnrj'
        ]), [
            'item_id' => 1,
            'quantity' => 1
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'cart_token'
        ]);
    }

    public function test_if_user_can_update_item_in_cart(): void
    {
        $response = $this->actingAs($this->user)->putJson(route('cart.update_item', [
            'cart' => $this->cart->token,
            'cartItem' => $this->cartItem->id
        ]), [
            'item_id' => 1,
            'quantity' => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_if_user_can_update_item_in_cart_if_cart_does_not_exist(): void
    {
        $response = $this->putJson(route('cart.update_item', [
            'cart' => 'jdjvnjnkfnrj',
            'cartItem' => 4
        ]), [
            'item_id' => 1,
            'quantity' => 1
        ]);

        $response->assertStatus(404);
    }

    public function test_if_user_can_update_item_in_cart_if_item_does_not_exist(): void
    {
        $response = $this->putJson(route('cart.update_item', [
            'cart' => $this->cart->token,
            'cartItem' => 2137
        ]), [
            'item_id' => 1,
            'quantity' => 1
        ]);

        $response->assertStatus(404);
    }

    public function test_if_user_can_delete_item_from_cart(): void
    {
        $response = $this->actingAs($this->user)->deleteJson(route('cart.delete_item', [
            'cart' => $this->cart->token,
            'cartItem' => $this->cartItem->id
        ]));

        $response->assertStatus(200);
    }

    public function test_if_user_can_delete_item_from_cart_if_cart_does_not_exist(): void
    {
        $response = $this->deleteJson(route('cart.delete_item', [
            'cart' => 'jdjvnjnkfnrj',
            'cartItem' => 4
        ]));

        $response->assertStatus(404);
    }

    public function test_if_user_can_delete_item_from_cart_if_item_does_not_exist(): void
    {
        $response = $this->deleteJson(route('cart.delete_item', [
            'cart' => $this->cart->token,
            'cartItem' => 2137
        ]));

        $response->assertStatus(404);
    }

    public function test_if_user_can_checkout_cart_if_proper_cart_is_given(): void
    {
        $response = $this->actingAs($this->user)->postJson(route('cart.checkout', [
            'cart' => $this->cart->token,
            'country' => 'Serbia',
            'city' => 'Belgrade',
            'street' => 'Nemanjina',
            'house' => 1,
            'door_number' => 2,
        ]));

        $response->assertStatus(200)->assertJsonStructure(
            [
                'order' => [
                    'id',
                    'user_id',
                    'delivery_address',
                    'status'
                ],
                'order_items' => [
                    '*' => [
                        'id',
                        'order_id',
                        'item_id',
                        'quantity',
                        'price'
                    ]
                ]
            ]
        );
    }

    public function test_if_user_can_checkout_cart_if_cart_does_not_exist(): void
    {
        $response = $this->postJson(route('cart.checkout', [
            'cart' => 'jdjvnjnkfnrj',
            'country' => 'Serbia',
            'city' => 'Belgrade',
            'street' => 'Nemanjina',
            'house' => 1,
            'door_number' => 2,
        ]));

        $response->assertStatus(404);
    }

    public function test_if_cart_checkout_validation_works(): void
    {
        $response = $this->postJson(
            route('cart.checkout', [
                'cart' => $this->cart->token,
                'country' => 1,
                'city' => '',
                'street' => '5',
            ])
        );

        $response->assertStatus(422);
    }

}
