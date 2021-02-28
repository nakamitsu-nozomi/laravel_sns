<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\ArticleRequest;
use App\Http\Requests\ArticleRequest as RequestsArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {

        $articles = Article::all()->sortByDesc("created_at");
        return view("articles.index", ["articles" => $articles]);
    }
    public function create()
    {
        return view("articles.create");
    }
    public function store(RequestsArticleRequest $request, Article $article)
    {
        $article->fill($request->all());
        $article->user_id = $request->user()->id;
        $article->save();
        return redirect()->route("articles.index");
    }
}
