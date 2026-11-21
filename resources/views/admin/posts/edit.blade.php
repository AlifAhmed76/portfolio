@extends('layouts.admin')

@section('title', 'Edit Article: ' . $post->title)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.posts.index') }}" class="text-secondary text-decoration-none small d-flex align-items-center gap-1 mb-2">
        <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i> Back to Articles
    </a>
    <h1 class="h3 fw-bold mb-1">Edit Article</h1>
    <p class="text-secondary mb-0">Update technical content, category tags, and SEO metadata.</p>
</div>

<div class="card border-0 shadow-sm p-4" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
    <form action="{{ route('admin.posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Article Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary">/blog/</span>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Summary / Subtitle</label>
                    <textarea name="summary" rows="2" class="form-control">{{ old('summary', $post->summary) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Article Content <span class="text-danger">*</span></label>
                    <textarea name="content" rows="16" class="form-control font-monospace" required>{{ old('content', $post->content) }}</textarea>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-3 mb-3 border-secondary" style="background: rgba(255,255,255,0.02);">
                    <h6 class="fw-bold mb-3">Publishing Options</h6>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft (Private)</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published (Public)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Category</label>
                        <select name="category_id" class="form-select form-select-sm">
                            <option value="">No Category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Cover Image</label>
                        <select name="cover_image_id" class="form-select form-select-sm">
                            <option value="">No Image</option>
                            @foreach ($media as $item)
                                <option value="{{ $item->id }}" {{ old('cover_image_id', $post->cover_image_id) == $item->id ? 'selected' : '' }}>{{ $item->filename }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <small class="text-secondary">Reading time: <strong>{{ $post->reading_time }} min</strong></small>
                    </div>
                </div>

                <div class="card p-3 border-secondary" style="background: rgba(255,255,255,0.02);">
                    <h6 class="fw-bold mb-3">SEO Tags</h6>

                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control form-control-sm" value="{{ old('meta_title', $post->meta_title) }}">
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Meta Description</label>
                        <textarea name="meta_description" rows="3" class="form-control form-control-sm">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                        Save Article
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
