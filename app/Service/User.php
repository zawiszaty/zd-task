<?php

namespace App\Service;

use App\Repository\Users;
use Illuminate\Contracts\Support\Arrayable;

class User
{
    public function __construct(private readonly Users $users)
    {
    }

    public function list(int $perPage): Arrayable
    {
        return $this->users->list($perPage);
    }

    public function edit(int $userId, array $roles): void
    {
        $user = $this->users->find($userId);
        $user->syncRoles($roles);
        $this->users->save($user);
    }

    public function find(int $userId): \App\Models\User
    {
        return $this->users->find($userId);
    }
}
