<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Services\ThemeResolver;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::published()->with(['category', 'coverImage', 'author', 'tags'])->latest('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        if ($request->filled('q')) {
            $term = '%' . $request->q . '%';
            $query->where(fn($q) => $q->where('title', 'like', $term)->orWhere('summary', 'like', $term));
        }

        $posts = $query->paginate(9);
        $categories = PostCategory::withCount(['posts' => fn($q) => $q->published()])->get();
        $tags = PostTag::all();

        return view('themes.crystal-3d.pages.blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show(string $slug): View
    {
        $query = Post::where('slug', $slug);

        if (! auth()->check() || auth()->user()->role !== 'owner') {
            $query->published();
        }

        $post = $query->with(['category', 'coverImage', 'author', 'tags'])->firstOrFail();

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->take(3)
            ->get();

        return view('themes.crystal-3d.pages.blog.show', compact('post', 'relatedPosts'));
    }
}
