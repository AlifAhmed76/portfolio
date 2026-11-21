@extends('layouts.admin')

@section('title', 'Blog & Articles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Blog Articles</h1>
        <p class="text-secondary mb-0">Publish technical articles, architectural case studies, and engineering benchmarks.</p>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i data-lucide="plus"></i>
        <span>Write New Article</span>
    </a>
</div>

<div class="card border-0 shadow-sm" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="color: var(--admin-text);">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="ps-4">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Status</th>
                    <th scope="col">Read Time</th>
                    <th scope="col">Published At</th>
                    <th scope="col" class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold">{{ $post->title }}</div>
                            <code class="text-secondary small">/blog/{{ $post->slug }}</code>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary">
                                {{ $post->category ? $post->category->name : 'Uncategorized' }}
                            </span>
                        </td>
                        <td>
                            @if ($post->status === 'published')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Published</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Draft</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-dark border border-secondary text-secondary">
                                {{ $post->reading_time }} min
                            </span>
                        </td>
                        <td class="text-secondary small">
                            {{ $post->published_at ? $post->published_at->format('M d, Y') : '—' }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                @if ($post->status === 'published')
                                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-light" title="View Article">
                                        <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary" title="Edit Article">
                                    <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Permanently delete this article?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Article">
                                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-secondary">
                            <i data-lucide="newspaper" class="mb-2" style="width: 32px; height: 32px;"></i>
                            <p class="mb-2">No articles created yet.</p>
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary">Compose First Post</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($posts->hasPages())
        <div class="p-3 border-top" style="border-color: var(--admin-border) !important;">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
