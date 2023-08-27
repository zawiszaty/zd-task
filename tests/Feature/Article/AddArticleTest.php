<?php

namespace Tests\Feature\Article;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AddArticleTest extends TestCase
{
    /** @test */
    public function it_add_article(): void
    {
        Storage::fake('public');

        $this->asModerator();
        $response = $this->post('/api/article', [
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
    public function it_validate_article_fields(): void
    {
        $this->asModerator();
        $response = $this->post('/api/article');

        $response->assertStatus(422);
    }

    /** @test */
    public function it_validate_user_permission(): void
    {
        $this->asUser();
        $response = $this->post('/api/article');

        $response->assertStatus(403);
    }
}
