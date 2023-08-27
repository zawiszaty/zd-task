<?php

namespace Tests\Feature\User;

use App\Models\ResetCodePassword;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\User;

class CodeCheckTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_reset_password_with_valid_code()
    {
        $user = User::factory()->create();
        $data['code'] = mt_rand(100000, 999999);
        $data['email'] = $user->email;
        $data['created_at'] = new \DateTime();

        $passwordReset = ResetCodePassword::create($data);
        $passwordReset->save();

        $response = $this->postJson('/api/user/code-check', [
            'code' => (string)$data['code'],
            'password' => 'newpassword',
        ]);

        $response->assertStatus(200)
            ->assertExactJson(['status' => 'ok']);

        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));

        $this->assertDatabaseMissing('reset_code_passwords', ['email' => $user->email]);
    }

    /** @test */
    public function it_deletes_reset_code_if_expired()
    {
        $user = User::factory()->create();
        $data['code'] = mt_rand(100000, 999999);
        $data['email'] = $user->email;
        $data['created_at'] = Carbon::now()->addHours(4);

        $passwordReset = ResetCodePassword::create($data);
        $passwordReset->save();
        $response = $this->postJson('/api/user/code-check', [
            'code' => (string)$passwordReset->code,
            'password' => 'newpassword',
        ]);

        $response->assertStatus(422)
            ->assertExactJson(['message' => 'password code expired']);

        $this->assertDatabaseMissing('reset_code_passwords', ['email' => $passwordReset->email]);
    }
}
