@extends('layouts.admin')

@section('title', 'Homepage Sections Manager')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Homepage Section Manager</h1>
            <p class="text-secondary small mb-0">Reorder sections up/down, toggle active/inactive status, and customize display titles in real-time.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 d-flex align-items-center gap-2">
                <i data-lucide="layers" style="width: 16px; height: 16px;"></i>
                <span>{{ $sections->count() }} Total Sections</span>
            </span>
            <a href="{{ auth()->user()?->workspace?->slug && auth()->user()?->workspace?->slug !== 'default' ? url('/u/' . auth()->user()->workspace->slug) : url('/') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
                <span>View Live Site</span>
            </a>
        </div>
    </div>

    <!-- Instructions & Quick Tips -->
    <div class="alert alert-dark border-secondary-subtle d-flex align-items-center justify-content-between gap-3 mb-4 py-2 px-3">
        <div class="d-flex align-items-center gap-2 small text-secondary">
            <i data-lucide="info" class="text-emerald" style="width: 18px; height: 18px;"></i>
            <span><strong>Tip:</strong> Drag rows using the grip handle <i data-lucide="grip-vertical" style="width: 14px; height: 14px;" class="d-inline"></i> or use the <strong>▲ Up / ▼ Down</strong> buttons to reorder. Toggle the switch to activate/deactivate instantly.</span>
        </div>
        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="location.reload()" title="Refresh List">
            <i data-lucide="refresh-cw" style="width: 12px; height: 12px;"></i>
        </button>
    </div>

    <!-- Sections Table Card -->
    <div class="admin-card p-0 overflow-hidden mb-4 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="sectionsTable">
                <thead class="bg-body-tertiary text-secondary small text-uppercase" style="letter-spacing: 0.05em;">
                    <tr>
                        <th style="width: 80px;" class="text-center">Reorder</th>
                        <th style="width: 80px;" class="text-center">Pos</th>
                        <th>Section Key</th>
                        <th>Section Display Title</th>
                        <th style="width: 180px;">Status / Visibility</th>
                        <th class="text-end pe-3" style="width: 120px;">Save Title</th>
                    </tr>
                </thead>
                <tbody id="sortableSectionsList">
                    @foreach ($sections as $index => $section)
                        <tr class="section-row {{ $section->is_enabled ? '' : 'opacity-75' }}" 
                            id="row_{{ $section->id }}" 
                            data-id="{{ $section->id }}" 
                            data-order="{{ $section->sort_order }}"
                            draggable="true">
                            
                            <!-- 1. Drag & Quick Move Buttons -->
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <span class="drag-handle text-secondary p-1" style="cursor: grab;" title="Drag to reorder">
                                        <i data-lucide="grip-vertical" style="width: 18px; height: 18px;"></i>
                                    </span>
                                    <div class="btn-group-vertical btn-group-sm">
                                        <button type="button" class="btn btn-xs btn-outline-secondary p-0 px-1 move-btn btn-up" 
                                                onclick="moveRow({{ $section->id }}, 'up')" 
                                                title="Move Up">
                                            ▲
                                        </button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary p-0 px-1 move-btn btn-down" 
                                                onclick="moveRow({{ $section->id }}, 'down')" 
                                                title="Move Down">
                                            ▼
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <!-- 2. Position Badge -->
                            <td class="text-center">
                                <span class="badge bg-secondary-subtle text-secondary order-badge px-2 py-1 font-monospace">
                                    #<span class="order-num">{{ $index + 1 }}</span>
                                </span>
                            </td>

                            <!-- 3. Key & Hint -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <code class="text-emerald fw-bold bg-dark px-2 py-1 rounded border border-secondary-subtle">{{ $section->section_key }}</code>
                                    @php
                                        $hint = match($section->section_key) {
                                            'hero' => 'Top headline, intro bio & CTAs',
                                            'highlights' => 'Key metrics & quick stats grid',
                                            'about' => 'Bio narrative, background & philosophy',
                                            'expertise' => 'Skills matrix, stack & proficiency',
                                            'projects' => 'Portfolio case studies & showcase',
                                            'services' => 'Solutions, consulting & deliverables',
                                            'experience' => 'Career milestones & timeline',
                                            'education' => 'Academic degrees & certifications',
                                            'process' => 'Engineering workflow & methodology',
                                            'blog' => 'Recent technical articles & changelog',
                                            'contact' => 'Contact form, socials & direct email',
                                            default => 'Custom section content',
                                        };
                                    @endphp
                                    <small class="text-secondary d-none d-md-inline">({{ $hint }})</small>
                                </div>
                            </td>

                            <!-- 4. Display Title Inline Edit -->
                            <td>
                                <form action="{{ route('admin.sections.update', $section) }}" method="POST" class="title-update-form d-flex align-items-center gap-2" id="title_form_{{ $section->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="sort_order" class="input-sort-order" value="{{ $section->sort_order }}">
                                    <input type="hidden" name="is_enabled" class="input-is-enabled" value="{{ $section->is_enabled ? 1 : 0 }}">
                                    <input type="text" name="title" class="form-control form-control-sm bg-dark text-light border-secondary-subtle section-title-input" 
                                           value="{{ $section->title }}" required 
                                           oninput="markTitleDirty({{ $section->id }})">
                                </form>
                            </td>

                            <!-- 5. Active / Inactive Switch -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input section-toggle-switch" type="checkbox" role="switch" 
                                               id="toggle_{{ $section->id }}" 
                                               {{ $section->is_enabled ? 'checked' : '' }}
                                               onchange="toggleSectionVisibility({{ $section->id }})">
                                    </div>
                                    <span id="badge_status_{{ $section->id }}" class="badge {{ $section->is_enabled ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary' }} px-2 py-1" style="font-size: 0.75rem;">
                                        {{ $section->is_enabled ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </td>

                            <!-- 6. Action Button -->
                            <td class="text-end pe-3">
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-save-title" 
                                        id="save_btn_{{ $section->id }}" 
                                        onclick="saveSectionTitle({{ $section->id }})" 
                                        title="Save Title">
                                    <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                                    <span>Save</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Floating Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
    <div id="liveToast" class="toast align-items-center text-white bg-dark border border-secondary shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2" id="toastMessage">
                <i data-lucide="check-circle" class="text-success" style="width: 18px; height: 18px;"></i>
                <span>Action executed successfully.</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    const reorderUrl = '{{ route("admin.sections.reorder") }}';
    const csrfToken = '{{ csrf_token() }}';

    function showToast(message, isSuccess = true) {
        const toastEl = document.getElementById('liveToast');
        const toastMsg = document.getElementById('toastMessage');
        const iconHtml = isSuccess 
            ? '<i data-lucide="check-circle" class="text-emerald" style="width: 18px; height: 18px;"></i>' 
            : '<i data-lucide="alert-triangle" class="text-danger" style="width: 18px; height: 18px;"></i>';
        
        toastMsg.innerHTML = `${iconHtml} <span>${message}</span>`;
        if (window.lucide) lucide.createIcons();
        
        const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
        toast.show();
    }

    // Toggle Section Active / Inactive
    function toggleSectionVisibility(id) {
        const badge = document.getElementById(`badge_status_${id}`);
        const checkbox = document.getElementById(`toggle_${id}`);
        const row = document.getElementById(`row_${id}`);
        const isChecked = checkbox.checked;

        // Optimistic UI update
        badge.className = isChecked 
            ? 'badge bg-success-subtle text-success border border-success-subtle px-2 py-1' 
            : 'badge bg-secondary-subtle text-secondary px-2 py-1';
        badge.innerText = isChecked ? 'Active' : 'Inactive';
        if (isChecked) {
            row.classList.remove('opacity-75');
        } else {
            row.classList.add('opacity-75');
        }

        fetch(`/admin/sections/${id}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            showToast(data.message || 'Section status updated.');
        })
        .catch(err => {
            console.error(err);
            // Revert on error
            checkbox.checked = !isChecked;
            showToast('Failed to update status. Please try again.', false);
        });
    }

    // Save Section Title via AJAX
    function saveSectionTitle(id) {
        const form = document.getElementById(`title_form_${id}`);
        const titleInput = form.querySelector('input[name="title"]');
        const sortOrder = form.querySelector('.input-sort-order').value;
        const isEnabled = document.getElementById(`toggle_${id}`).checked ? 1 : 0;
        const saveBtn = document.getElementById(`save_btn_${id}`);

        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm" style="width: 12px; height: 12px;"></span>';

        fetch(`/admin/sections/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                title: titleInput.value,
                sort_order: sortOrder,
                is_enabled: isEnabled
            })
        })
        .then(res => res.json())
        .then(data => {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<i data-lucide="check" style="width: 14px; height: 14px;"></i> <span>Saved</span>';
            saveBtn.classList.remove('btn-outline-warning');
            saveBtn.classList.add('btn-outline-success');
            showToast(data.message || 'Section title saved.');
            if (window.lucide) lucide.createIcons();
            setTimeout(() => {
                saveBtn.classList.remove('btn-outline-success');
                saveBtn.classList.add('btn-outline-secondary');
                saveBtn.innerHTML = '<i data-lucide="check" style="width: 14px; height: 14px;"></i> <span>Save</span>';
                if (window.lucide) lucide.createIcons();
            }, 2000);
        })
        .catch(err => {
            console.error(err);
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<span>Retry</span>';
            showToast('Error saving section title.', false);
        });
    }

    function markTitleDirty(id) {
        const btn = document.getElementById(`save_btn_${id}`);
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-outline-warning');
    }

    // 1-Click Move Row Up / Down
    function moveRow(id, direction) {
        const row = document.getElementById(`row_${id}`);
        const tbody = document.getElementById('sortableSectionsList');

        if (direction === 'up') {
            const prev = row.previousElementSibling;
            if (prev) {
                tbody.insertBefore(row, prev);
                syncAndSaveOrder();
            }
        } else if (direction === 'down') {
            const next = row.nextElementSibling;
            if (next) {
                tbody.insertBefore(next, row);
                syncAndSaveOrder();
            }
        }
    }

    // Update position numbers and dispatch reorder request
    function syncAndSaveOrder() {
        const rows = document.querySelectorAll('#sortableSectionsList .section-row');
        const ids = [];

        rows.forEach((row, idx) => {
            const posBadge = row.querySelector('.order-num');
            if (posBadge) posBadge.innerText = idx + 1;
            const sortInput = row.querySelector('.input-sort-order');
            if (sortInput) sortInput.value = idx + 1;
            ids.push(parseInt(row.getAttribute('data-id')));
        });

        fetch(reorderUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ ids: ids })
        })
        .then(res => res.json())
        .then(data => {
            showToast('Homepage section order saved successfully.');
        })
        .catch(err => {
            console.error(err);
            showToast('Failed to save section order.', false);
        });
    }

    // HTML5 Drag and Drop Handlers
    let draggedRow = null;

    document.querySelectorAll('#sortableSectionsList .section-row').forEach(row => {
        row.addEventListener('dragstart', (e) => {
            draggedRow = row;
            e.dataTransfer.effectAllowed = 'move';
            row.style.opacity = '0.4';
        });

        row.addEventListener('dragend', () => {
            if (draggedRow) draggedRow.style.opacity = draggedRow.classList.contains('opacity-75') ? '0.75' : '1';
            draggedRow = null;
        });

        row.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            const tbody = document.getElementById('sortableSectionsList');
            const bounding = row.getBoundingClientRect();
            const offset = bounding.y + (bounding.height / 2);

            if (e.clientY - offset > 0) {
                row.after(draggedRow);
            } else {
                row.before(draggedRow);
            }
        });

        row.addEventListener('drop', (e) => {
            e.preventDefault();
            syncAndSaveOrder();
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        if (window.lucide) lucide.createIcons();
    });
</script>
@endsection
