@extends('layouts.admin')

@section('title', 'Trusted Code Editor')

@section('content')
<div class="code-editor-wrapper d-flex flex-column gap-3">
    <!-- Header Bar -->
    <div class="card border-0 shadow-sm p-3" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                    <i data-lucide="code-2" style="width: 20px; height: 20px;"></i>
                </div>
                <div>
                    <h1 class="h5 fw-bold mb-0 d-flex align-items-center gap-2">
                        <span>Trusted Code Editor</span>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle small fw-semibold">
                            <i data-lucide="shield-alert" style="width: 12px; height: 12px;"></i> Strict Sandbox
                        </span>
                    </h1>
                    <p class="text-secondary small mb-0">Allowlisted theme templates & styles with pre-save immutable revisions.</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span id="saveStatusIndicator" class="badge bg-secondary-subtle text-secondary small px-2 py-1">Saved</span>
                
                <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" id="btnToggleRevisions">
                    <i data-lucide="history" style="width: 14px; height: 14px;"></i>
                    <span id="revisionsCountBadge">Revisions</span>
                </button>

                <button type="button" class="btn btn-sm btn-success d-flex align-items-center gap-1 px-3" id="btnSaveCode">
                    <i data-lucide="save" style="width: 14px; height: 14px;"></i>
                    <span id="btnSaveText">Save File (Ctrl+S)</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Alert / Notification -->
    <div id="editorAlert" class="alert d-none mb-0"></div>

    <!-- Main Workspace Split Pane -->
    <div class="row g-3">
        <!-- File Tree Sidebar -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm h-100" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
                <div class="card-header p-3 border-bottom d-flex justify-content-between align-items-center" style="background: rgba(255,255,255,0.02); border-color: var(--admin-border) !important;">
                    <h6 class="fw-bold mb-0 small text-uppercase tracking-wider text-secondary">Allowlisted Files</h6>
                    <span class="badge bg-dark border border-secondary text-secondary small">{{ count($tree) }} files</span>
                </div>
                <div class="card-body p-2" style="max-height: 680px; overflow-y: auto;">
                    <div class="list-group list-group-flush" id="fileTreeList">
                        @foreach ($tree as $file)
                            <button type="button" class="list-group-item list-group-item-action text-start p-2 rounded-2 mb-1 file-item-btn {{ ($initialData && $initialData['relative_path'] === $file['relative_path']) ? 'active' : '' }}" data-path="{{ $file['relative_path'] }}" style="background: transparent; color: var(--admin-text); border: none;">
                                <div class="d-flex align-items-center gap-2">
                                    @if ($file['type'] === 'blade')
                                        <i data-lucide="layout-template" class="text-warning flex-shrink-0" style="width: 14px; height: 14px;"></i>
                                    @elseif ($file['type'] === 'css')
                                        <i data-lucide="palette" class="text-info flex-shrink-0" style="width: 14px; height: 14px;"></i>
                                    @elseif ($file['type'] === 'js')
                                        <i data-lucide="file-code" class="text-warning flex-shrink-0" style="width: 14px; height: 14px;"></i>
                                    @else
                                        <i data-lucide="file-text" class="text-secondary flex-shrink-0" style="width: 14px; height: 14px;"></i>
                                    @endif
                                    <div class="text-truncate small">
                                        <div class="fw-medium text-truncate">{{ $file['name'] }}</div>
                                        <small class="text-secondary text-truncate d-block" style="font-size: 11px;">{{ dirname($file['relative_path']) }}</small>
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Code Editor Canvas -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
                <div class="card-header p-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: rgba(255,255,255,0.02); border-color: var(--admin-border) !important;">
                    <div class="d-flex align-items-center gap-2 text-truncate">
                        <i data-lucide="file" class="text-primary flex-shrink-0" style="width: 16px; height: 16px;"></i>
                        <span id="activeFileTitle" class="font-monospace small fw-semibold text-truncate">
                            {{ $initialData['relative_path'] ?? 'No file selected' }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <small class="text-secondary d-none d-md-inline" style="font-size: 11px;">SHA-256:</small>
                        <code id="activeFileHash" class="text-secondary small fw-normal" style="font-size: 11px;">
                            {{ $initialData ? substr($initialData['hash'], 0, 16) . '...' : '—' }}
                        </code>
                    </div>
                </div>

                <div class="card-body p-0 position-relative">
                    <textarea id="codeTextarea" class="form-control font-monospace border-0 p-3" rows="24" style="background: #0d1117; color: #c9d1d9; font-size: 13.5px; line-height: 1.6; resize: vertical; border-radius: 0 0 8px 8px; outline: none; tab-size: 4;" spellcheck="false">{{ $initialData['content'] ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revisions Drawer Modal -->
<div class="modal fade" id="codeRevisionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border); color: var(--admin-text);">
            <div class="modal-header border-bottom" style="border-color: var(--admin-border) !important;">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i data-lucide="history" class="text-primary"></i>
                    <span>Revision History: <span id="revisionModalFileName" class="font-monospace small fw-normal"></span></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="color: var(--admin-text);">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">Revision</th>
                                <th>SHA-256</th>
                                <th>Saved At</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody id="revisionsTableBody">
                            <tr>
                                <td colspan="4" class="text-center py-4 text-secondary">Loading revisions...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPath = @json($initialData['relative_path'] ?? null);
    let originalContent = document.getElementById('codeTextarea').value;
    const openUrl = @json(route('admin.code-editor.open'));
    const saveUrl = @json(route('admin.code-editor.save'));
    const restoreUrl = @json(route('admin.code-editor.restore'));
    const csrfToken = '{{ csrf_token() }}';

    const textarea = document.getElementById('codeTextarea');
    const alertEl = document.getElementById('editorAlert');
    const statusIndicator = document.getElementById('saveStatusIndicator');
    const btnSave = document.getElementById('btnSaveCode');
    const btnSaveText = document.getElementById('btnSaveText');
    const activeFileTitle = document.getElementById('activeFileTitle');
    const activeFileHash = document.getElementById('activeFileHash');
    const revisionsModal = new bootstrap.Modal(document.getElementById('codeRevisionsModal'));

    function showAlert(type, msg) {
        alertEl.className = `alert alert-${type} mb-3`;
        alertEl.textContent = msg;
        alertEl.classList.remove('d-none');
        setTimeout(() => alertEl.classList.add('d-none'), 6000);
    }

    // Dirty state tracking
    textarea.addEventListener('input', function() {
        if (this.value !== originalContent) {
            statusIndicator.className = 'badge bg-warning-subtle text-warning small px-2 py-1';
            statusIndicator.textContent = 'Unsaved Changes';
        } else {
            statusIndicator.className = 'badge bg-secondary-subtle text-secondary small px-2 py-1';
            statusIndicator.textContent = 'Saved';
        }
    });

    // Keyboard shortcut (Ctrl+S / Cmd+S)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            saveCurrentFile();
        }
    });

    btnSave.addEventListener('click', saveCurrentFile);

    function saveCurrentFile() {
        if (!currentPath) {
            showAlert('warning', 'No file selected.');
            return;
        }

        btnSave.disabled = true;
        btnSaveText.textContent = 'Saving...';

        fetch(saveUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                path: currentPath,
                content: textarea.value
            })
        })
        .then(res => res.json())
        .then(data => {
            btnSave.disabled = false;
            btnSaveText.textContent = 'Save File (Ctrl+S)';
            if (data.success) {
                originalContent = textarea.value;
                statusIndicator.className = 'badge bg-success-subtle text-success small px-2 py-1';
                statusIndicator.textContent = 'Saved';
                activeFileHash.textContent = data.data.hash.substring(0, 16) + '...';
                showAlert('success', 'File saved successfully with pre-save backup revision recorded.');
            } else {
                showAlert('danger', data.message || 'Validation error saving file.');
            }
        })
        .catch(err => {
            btnSave.disabled = false;
            btnSaveText.textContent = 'Save File (Ctrl+S)';
            showAlert('danger', 'Network error occurred while saving.');
        });
    }

    // Switch File
    document.querySelectorAll('.file-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const path = this.dataset.path;
            if (path === currentPath) return;

            if (textarea.value !== originalContent) {
                if (!confirm('You have unsaved changes. Discard and switch file?')) {
                    return;
                }
            }

            document.querySelectorAll('.file-item-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            fetch(openUrl + '?path=' + encodeURIComponent(path), {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    currentPath = data.file.relative_path;
                    activeFileTitle.textContent = currentPath;
                    activeFileHash.textContent = data.file.hash.substring(0, 16) + '...';
                    textarea.value = data.file.content;
                    originalContent = data.file.content;
                    statusIndicator.className = 'badge bg-secondary-subtle text-secondary small px-2 py-1';
                    statusIndicator.textContent = 'Saved';
                } else {
                    showAlert('danger', data.message || 'Error opening file.');
                }
            });
        });
    });

    // Revisions Toggle
    document.getElementById('btnToggleRevisions').addEventListener('click', function() {
        if (!currentPath) return;
        document.getElementById('revisionModalFileName').textContent = currentPath;
        const tbody = document.getElementById('revisionsTableBody');
        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-secondary">Loading revisions...</td></tr>';
        revisionsModal.show();

        fetch(openUrl + '?path=' + encodeURIComponent(currentPath), {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.revisions && data.revisions.length > 0) {
                tbody.innerHTML = '';
                data.revisions.forEach(rev => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="ps-3"><span class="badge bg-secondary">Rev #${rev.revision_number}</span></td>
                        <td><code class="small text-secondary">${rev.hash.substring(0, 16)}...</code></td>
                        <td>${new Date(rev.created_at).toLocaleString()}</td>
                        <td class="text-end pe-3">
                            <button type="button" class="btn btn-sm btn-outline-warning btn-restore-rev" data-rev="${rev.revision_number}">
                                Restore
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });

                document.querySelectorAll('.btn-restore-rev').forEach(rBtn => {
                    rBtn.addEventListener('click', function() {
                        const revNum = this.dataset.rev;
                        if (!confirm(`Restore Revision #${revNum}? This will overwrite current file.`)) return;

                        fetch(restoreUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ path: currentPath, revision_number: revNum })
                        })
                        .then(r => r.json())
                        .then(res => {
                            if (res.success) {
                                revisionsModal.hide();
                                showAlert('success', res.message);
                                // Reload file
                                fetch(openUrl + '?path=' + encodeURIComponent(currentPath), {
                                    headers: { 'Accept': 'application/json' }
                                })
                                .then(r => r.json())
                                .then(d => {
                                    if (d.success) {
                                        textarea.value = d.file.content;
                                        originalContent = d.file.content;
                                        activeFileHash.textContent = d.file.hash.substring(0, 16) + '...';
                                    }
                                });
                            } else {
                                alert(res.message);
                            }
                        });
                    });
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-secondary">No previous revisions recorded for this file yet.</td></tr>';
            }
        });
    });
});
</script>
@endsection
