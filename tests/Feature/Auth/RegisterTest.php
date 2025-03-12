<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterTest extends ApiTestCase
{
    use WithFaker;

    public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'theme' => 'light',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['user', 'token']);
    }

    public function test_user_registration_validation_errors(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'username' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
            'theme' => '',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'username', 'email', 'password']);
    }

    public function test_user_registration_duplicate_email_or_username(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'username' => 'testuser',
            'theme' => 'light',
        ]);

        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'theme' => 'light',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'username']);
    }
}