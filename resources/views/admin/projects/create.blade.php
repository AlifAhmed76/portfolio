@extends('layouts.admin')

@section('title', 'Create Project')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Create New Project</h1>
            <p class="text-secondary small mb-0">Draft or publish a showcase project or detailed technical case study.</p>
        </div>
        <div>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-secondary">
                <i data-lucide="arrow-left" class="me-1" style="width: 14px; height: 14px;"></i> Back to Projects
            </a>
        </div>
    </div>

    <form action="{{ route('admin.projects.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            <!-- Left Column: Core Details & Case Study -->
            <div class="col-lg-8">
                <div class="admin-card p-4 mb-4">
                    <h5 class="fw-bold mb-3">Project Overview</h5>

                    <div class="row g-3 mb-3">
                        <div class="col-md-8">
                            <label for="title" class="form-label small text-secondary">Project Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required placeholder="e.g. High-Volume E-Commerce Platform">
                        </div>
                        <div class="col-md-4">
                            <label for="slug" class="form-label small text-secondary">URL Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required placeholder="e.g. high-volume-ecommerce">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label small text-secondary">Short Summary / Teaser</label>
                        <textarea name="summary" id="summary" rows="2" class="form-control" placeholder="Brief 1-2 sentence overview">{{ old('summary') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label small text-secondary">Full Project Description</label>
                        <textarea name="description" id="description" rows="6" class="form-control" placeholder="Detailed architectural description">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Case Study Details -->
                <div class="admin-card p-4 mb-4">
                    <h5 class="fw-bold mb-1">Engineering Case Study</h5>
                    <p class="text-secondary small mb-3">Structured breakdown demonstrating technical problem-solving capabilities.</p>

                    <div class="mb-3">
                        <label for="challenge" class="form-label small text-secondary">The Challenge</label>
                        <textarea name="challenge" id="challenge" rows="3" class="form-control" placeholder="What architectural bottleneck or business challenge needed solving?">{{ old('challenge') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="solution" class="form-label small text-secondary">The Solution</label>
                        <textarea name="solution" id="solution" rows="3" class="form-control" placeholder="How did you architect and execute the solution?">{{ old('solution') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="implementation" class="form-label small text-secondary">Technical Implementation</label>
                        <textarea name="implementation" id="implementation" rows="3" class="form-control" placeholder="Key technologies, design patterns, and integrations used">{{ old('implementation') }}</textarea>
                    </div>

                    <div class="mb-0">
                        <label for="outcome" class="form-label small text-secondary">Measurable Outcome & Results</label>
                        <textarea name="outcome" id="outcome" rows="3" class="form-control" placeholder="Performance improvements, conversion gains, or client outcome">{{ old('outcome') }}</textarea>
                    </div>
                </div>

                <!-- External Links -->
                <div class="admin-card p-4">
                    <h5 class="fw-bold mb-3">Project Links</h5>
                    <div class="row g-2 mb-2">
                        <div class="col-sm-3">
                            <input type="text" name="links[0][label]" class="form-control form-control-sm" placeholder="Live Demo" value="{{ old('links.0.label', 'Live Site') }}">
                            <input type="hidden" name="links[0][link_type]" value="live">
                        </div>
                        <div class="col-sm-9">
                            <input type="url" name="links[0][url]" class="form-control form-control-sm" placeholder="https://example.com" value="{{ old('links.0.url') }}">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-3">
                            <input type="text" name="links[1][label]" class="form-control form-control-sm" placeholder="Repository" value="{{ old('links.1.label', 'GitHub Repository') }}">
                            <input type="hidden" name="links[1][link_type]" value="github">
                        </div>
                        <div class="col-sm-9">
                            <input type="url" name="links[1][url]" class="form-control form-control-sm" placeholder="https://github.com/..." value="{{ old('links.1.url') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings & Taxonomies -->
            <div class="col-lg-4">
                <div class="admin-card p-4 mb-4">
                    <h5 class="fw-bold mb-3">Publishing</h5>

                    <div class="mb-3">
                        <label for="status" class="form-label small text-secondary">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label small text-secondary">Display Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label small" for="is_featured">
                                <strong>Featured Project</strong> (Promote to hero/highlight section)
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-emerald w-100 py-2">
                        <i data-lucide="check" class="me-1" style="width: 16px; height: 16px;"></i> Save Project
                    </button>
                </div>

                <!-- Category & Cover -->
                <div class="admin-card p-4 mb-4">
                    <h5 class="fw-bold mb-3">Category & Cover</h5>

                    <div class="mb-3">
                        <label for="category_id" class="form-label small text-secondary">Category</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">-- No Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-0">
                        <x-admin.image-picker 
                            name="cover_image_id" 
                            label="Project Cover Image" 
                            :images="$mediaImages" 
                            helpText="Displayed in portfolio grid & case study hero" />
                    </div>
                </div>

                <!-- Technologies & Skills -->
                <div class="admin-card p-4">
                    <h5 class="fw-bold mb-3">Associated Skills</h5>
                    <div style="max-height: 240px; overflow-y: auto;" class="p-2 border rounded border-secondary-subtle">
                        @foreach ($skills as $skill)
                            <div class="form-check small mb-1">
                                <input class="form-check-input" type="checkbox" name="skills[]" value="{{ $skill->id }}" id="skill_{{ $skill->id }}" {{ in_array($skill->id, old('skills', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="skill_{{ $skill->id }}">
                                    {{ $skill->name }} <small class="text-secondary">({{ $skill->category?->name }})</small>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Auto slug generator from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', () => {
            if (!slugInput.value || slugInput.dataset.touched !== 'true') {
                slugInput.value = titleInput.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
            }
        });
        slugInput.addEventListener('input', () => {
            slugInput.dataset.touched = 'true';
        });
    }
</script>
@endsection
