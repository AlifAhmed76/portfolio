@extends('layouts.admin')

@section('title', 'Create New Page')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.pages.index') }}" class="text-secondary text-decoration-none small d-flex align-items-center gap-1 mb-2">
        <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i> Back to Pages
    </a>
    <h1 class="h3 fw-bold mb-1">Create New Page</h1>
    <p class="text-secondary mb-0">Initialize page metadata and select an optional starting template.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Page Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. Full-Stack Engineering Case Studies">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">URL Slug (Optional)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary">/</span>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="custom-landing-page">
                    </div>
                    <small class="text-secondary">Leave empty to generate automatically from the title.</small>
                    @error('slug')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Base Template</label>
                    <select name="page_template_id" class="form-select">
                        <option value="">Blank Canvas (Custom Composition)</option>
                        @foreach ($templates as $template)
                            <option value="{{ $template->id }}" {{ old('page_template_id') == $template->id ? 'selected' : '' }}>
                                {{ $template->name }} (v{{ $template->version }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <hr class="my-4" style="border-color: var(--admin-border);">
                <h5 class="fw-bold mb-3">SEO Metadata</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="Optimized title tag for search engines">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="form-control" placeholder="Brief summary for search engine snippet (max 160 chars recommended)">{{ old('meta_description') }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                        <i data-lucide="layout-template"></i>
                        <span>Create & Launch Visual Builder</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
