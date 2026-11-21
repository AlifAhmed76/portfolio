<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Media;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Services\CacheInvalidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['category', 'author', 'tags'])
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = PostCategory::all();
        $tags = PostTag::all();
        $media = Media::latest()->take(30)->get();

        return view('admin.posts.create', compact('categories', 'tags', 'media'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:post_categories,id',
            'cover_image_id' => 'nullable|exists:media,id',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,scheduled',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:post_tags,id',
        ]);

        $slug = Str::slug($validated['slug'] ?: $validated['title']);
        if (Post::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        $post = new Post([
            'title' => $validated['title'],
            'slug' => $slug,
            'category_id' => $validated['category_id'] ?? null,
            'cover_image_id' => $validated['cover_image_id'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'author_id' => auth()->id(),
        ]);

        $post->reading_time = $post->calculateReadingTime();
        $post->save();

        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        ActivityLog::log('posts.created', ['title' => $post->title, 'slug' => $post->slug]);
        CacheInvalidationService::invalidateAll();

        return redirect()->route('admin.posts.index')
            ->with('success', "Article '{$post->title}' created successfully.");
    }

    public function edit(Post $post): View
    {
        $categories = PostCategory::all();
        $tags = PostTag::all();
        $media = Media::latest()->take(30)->get();

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'media'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'nullable|exists:post_categories,id',
            'cover_image_id' => 'nullable|exists:media,id',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,scheduled',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:post_tags,id',
        ]);

        $post->fill([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['slug']),
            'category_id' => $validated['category_id'] ?? null,
            'cover_image_id' => $validated['cover_image_id'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? ($post->published_at ?? now()) : null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
        ]);

        $post->reading_time = $post->calculateReadingTime();
        $post->save();

        $post->tags()->sync($validated['tags'] ?? []);

        ActivityLog::log('posts.updated', ['title' => $post->title]);
        CacheInvalidationService::invalidateAll();

        return redirect()->route('admin.posts.index')
            ->with('success', "Article '{$post->title}' updated successfully.");
    }

    public function destroy(Post $post): RedirectResponse
    {
        $title = $post->title;
        $post->delete();

        ActivityLog::log('posts.deleted', ['title' => $title]);
        CacheInvalidationService::invalidateAll();

        return redirect()->route('admin.posts.index')
            ->with('success', "Article '{$title}' was deleted successfully.");
    }
}
