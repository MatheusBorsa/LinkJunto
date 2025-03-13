<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\WithFaker;

class UpdateUserTest extends ApiTestCase
{

    use WithFaker;

    public function test_update_user_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $updateData = [
            'bio' => 'This is my updated bio',
            'profile_picture' => 'https://example.com/profile.jpg'
        ];

        $response = $this->json('PUT', '/api/profile/update', $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'bio' => 'This is my updated bio',
                     'profile_picture' => 'https://example.com/profile.jpg'
                 ]);
    }

    public function test_update_user_profile_with_invalid_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $invalidData = [
            'bio' => 'This is my updated bio',
            'profile_picture' => 'not-a-valid-url'
        ];

        $response = $this->json('PUT', '/api/profile/update', $invalidData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['profile_picture']);

    }

    public function test_update_user_profile_without_authentication()
    {
        $updateData = [
            'bio' => 'This is my updated bio',
            'profile_picture' => 'https://example.com/profile.jpg'
        ];

        $response = $this->json('PUT', '/api/profile/update', $updateData);

        $response->assertStatus(401);
    }
}
