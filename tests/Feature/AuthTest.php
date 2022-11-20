<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_can_show_user_data_when_authenticated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('user'));

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'email',
            'email_verified_at',
        ]);
    }

    public function test_if_cannot_show_user_data_when_unauthenticated(): void
    {
        $response = $this->getJson(route('user'));

        $response->assertStatus(401);
    }

    public function test_if_user_can_log_in_with_proper_data(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'user',
            'token'
        ]);
    }

    public function test_if_user_can_not_log_in_with_wrong_data(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'wrong@gmail.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'status'
        ]);
    }

    public function test_if_login_validation_works(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'test',
            'password' => '',
        ]);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_if_user_can_register_with_proper_data(): void
    {
        $response = $this->postJson(route('register'), [
            'email' => 'test@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'user'
        ]);
    }

    public function test_if_register_validation_works(): void
    {
        $response = $this->postJson(route('register'), [
            'email' => 'test',
            'password' => 'pad',
            'password_confirmation' => 'passwod',
        ]);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_if_user_can_log_out(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('logout'));

        $response->assertStatus(200);
    }

    public function test_if_user_can_not_log_out_if_not_logged_in(): void
    {
        $response = $this->getJson(route('logout'));

        $response->assertStatus(401);
    }
}
