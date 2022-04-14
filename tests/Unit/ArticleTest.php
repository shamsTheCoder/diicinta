<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Arr;
use App\Models\Article;
use App\Http\Controllers\Api\ArticleController;

class ArticleTest extends TestCase
{
    private $articleId = null;
    private $inputs = [
        'title'        => 'New photography exhibition',
        'content'      => 'In a new exhibition at the Royal Botanic Garden Edinburgh, famous photographer explores the astonishing diversity of nature.',
        'author'       => 'Oscar Davies',
        'category'     => 'Nature',
        'published_at' => '2020-02-10',
    ];

    public function test_article_post()
    {
        $response = $this->postJson(
            action([ArticleController::class, 'create']),
            $this->inputs
        )->assertStatus(201)->getOriginalContent();

        $this->articleId = $response['id'];
    }

    public function test_articles_get()
    {
        $response = $this->getJson(
            action([ArticleController::class, 'getAll']),
            $this->inputs
        )->assertStatus(200)->getOriginalContent();

        $articles = Article::all();

        $this->assertEquals($response, $articles);
    }

    public function test_article_post_title_empty()
    {
        $reqData = array_merge($this->inputs, ['title' => null]);
        $response = $this->postJson(
            action([ArticleController::class, 'create']),
            $reqData
        )->assertStatus(400);

        $this->assertEquals($response['errMsg'], 'MandatoryFieldsNotComplete');
    }

    public function test_article_post_content_empty()
    {
        $reqData = array_merge($this->inputs, ['content' => null]);
        $response = $this->postJson(
            action([ArticleController::class, 'create']),
            $reqData
        )->assertStatus(400);

        $this->assertEquals($response['errMsg'], 'MandatoryFieldsNotComplete');
    }

    public function test_article_post_author_empty()
    {
        $reqData = array_merge($this->inputs, ['author' => null]);
        $response = $this->postJson(
            action([ArticleController::class, 'create']),
            $reqData
        )->assertStatus(400);

        $this->assertEquals($response['errMsg'], 'MandatoryFieldsNotComplete');
    }

    public function test_article_post_publish_at_empty()
    {
        $reqData = array_merge($this->inputs, ['published_at' => null]);
        $response = $this->postJson(
            action([ArticleController::class, 'create']),
            $reqData
        )->assertStatus(400);

        $this->assertEquals($response['errMsg'], 'MandatoryFieldsNotComplete');
    }

    public function test_article_get_by_id_not_found()
    {
        $response = $this->call('get','/api/articles/abc')->assertStatus(404)->getOriginalContent();

        $this->assertEquals($response['errMsg'], 'ArticleDoesnotExists');
    }

    public function test_article_update_by_id_not_found()
    {
        $response = $this->putJson(
            action([ArticleController::class, 'update'], 'abc'),
            $this->inputs
        )->assertStatus(404);

        $this->assertEquals($response['errMsg'], 'ArticleDoesnotExists');
    }

    public function test_article_update_content_empty()
    {
        $reqData = array_merge($this->inputs, ['content' => null]);

        $article = Article::first();
        $response = $this->putJson(
            action([ArticleController::class, 'update'], $article->id),
            $reqData
        )->assertStatus(400);

        $this->assertEquals($response['errMsg'], 'MandatoryFieldsNotComplete');
    }

    public function test_article_update_author_empty()
    {
        $reqData = array_merge($this->inputs, ['author' => null]);

        $article = Article::first();
        $response = $this->putJson(
            action([ArticleController::class, 'update'], $article->id),
            $reqData
        )->assertStatus(400);
    }

    public function test_article_update_publish_at_empty()
    {
        $reqData = array_merge($this->inputs, ['published_at' => null]);

        $article = Article::first();
        $response = $this->putJson(
            action([ArticleController::class, 'update'], $article->id),
            $reqData
        )->assertStatus(400);
    }

    public function test_article_delete_not_found()
    {
        $response = $this->deleteJson(
            action([ArticleController::class, 'delete'], 'abc')
        )->assertStatus(404)->getOriginalContent();

        $this->assertEquals($response['errMsg'], 'ArticleDoesnotExists');
    }

    public function test_article_delete()
    {
        $article = Article::first();
        $response = $this->deleteJson(
            action([ArticleController::class, 'delete'], $article->id)
        )->assertOk();
    }
}
