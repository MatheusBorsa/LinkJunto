<?php

namespace Tests\Feature\Auth;

use Tests\ApiTestCase;
use App\Models\User;

class CreateLinkTest extends ApiTestCase
{
    public function test_creating_valid_link()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'title' => 'Example Title',
            'url' => 'https://example.com',
            'order' => 1
        ];

        $response = $this->postJson('/api/profile/links', $data);

        $response->assertStatus(201);

        $response->assertJson([
            'title' => 'Example Title',
            'url' => 'https://example.com',
            'order' => 1
        ]);
    }

    public function test_creating_invalid_link()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'title' => '',
            'url' => 'Not a Valid url',
            'order' => 'Not a Integer'
        ];

        $response = $this->postJson('/api/profile/links', $data);

        $response->assertStatus(422);

    }

    public function test_creating_link_unauthenticated()
    {
        $data = [
            'title' => 'Example title',
            'url' => 'https://example.com',
            'order' => 1
        ];

        $response = $this->postJson('api/profile/links', $data);

        $response->assertStatus(401);
    }
}
