<?php

namespace App\Repository;

use App\Models\Article;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\LengthAwarePaginator;

interface Users
{
    public function save(User $user): void;

    public function remove(User $user): void;

    public function find(int $id): User;

    public function findByEmail(string $email): User;

    public function list(int $perPage = 10): Arrayable;
}
