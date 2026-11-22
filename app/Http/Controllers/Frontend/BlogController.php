<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactDetail;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\Profile;
use App\Services\ThemeResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            $query->where(fn($q) => $q->where('title', 'like', $term)->orWhere('summary', 'like', $term)->orWhere('content', 'like', $term));
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = PostCategory::withCount(['posts' => fn($q) => $q->published()])->get();
        $tags = PostTag::all();

        // Featured spotlight post if on page 1 without search filters
        $featuredPost = (! $request->filled('q') && ! $request->filled('category') && ! $request->filled('tag') && $request->input('page', 1) == 1)
            ? $posts->first()
            : null;

        $profile = Profile::first();
        $contact = ContactDetail::first();
        $activeTheme = ThemeResolver::resolve();
        $themeTokens = ThemeResolver::getTokens();
        $view = ThemeResolver::getView('pages.blog.index');

        return view($view, compact('posts', 'categories', 'tags', 'featuredPost', 'profile', 'contact', 'activeTheme', 'themeTokens'));
    }

    public function show(string $slug): View
    {
        $query = Post::where('slug', $slug);

        if (! auth()->check() || auth()->user()->role !== 'owner') {
            $query->published();
        }

        $post = $query->with(['category', 'coverImage', 'author', 'tags'])->firstOrFail();

        // Safely parse Markdown for technical code blocks, blockquotes, and lists
        $post->parsed_content = Str::markdown($post->content ?? '');

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->take(3)
            ->get();

        $profile = Profile::first();
        $contact = ContactDetail::first();
        $activeTheme = ThemeResolver::resolve();
        $themeTokens = ThemeResolver::getTokens();
        $view = ThemeResolver::getView('pages.blog.show');

        return view($view, compact('post', 'relatedPosts', 'profile', 'contact', 'activeTheme', 'themeTokens'));
    }
}
