<?php

namespace Tests\Feature\Auth;

use Tests\ApiTestCase;
use App\Models\User;
use App\Models\Link;

class UpdateOrderTest extends ApiTestCase
{
    public function test_update_the_order()
    {
        $user = User::factory()->create();

        $link = Link::factory()->create([
            'user_id' => $user->id,
            'title' => 'Example Title',
            'url' => 'https://example.com',
            'order' => 1
        ]);

        $this->actingAs($user);

        $newOrder = 2;

        $response = $this->putJson("api/profile/links/{$link->id}/order", [
            'order' => $newOrder,
        ]);

        $response->assertStatus(200);

    }

    public function test_update_with_invalid_order()
    {
        $user = User::factory()->create();

        $link = Link::factory()->create([
            'user_id' => $user->id,
            'title' => 'Example Title',
            'url' => 'https://example.com',
            'order' => 1
        ]);

        $this->actingAs($user);

        $response = $this->putJson("/api/profile/links/{$link->id}/order", [
            'order' => 'Not an integer'
        ]);

        $response->assertStatus(422);
    }

    public function test_update_order_unauthenticated()
    {
        $user = User::factory()->create();

        $link = Link::factory()->create([
            'user_id' => $user->id,
            'title' => 'Example Title',
            'url' => 'https://example.com',
            'order' => 1
        ]);

        $newOrder = 2;

        $response = $this->putJson("/api/profile/links/{$link->id}/order", [
            'order' => $newOrder
        ]);

        $response->assertStatus(401);
    }
}
