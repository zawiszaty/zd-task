<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;
    protected $seed = true;


    public function asAdmin(): void
    {
        Sanctum::actingAs(User::where('email', 'admin@example.com')->first());
    }

    public function asModerator(): void
    {
        Sanctum::actingAs(User::where('email', 'moderator@example.com')->first());
    }

    public function asUser(): void
    {
        Sanctum::actingAs(User::where('email', 'user@example.com')->first());
    }
}
