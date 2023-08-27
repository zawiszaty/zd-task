<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ListUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_users_with_default_pagination()
    {
        $this->asAdmin();
        User::factory(15)->create();

        $response = $this->getJson("/api/user");

        $response->assertStatus(200)
            ->assertJsonStructure(['user'])
            ->assertJsonCount(10, 'user.data');
    }

    /** @test */
    public function it_can_list_users_with_custom_pagination()
    {
        $this->asAdmin();
        User::factory(15)->create();

        $response = $this->getJson("/api/user?per_page=5");

        $response->assertStatus(200)
            ->assertJsonStructure(['user'])
            ->assertJsonCount(5, 'user.data');
    }
}
