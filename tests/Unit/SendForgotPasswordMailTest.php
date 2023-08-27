<?php

namespace Tests\Unit;

use App\Jobs\SendForgotPasswordMail;
use App\Mail\ForgotPassword;
use App\Models\ResetCodePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendForgotPasswordMailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_forgot_password_email_with_code()
    {
        Mail::fake();

        $email = 'test@example.com';
        (new SendForgotPasswordMail($email))->handle();
        Mail::assertQueued(ForgotPassword::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });

        $this->assertDatabaseHas('reset_code_passwords', ['email' => $email]);
    }

    /** @test */
    public function it_deletes_existing_reset_code_for_email()
    {
        $existingCode = ResetCodePassword::factory()->create();
        SendForgotPasswordMail::dispatch($existingCode->email);

        $this->assertDatabaseMissing('reset_code_passwords', ['email' => $existingCode->email]);
    }

    /** @test */
    public function it_creates_new_reset_code()
    {
        $email = 'test@example.com';

        SendForgotPasswordMail::dispatch($email);

        $this->assertDatabaseHas('reset_code_passwords', ['email' => $email]);
    }
}
