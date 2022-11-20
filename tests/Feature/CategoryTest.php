<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_if_authenticated_user_can_see_all_categories(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('categories.index'));

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ]
            ]
        ]);
    }

    public function test_if_unauthenticated_user_cannot_see_all_categories(): void
    {
        $response = $this->getJson(route('categories.index'));

        $response->assertStatus(401);
    }

    public function test_if_authenticated_user_can_create_a_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('categories.store'), [
            'name' => 'Test Category',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'name',
        ]);
    }

    public function test_if_unauthenticated_user_cannot_create_a_category(): void
    {
        $response = $this->postJson(route('categories.store'), [
            'name' => 'Test Category',
        ]);

        $response->assertStatus(401);
    }

    public function test_if_authenticated_user_can_see_a_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('categories.show', 1));

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'name',
        ]);
    }

    public function test_if_unauthenticated_user_cannot_see_a_category(): void
    {
        $response = $this->getJson(route('categories.show', 1));

        $response->assertStatus(401);
    }

    public function test_if_error_is_thrown_when_category_does_not_exist(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('categories.show', 2137));

        $response->assertStatus(404);
    }

    public function test_if_authenticated_user_can_update_a_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route('categories.update', 1), [
            'name' => 'Test Category',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'name',
        ]);
    }

    public function test_if_unauthenticated_user_cannot_update_a_category(): void
    {
        $response = $this->putJson(route('categories.update', 1), [
            'name' => 'Test Category',
        ]);

        $response->assertStatus(401);
    }

    public function test_if_error_is_thrown_when_updating_category_that_does_not_exist(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route('categories.update', 2137), [
            'name' => 'Test Category',
        ]);

        $response->assertStatus(404);
    }

    public function test_if_validation_error_is_thrown_when_updating_category_with_invalid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route('categories.update', 1), [
            'name' => '',
        ]);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);
    }

    public function test_if_authenticated_user_can_delete_a_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route('categories.destroy', 1));

        $response->assertStatus(200);
    }

    public function test_if_unauthenticated_user_cannot_delete_a_category(): void
    {
        $response = $this->deleteJson(route('categories.destroy', 1));

        $response->assertStatus(401);
    }
}
