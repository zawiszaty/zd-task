<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register_a_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/user/register', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'email', 'created_at', 'updated_at']);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);

        $this->assertTrue(Hash::check('password123', User::where('email', 'john@example.com')->first()->password));
    }

    /** @test */
    public function it_requires_name_email_and_password()
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422);
    }
}
