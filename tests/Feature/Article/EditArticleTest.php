<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EditArticleTest extends TestCase
{
    /** @test */
    public function it_edit_article(): void
    {
        Storage::fake('public');
        $this->asModerator();
        $article = Article::factory()->create();

        $response = $this->patch('/api/article/' . $article->id, [
            'title' => 'Test Title',
            'content' => 'Test Content',
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
            'id' => 1,
        ]);

        $response->assertStatus(201)->assertJson([
            'title' => 'Test Title',
            'content' => 'Test Content',
            'user_id' => 1,
        ]);
        $this->assertDatabaseHas('articles', [
            'title' => 'Test Title',
        ]);
        Storage::disk('public')->assertExists($response['thumbnail']);
    }

    /** @test */
    public function it_test_article_validation(): void
    {
        $this->asModerator();
        $article = Article::factory()->create();

        $response = $this->patch('/api/article/' . $article->id);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_test_user_permission(): void
    {
        $this->asUser();
        $article = Article::factory()->create();

        $response = $this->patch('/api/article/' . $article->id);

        $response->assertStatus(403);
    }
}
