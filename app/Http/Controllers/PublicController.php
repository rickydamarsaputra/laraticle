<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::get(['id', 'title', 'slug']);

        return view('pages.public.index', [
            'categories' => $categories,
        ]);
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();

        $article->update([
            'view_count' => $article->view_count + 1,
        ]);

        return view('pages.public.article', [
            'article' => $article,
        ]);
    }
}
