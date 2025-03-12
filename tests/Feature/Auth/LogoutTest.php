<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\ApiTestCase;
use Laravel\Sanctum\Sanctum;

class LogoutTest extends ApiTestCase
{
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logged out succesfully']);
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }
}   