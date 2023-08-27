<?php

namespace App\Repository;

use App\Models\Article;
use Illuminate\Contracts\Support\Arrayable;

class ArticlesEloquentRepository implements Articles
{
    public function save(Article $article): void
    {
        $article->save();
    }

    public function find(int $id): Article
    {
        return Article::findOrFail($id);
    }

    public function list(int $perPage = 10): Arrayable
    {
        return Article::paginate($perPage);
    }

    public function remove(Article $article): void
    {
        $article->delete();
    }
}
