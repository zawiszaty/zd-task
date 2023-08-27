<?php

namespace App\Repository;

use App\Models\Article;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Pagination\LengthAwarePaginator;

interface Articles
{
    public function save(Article $article): void;

    public function remove(Article $article): void;

    public function find(int $id): Article;

    public function list(int $perPage = 10): Arrayable;
}
