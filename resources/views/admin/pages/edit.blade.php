@extends('layouts.admin')

@section('title', 'Page Settings: ' . $page->title)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.pages.index') }}" class="text-secondary text-decoration-none small d-flex align-items-center gap-1 mb-2">
        <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i> Back to Pages
    </a>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 fw-bold mb-1">Page Settings</h1>
            <p class="text-secondary mb-0">Configure metadata, slug, and publication status for "{{ $page->title }}".</p>
        </div>
        <a href="{{ route('admin.pages.builder', $page) }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i data-lucide="layout-template"></i>
            <span>Open Visual Builder</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
            <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">URL Slug <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary">/</span>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $page->slug) }}" required>
                    </div>
                    @error('slug')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Publication Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Draft (Private)</option>
                        <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Published (Public)</option>
                    </select>
                </div>

                <hr class="my-4" style="border-color: var(--admin-border);">
                <h5 class="fw-bold mb-3">SEO Metadata</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success d-flex align-items-center gap-2">
                        <i data-lucide="check"></i>
                        <span>Save Page Settings</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
