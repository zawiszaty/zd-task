<?php

namespace Tests\Feature\User;

use App\Jobs\SendForgotPasswordMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Mail\ForgotPasswordMail;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_send_forgot_password_email()
    {
        Queue::fake([
            SendForgotPasswordMail::class,
            SendForgotPasswordMail::class,
        ]);

        $response = $this->postJson('/api/user/forgot-password', ['email' => 'user@example.com']);

        $response->assertStatus(200)
            ->assertExactJson(['status' => 'ok']);
        Queue::assertPushed(SendForgotPasswordMail::class, 1);
    }

    /** @test */
    public function it_requires_email()
    {
        $response = $this->postJson('/api/user/forgot-password', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
