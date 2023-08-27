<?php

namespace App\Repository;

use App\Exceptions\UserNotFound;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class UsersEloquentRepository implements Users
{
    public function save(User $user): void
    {
        $user->save();
    }

    public function find(int $id): User
    {
        return User::findOrFail($id);
    }

    public function list(int $perPage = 10): Arrayable
    {
        return User::paginate($perPage);
    }

    public function remove(User $user): void
    {
        $user->delete();
    }

    public function findByEmail(string $email): User
    {
        $user =  User::where('email', $email)->first();

        if (!$user) {
            throw new UserNotFound();
        }

        return $user;
    }
}
