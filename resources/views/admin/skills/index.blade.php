@extends('layouts.admin')

@section('title', 'Skills & Technical Expertise')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Skills & Technical Expertise</h1>
            <p class="text-secondary small mb-0">Manage skill categories and technical capabilities. Uses descriptive problem-solving evidence (no arbitrary percentage bars per specification).</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i data-lucide="folder-plus" class="me-1" style="width: 14px; height: 14px;"></i> Add Category
            </button>
            <button class="btn btn-sm btn-emerald" type="button" data-bs-toggle="modal" data-bs-target="#addSkillModal">
                <i data-lucide="plus" class="me-1" style="width: 14px; height: 14px;"></i> Add Skill
            </button>
        </div>
    </div>

    <!-- Categories & Skills Display -->
    <div class="row g-4 mb-4">
        @forelse ($categories as $cat)
            <div class="col-lg-6">
                <div class="admin-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-secondary-subtle">
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="cpu" class="text-success" style="width: 20px; height: 20px;"></i>
                            <h5 class="fw-bold mb-0">{{ $cat->name }}</h5>
                            <span class="badge bg-secondary-subtle text-secondary small">{{ $cat->skills->count() }} skills</span>
                        </div>
                        <form action="{{ route('admin.skills.category.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete category {{ $cat->name }} and all its skills?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-outline-danger p-1" title="Delete Category">
                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                            </button>
                        </form>
                    </div>

                    <div class="list-group list-group-flush">
                        @forelse ($cat->skills as $skill)
                            <div class="list-group-item bg-transparent px-0 py-2 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ $skill->name }}</div>
                                    @if ($skill->description)
                                        <small class="text-secondary d-block">{{ $skill->description }}</small>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-body-secondary text-secondary">#{{ $skill->sort_order }}</span>
                                    <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Delete skill {{ $skill->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-link text-danger p-0">
                                            <i data-lucide="x" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-secondary small mb-0 py-2">No skills in this category yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="admin-card p-5 text-center text-secondary">
                    <i data-lucide="cpu" class="mb-2" style="width: 44px; height: 44px; opacity: 0.5;"></i>
                    <h5>No Skill Categories Defined</h5>
                    <p class="small mb-3">Create categories like "Backend Engineering", "Frontend & UI", or "Tracking & Analytics" to get started.</p>
                    <button class="btn btn-sm btn-emerald" type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add First Category</button>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.skills.category.store') }}" method="POST" class="modal-content admin-card">
            @csrf
            <div class="modal-header border-secondary-subtle">
                <h5 class="modal-title h6 fw-bold">Create Skill Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="cat_name" class="form-label small text-secondary">Category Name</label>
                    <input type="text" name="name" id="cat_name" class="form-control" required placeholder="e.g. Backend Architecture">
                </div>
                <div class="mb-3">
                    <label for="cat_sort" class="form-label small text-secondary">Sort Order</label>
                    <input type="number" name="sort_order" id="cat_sort" class="form-control" value="0">
                </div>
            </div>
            <div class="modal-footer border-secondary-subtle">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-emerald">Create Category</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Skill Modal -->
<div class="modal fade" id="addSkillModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.skills.store') }}" method="POST" class="modal-content admin-card">
            @csrf
            <div class="modal-header border-secondary-subtle">
                <h5 class="modal-title h6 fw-bold">Add Skill / Technology</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="category_id" class="form-label small text-secondary">Category</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="skill_name" class="form-label small text-secondary">Skill Name</label>
                    <input type="text" name="name" id="skill_name" class="form-control" required placeholder="e.g. Laravel Architecture">
                </div>
                <div class="mb-3">
                    <label for="skill_desc" class="form-label small text-secondary">Description / Evidence (No percentage bars)</label>
                    <textarea name="description" id="skill_desc" rows="2" class="form-control" placeholder="e.g. Custom service layers, queue pipelines, multi-tenant databases"></textarea>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="skill_icon" class="form-label small text-secondary">Lucide Icon (Optional)</label>
                        <input type="text" name="icon" id="skill_icon" class="form-control" placeholder="server">
                    </div>
                    <div class="col-6">
                        <label for="skill_sort" class="form-label small text-secondary">Sort Order</label>
                        <input type="number" name="sort_order" id="skill_sort" class="form-control" value="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-secondary-subtle">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-emerald">Add Skill</button>
            </div>
        </form>
    </div>
</div>
@endsection
