<?php

namespace App\Http\Controllers\Authenticated;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleAuthenticatedController extends Controller
{
    public function createView()
    {
        $categories = Category::get(['id', 'title']);
        $users = User::get(['username', 'is_admin']);
        $articles;

        if (auth()->user()->is_admin == 1) {
            $articles = Article::with('category')->latest()->select(['id', 'category_id', 'title', 'slug', 'thumbnail', 'status', 'view_count', 'created_at'])->simplePaginate(10);
        } else {
            $articles = auth()->user()->articles()->with('category')->latest()->select(['id', 'category_id', 'title', 'slug', 'thumbnail', 'status', 'view_count', 'created_at'])->simplePaginate(10);
        }

        return view('pages.authenticated.article.create', [
            'categories' => $categories,
            'users' => $users,
            'articles' => $articles,
        ]);
    }

    public function createAction(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $thumbnail = Storage::disk('public')->putFileAs('article_thumbnails', $request->file('thumbnail'), Str::slug($request->title) . '.' . $request->file('thumbnail')->getClientOriginalExtension());

        $article = Article::insert([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category,
            'status' => 'draft',
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'thumbnail' => $thumbnail,
            'content' => $request->content,
            'view_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back();
    }

    public function updateView($slug)
    {
        $categories = Category::get(['id', 'title']);
        $article = Article::where('slug', $slug)->first();

        return view('pages.authenticated.article.update', [
            'categories' => $categories,
            'article' => $article,
        ]);
    }

    public function updateAction(Request $request, $slug)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $article = Article::where('slug', $slug)->first();

        if ($request->thumbnail != null) {
            Storage::disk('public')->delete($article->thumbnail);
            $thumbnail = Storage::disk('public')->putFileAs('article_thumbnails', $request->file('thumbnail'), Str::slug($request->title) . '.' . $request->file('thumbnail')->getClientOriginalExtension());

            $article->update([
                'title' => $request->title,
                'category_id' => $request->category,
                'thumbnail' => $thumbnail,
                'content' => $request->content,
            ]);
        } else {
            $article->update([
                'title' => $request->title,
                'category_id' => $request->category,
                'content' => $request->content,
            ]);
        }

        return redirect()->route('article.create.view');
    }

    public function deleteAction($slug)
    {
        $article = Article::where('slug', $slug)->first();

        Storage::disk('public')->delete($article->thumbnail);
        $article->delete();

        return redirect()->back();
    }

    public function publishAction($slug)
    {
        $article = Article::where('slug', $slug)->first();

        $article->update([
            'status' => 'publish',
        ]);

        return redirect()->back();
    }
}
