<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Article;

class ArticleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_article_post()
    {
        $response1 = $this->post('/api/articles', [
            'title'        => 'New photography exhibition',
            'content'      => 'In a new exhibition at the Royal Botanic Garden Edinburgh, famous photographer explores the astonishing diversity of nature.',
            'author'       => 'Oscar Davies',
            'category'     => 'Nature',
            'published_at' => '2020-02-10',
        ])->assertStatus(201)->getOriginalContent();

        $this->assertDatabaseHas('article', [
            'title'        => $response1['title'],
            'content'      => $response1['content'],
            'author'       => $response1['author'],
            'category'     => $response1['category'],
            'published_at' => $response1['published_at'],
        ]);

        $response2 = $this->post('/api/articles', [
            'title'        => 'New photography exhibition part 2',
            'content'      => 'In a new exhibition at the Royal Botanic Garden Edinburgh, famous photographer explores the astonishing diversity of nature part 2.',
            'author'       => 'Oscar Davies',
            'category'     => 'Nature',
            'published_at' => '2020-02-12',
        ])->assertStatus(201)->getOriginalContent();

        $this->assertDatabaseHas('article', [
            'title'        => $response2['title'],
            'content'      => $response2['content'],
            'author'       => $response2['author'],
            'category'     => $response2['category'],
            'published_at' => $response2['published_at'],
        ]);

        $this->assertEquals($response1['id'], $response2['id'] - 1);
    }

     public function test_articles_get()
    {
        $response = $this->get('/api/articles')->assertStatus(200)->getOriginalContent();
        $articles = Article::all();

        $this->assertEquals($response, $articles);
    }

    public function test_by_id_get()
    {
		$article = Article::first();

        $response = $this->get('/api/articles/'.$article->id)->assertStatus(200)->getOriginalContent();

        $this->assertEquals($response, $article);

        $response = $this->get('/api/articles/99999')->assertStatus(404)->getOriginalContent();
    }

    public function test_by_id_update()
    {
		$article = Article::first();

        $response = $this->put('/api/articles/'.$article->id, [
            'title'        => 'New photography exhibition part 3',
            'content'      => 'In a new exhibition at the Royal Botanic Garden Edinburgh, famous photographer explores the astonishing diversity of nature part 3.',
            'author'       => 'Oscar Davies',
            'category'     => 'Nature',
            'published_at' => '2020-02-10',
        ])->assertStatus(200)->getOriginalContent();
    }

    public function test_by_id_delete()
    {
		$article = Article::first();

        $this->delete('/api/articles/'.$article->id)->assertOk();
    }
}
