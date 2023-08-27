<?php

namespace Tests\Feature\Article;

use Tests\TestCase;

class ArticleListTest extends TestCase
{
    /** @test */
    public function it_list_article(): void
    {
        $this->asAdmin();
        $response = $this->get('/api/article');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_dont_list_article_when_user_dont_have_permission(): void
    {
        $this->asUser();
        $response = $this->get('/api/article');
        $response->assertStatus(403);
    }
}
