<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Validator;

class ArticleController extends Controller
{
    public function create(Request $request)
    {
        #write your code for article creation here...
        #model name = Article
        #table name = article
        #table fields = id,title,content,author,category,published_at
        #all fields are required
       $request->validate([
           'title' => 'required|max:30',
           'content' => 'required',
           'author' => 'required',
           'category' => 'required',
           'published_on' => 'required'
       ]);

        $article = Article::create($request->all());
        return response()->json($article, 201);
    }

    public function getAll()
    {
        #write your code to get all articles...
        #model name = Article
        #table name = article
        #table fields = id,title,content,author,category,published_at
        return Article::all();
    }

    public function get(Article $article)
    {
        #write your code to get all article specific by id...
        #model name = Article
        #table name = article
        #table fields = id,title,content,author,category,published_at
      return $article;

    }

    public function update(Request $request, $articleId)
    {
        #write your code to update article specific by id...
        #model name = Article
        #table name = article
        #table fields = id,title,content,author,category,published_at
        $articleId->update($request->all());
        return response()->json($articleId, 200);
    }

    public function delete(Article $article)
    {
        #write your code to delete article specific by id...
        #model name = Article
        #table name = article
        #table fields = id,title,content,author,category,published_at
        $article->delete();
        return response()->json(null, 204);
    }
}
