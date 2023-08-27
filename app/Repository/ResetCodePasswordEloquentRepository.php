<?php

namespace App\Repository;

use App\Models\ResetCodePassword;
use Illuminate\Contracts\Support\Arrayable;

class ResetCodePasswordEloquentRepository implements ResetCodePasswords
{
    public function save(ResetCodePassword $codePassword): void
    {
        $codePassword->save();
    }

    public function find(int $id): ResetCodePassword
    {
        return ResetCodePassword::findOrFail($id);
    }

    public function list(int $perPage = 10): Arrayable
    {
        return ResetCodePassword::paginate($perPage);
    }

    public function remove(ResetCodePassword $codePassword): void
    {
        $codePassword->delete();
    }

    public function findByEmail(string $email): ResetCodePassword
    {
        return ResetCodePassword::where('email', $email)->first();
    }

    public function findByCode(string $code): ResetCodePassword
    {
        return ResetCodePassword::firstWhere('code', $code);
    }
}
