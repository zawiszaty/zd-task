<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserLoginTest extends TestCase
{
    public function testWhenUserIsLoggedSuccess(): void
    {
        $response = $this->post('/api/user/login', ['email' => 'admin@example.com', 'password' => 'password']);

        $response->assertStatus(200);
    }

    public function testWhenUserHaveWrongPassword(): void
    {
        $response = $this->post('/api/user/login', ['email' => 'admin@example.com', 'password' => 'passwordWrong']);

        $response->assertStatus(401)->assertJson([
            'status' => false,
            'errors' => [
                'Email & Password does not match with our record.'
            ]
        ]);
    }
}
