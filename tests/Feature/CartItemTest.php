<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Cart_item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class CartItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_authenticated_user_can_see_all_cart_items(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('cart_items.index'));

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

    public function test_if_unauthenticated_user_cannot_see_all_cart_items(): void
    {
        $response = $this->getJson(route('cart_items.index'));

        $response->assertStatus(401);
    }

    public function test_if_authenticated_user_can_create_a_cart_item(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('cart_items.store'), [
            'item_id' => 1,
            'quantity' => 1,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'item_id',
            'quantity',
        ]);
    }

    public function test_if_unauthenticated_user_cannot_create_a_cart_item(): void
    {
        $response = $this->postJson(route('cart_items.store'), [
            'item_id' => 1,
            'quantity' => 1,
        ]);

        $response->assertStatus(401);
    }

    public function test_if_authenticated_user_can_see_a_cart_item(): void
    {
        $user = User::factory()
            ->has(Cart::factory()
                ->has(Cart_item::factory()->count(1), 'cart_items'), 'cart')
            ->create();

        $response = $this->actingAs($user)->getJson(route('cart_items.show', 1));

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'item_id',
            'quantity',
        ]);
    }

    public function test_if_unauthenticated_user_cannot_see_a_cart_item(): void
    {
        $response = $this->getJson(route('cart_items.show', 1));

        $response->assertStatus(401);
    }

    public function test_if_authenticated_user_can_update_a_cart_item(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route('cart_items.update', 1), [
            'item_id' => 1,
            'quantity' => 1,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'item_id',
            'quantity',
        ]);
    }

    public function test_if_unauthenticated_user_cannot_update_a_cart_item(): void
    {
        $response = $this->putJson(route('cart_items.update', 1), [
            'item_id' => 1,
            'quantity' => 1,
        ]);

        $response->assertStatus(401);
    }

    public function test_if_authenticated_user_can_delete_a_cart_item(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('cart_items.destroy', 1));

        $response->assertStatus(200);
    }

    public function test_if_unauthenticated_user_cannot_delete_a_cart_item(): void
    {
        $response = $this->deleteJson(route('cart_items.destroy', 1));

        $response->assertStatus(401);
    }

}
