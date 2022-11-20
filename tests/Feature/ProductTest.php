<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_authenticated_user_can_see_all_products(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('products.index'));

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price',
                    'categories',
                ]
            ]
        ]);
    }

    public function test_if_unauthenticated_user_can_not_see_all_products(): void
    {
        $response = $this->getJson(route('products.index'));

        $response->assertStatus(401);
    }

    public function test_if_authenticated_user_can_see_single_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('products.show', 1));

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'name',
            'description',
            'price',
            'categories',
        ]);
    }

    public function test_if_unauthenticated_user_can_not_see_single_product(): void
    {
        $response = $this->getJson(route('products.show', 1));

        $response->assertStatus(401);
    }

    public function test_if_error_is_returned_when_product_does_not_exist(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('products.show', 2137));

        $response->assertStatus(404);
    }

    public function test_if_authenticated_user_can_create_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('products.store'), [
            'name' => 'test',
            'description' => 'test',
            'price' => 10,
            'category_id' => 1,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'name',
            'description',
            'price',
            'categories',
        ]);
    }

    public function test_if_unauthenticated_user_can_not_create_product(): void
    {
        $response = $this->postJson(route('products.store'), [
            'name' => 'test',
            'description' => 'test',
            'price' => 10,
            'category_id' => 1,
        ]);

        $response->assertStatus(401);
    }

    public function test_if_validation_works_when_creating_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('products.store'), [
            'name' => 7837,
            'description' => 1234,
            'price' => 'test',
            'category_id' => 'test',
        ]);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_if_authenticated_user_can_update_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route('products.update', 1), [
            'name' => 'test',
            'description' => 'test',
            'price' => 10,
            'category_id' => 1,
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'name',
            'description',
            'price',
            'categories',
        ]);
    }

    public function test_if_unauthenticated_user_can_not_update_product(): void
    {
        $response = $this->putJson(route('products.update', 1), [
            'name' => 'test',
            'description' => 'test',
            'price' => 10,
            'category_id' => 1,
        ]);

        $response->assertStatus(401);
    }

    public function test_if_error_is_returned_when_product_does_not_exist_when_updating(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route('products.update', 2137), [
            'name' => 'test',
            'description' => 'test',
            'price' => 10,
            'category_id' => 1,
        ]);

        $response->assertStatus(404);
    }

    public function test_if_validation_works_when_updating_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route('products.update', 1), [
            'name' => 7837,
            'description' => 1234,
            'price' => 'test',
            'category_id' => 'test',
        ]);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_if_authenticated_user_can_delete_product(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('products.destroy', 1));

        $response->assertStatus(200);
    }

    public function test_if_unauthenticated_user_can_not_delete_product(): void
    {
        $response = $this->deleteJson(route('products.destroy', 1));

        $response->assertStatus(401);
    }

    public function test_if_error_is_returned_when_product_does_not_exist_when_deleting(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('products.destroy', 2137));

        $response->assertStatus(404);
    }

    public function test_if_authenticated_user_can_delete_product_from_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patchJson(route('products.deleteFromCategory', 1), [
            'category_id' => 1,
        ]);

        $response->assertStatus(200);
    }

    public function test_if_unauthenticated_user_can_not_delete_product_from_category(): void
    {
        $response = $this->patchJson(route('products.deleteFromCategory', 1), [
            'category_id' => 1,
        ]);

        $response->assertStatus(401);
    }

    public function test_if_error_is_returned_when_product_does_not_exist_when_deleting_from_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patchJson(route('products.deleteFromCategory', 2137), [
            'category_id' => 1,
        ]);

        $response->assertStatus(404);
    }

    public function test_if_error_is_returned_when_category_does_not_exist_when_deleting_from_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patchJson(route('products.deleteFromCategory', 1), [
            'category_id' => 2137,
        ]);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

}
