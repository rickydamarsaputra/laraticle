<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleApiController extends Controller
{
    public function getAllArticles(Request $request)
    {
        $articles = Article::with(['category:id,title,slug']);

        if ($request->has('q')) {
            $articles = $articles->where('title', 'like', '%' . $request->q . '%');
        }

        if ($request->has('category') && $request->category != 'semua') {
            $articles = $articles->where('category_id', '=', $request->category);
        }

        $articles = $articles->where('status', 'publish')->latest()->select(['category_id', 'title', 'slug', 'thumbnail', 'created_at'])->take($request->take ?? 6)->get();
        return response()->json($articles);
    }
}
