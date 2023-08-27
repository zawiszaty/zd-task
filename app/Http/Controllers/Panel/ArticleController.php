<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\ArticleCreate;
use App\Http\Requests\Article\ArticleEdit;
use App\Models\Article;
use App\Repository\Articles;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function __construct(private readonly Articles $articles)
    {
    }

    public function list(Request $request): Response
    {
        $articles = $this->articles->list($request->get('perPage', 10));

        return response()->json(['articles' => $articles]);
    }

    public function add(ArticleCreate $request): Response
    {
        $request->validated();
        $image_path = $request->file('thumbnail')->store('thumbnail', 'public');
        $article = new Article([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'thumbnail' => $image_path,
            'user_id' => $request->get('id'),
        ]);
        $this->articles->save($article);

        return response()->json($article, Response::HTTP_CREATED);
    }

    public function edit(ArticleEdit $request, int $articleId): Response
    {
        $article = Article::findOrFail($articleId);
        $request->validated();
        $image_path = $request->file('thumbnail')->store('thumbnail', 'public');
        $article->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'thumbnail' => $image_path,
            'user_id' => $request->get('id'),
        ]);
        $this->articles->save($article);

        return response()->json($article, Response::HTTP_CREATED);
    }

    public function remove(int $articleId): Response
    {
        $article = $this->articles->find($articleId);
        $this->articles->remove($article);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
