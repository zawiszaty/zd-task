<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RemoveArticleTest extends TestCase
{
    /** @test */
    public function it_remove_article(): void
    {
        Storage::fake('public');

        $this->asAdmin();
        $article = Article::factory()->create();
        $response = $this->deleteJson('/api/article/' . $article->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('articles', [
            'title' => $article->title,
        ]);
    }
}
