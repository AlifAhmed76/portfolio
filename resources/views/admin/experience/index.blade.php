@extends('layouts.admin')

@section('title', 'Experience & Education')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Professional Experience & Education</h1>
            <p class="text-secondary small mb-0">Career timeline, technical leadership roles, and academic qualifications.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-emerald" type="button" data-bs-toggle="modal" data-bs-target="#addExperienceModal">
                <i data-lucide="plus" class="me-1" style="width: 14px; height: 14px;"></i> Add Experience
            </button>
            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#addEducationModal">
                <i data-lucide="plus" class="me-1" style="width: 14px; height: 14px;"></i> Add Education
            </button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Experience Column -->
        <div class="col-lg-7">
            <div class="admin-card p-4">
                <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i data-lucide="briefcase" class="text-success"></i>
                    <span>Professional Experience Timeline</span>
                </h5>

                <div class="list-group list-group-flush">
                    @forelse ($experiences as $exp)
                        <div class="list-group-item bg-transparent px-0 py-3 border-bottom border-secondary-subtle">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $exp->designation }}</h6>
                                    <div class="text-success small fw-semibold mb-1">{{ $exp->company }}</div>
                                    <small class="text-muted d-block mb-2">
                                        {{ $exp->start_date->format('M Y') }} — 
                                        {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('M Y') : 'N/A') }}
                                    </small>
                                    @if ($exp->description)
                                        <p class="small text-secondary mb-0">{{ $exp->description }}</p>
                                    @endif
                                </div>
                                <form action="{{ route('admin.experience.destroy', $exp) }}" method="POST" onsubmit="return confirm('Delete this experience entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline-danger p-1" title="Delete">
                                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-secondary small mb-0 py-3 text-center">No experience entries recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Education Column -->
        <div class="col-lg-5">
            <div class="admin-card p-4">
                <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                    <i data-lucide="graduation-cap" class="text-info"></i>
                    <span>Education & Degrees</span>
                </h5>

                <div class="list-group list-group-flush">
                    @forelse ($educations as $edu)
                        <div class="list-group-item bg-transparent px-0 py-3 border-bottom border-secondary-subtle">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $edu->degree }} in {{ $edu->subject }}</h6>
                                    <div class="text-info small fw-semibold mb-1">{{ $edu->institution }}</div>
                                    <small class="text-muted d-block mb-1">
                                        {{ $edu->start_date->format('Y') }} — {{ $edu->end_date ? $edu->end_date->format('Y') : 'Present' }}
                                        @if ($edu->result) • Result: {{ $edu->result }} @endif
                                    </small>
                                </div>
                                <form action="{{ route('admin.education.destroy', $edu) }}" method="POST" onsubmit="return confirm('Delete this education entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline-danger p-1" title="Delete">
                                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-secondary small mb-0 py-3 text-center">No education records recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Experience Modal -->
<div class="modal fade" id="addExperienceModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.experience.store') }}" method="POST" class="modal-content admin-card">
            @csrf
            <div class="modal-header border-secondary-subtle">
                <h5 class="modal-title h6 fw-bold">Add Career Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="company" class="form-label small text-secondary">Company / Organization</label>
                    <input type="text" name="company" id="company" class="form-control" required placeholder="e.g. Software Solutions Ltd">
                </div>
                <div class="mb-3">
                    <label for="exp_designation" class="form-label small text-secondary">Designation / Role</label>
                    <input type="text" name="designation" id="exp_designation" class="form-control" required placeholder="e.g. Web Developer / Project Lead">
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="start_date" class="form-label small text-secondary">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label for="end_date" class="form-label small text-secondary">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="is_current" id="is_current" value="1">
                    <label class="form-check-label small" for="is_current">Currently working in this role</label>
                </div>
                <div class="mb-3">
                    <label for="exp_desc" class="form-label small text-secondary">Key Responsibilities & Achievements</label>
                    <textarea name="description" id="exp_desc" rows="3" class="form-control" placeholder="Led engineering teams, integrated courier APIs..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-secondary-subtle">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-emerald">Add Experience</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Education Modal -->
<div class="modal fade" id="addEducationModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.education.store') }}" method="POST" class="modal-content admin-card">
            @csrf
            <div class="modal-header border-secondary-subtle">
                <h5 class="modal-title h6 fw-bold">Add Academic Qualification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="institution" class="form-label small text-secondary">Institution / University</label>
                    <input type="text" name="institution" id="institution" class="form-control" required placeholder="University Name">
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="degree" class="form-label small text-secondary">Degree</label>
                        <input type="text" name="degree" id="degree" class="form-control" required placeholder="e.g. B.Sc.">
                    </div>
                    <div class="col-6">
                        <label for="subject" class="form-label small text-secondary">Subject / Major</label>
                        <input type="text" name="subject" id="subject" class="form-control" required placeholder="Computer Science">
                    </div>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="edu_start_date" class="form-label small text-secondary">Start Date</label>
                        <input type="date" name="start_date" id="edu_start_date" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label for="edu_end_date" class="form-label small text-secondary">End Date</label>
                        <input type="date" name="end_date" id="edu_end_date" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="result" class="form-label small text-secondary">Result / Grade (Optional)</label>
                    <input type="text" name="result" id="result" class="form-control" placeholder="CGPA or grade">
                </div>
            </div>
            <div class="modal-footer border-secondary-subtle">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-emerald">Add Education</button>
            </div>
        </form>
    </div>
</div>
@endsection
