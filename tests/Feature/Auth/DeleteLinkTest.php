<?php

namespace Tests\Feature\Auth;

use Tests\ApiTestCase;
use App\Models\User;
use App\Models\Link;

class DeleteLinkTest extends ApiTestCase
{
    public function test_user_can_delete_link()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $link = Link::factory()->create([
            'user_id' => $user->id,
            'title' => 'Example Title',
            'url' => 'https://example.com',
            'order' => 1
        ]);

        $response = $this->deleteJson("/api/profile/links/{$link->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Link deleted succesfully']);
    }

    public function test_unauthenticated_user_cant_delete_link()
    {
        $user = User::factory()->create();

        $link = Link::factory()->create([
            'user_id' => $user->id,
            'title' => 'Example Title',
            'url' => 'https://example.com',
            'order' => 1
        ]);

        $response = $this->deleteJson("/api/profile/links/{$link->id}");

        $response->assertStatus(401);
    }
}
