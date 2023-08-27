<?php

namespace App\Repository;

use App\Models\Article;
use App\Models\ResetCodePassword;
use Illuminate\Contracts\Support\Arrayable;

interface ResetCodePasswords
{
    public function save(ResetCodePassword $codePassword): void;

    public function remove(ResetCodePassword $codePassword): void;

    public function find(int $id): ResetCodePassword;

    public function findByEmail(string $email): ResetCodePassword;
    public function findByCode(string $code): ResetCodePassword;
    public function list(int $perPage = 10): Arrayable;
}
