<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class EditUserRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_edit_user_roles(): void
    {
        $this->asAdmin();
        $user = User::where('email', 'user@example.com')->first();

        $roles = ['admin', 'user'];
        $response = $this->patchJson("/api/user/{$user->id}", ['roles' => $roles]);

        $response->assertStatus(200)
            ->assertJsonStructure(['user'])
            ->assertJsonFragment(['id' => $user->id]);

        $this->assertTrue($user->fresh()->hasAllRoles($roles));
    }

    /** @test */
    public function it_returns_404_for_nonexistent_user(): void
    {
        $this->asAdmin();

        $response = $this->patchJson("/api/user/9999", ['roles' => ['role1', 'role2']]);

        $response->assertStatus(404);
    }

    public function it_returns_401_for_non_admin_user(): void
    {
        $this->asModerator();

        $response = $this->patchJson("/api/user/9999", ['roles' => ['role1', 'role2']]);

        $response->assertStatus(401);
    }
}
