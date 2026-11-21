@extends('layouts.admin')

@section('title', 'Visual Builder: ' . $page->title)

@section('content')
<div class="builder-container" style="display: flex; flex-direction: column; gap: 1.25rem;">
    <!-- Top Action Bar -->
    <div class="card border-0 shadow-sm p-3" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-outline-secondary" title="Back to Pages">
                    <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
                </a>
                <div>
                    <h1 class="h5 fw-bold mb-0 d-flex align-items-center gap-2">
                        <span>{{ $page->title }}</span>
                        <code class="text-secondary small fw-normal">/{{ $page->slug }}</code>
                        <span id="pageStatusBadge" class="badge {{ $page->status === 'published' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }} px-2 py-1">
                            {{ ucfirst($page->status) }}
                        </span>
                    </h1>
                </div>
            </div>

            <!-- Viewport Controls & Actions -->
            <div class="d-flex align-items-center gap-2">
                <div class="btn-group btn-group-sm me-2" role="group">
                    <button type="button" class="btn btn-outline-secondary active" id="viewportDesktop" title="Desktop View (100%)">
                        <i data-lucide="monitor" style="width: 14px; height: 14px;"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="viewportTablet" title="Tablet View (768px)">
                        <i data-lucide="tablet" style="width: 14px; height: 14px;"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="viewportMobile" title="Mobile View (375px)">
                        <i data-lucide="smartphone" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>

                <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#revisionsModal">
                    <i data-lucide="history" style="width: 14px; height: 14px;"></i>
                    <span>Revisions ({{ $page->revisions->count() }})</span>
                </button>

                <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" id="btnSaveDraft">
                    <i data-lucide="save" style="width: 14px; height: 14px;"></i>
                    <span id="saveDraftText">Save Draft</span>
                </button>

                <button type="button" class="btn btn-sm btn-success d-flex align-items-center gap-1" id="btnPublish">
                    <i data-lucide="send" style="width: 14px; height: 14px;"></i>
                    <span id="publishText">Publish</span>
                </button>

                @if ($page->isPublished())
                    <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-light" title="View Live Page">
                        <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Alert / Toast Banner -->
    <div id="builderAlert" class="alert d-none mb-0"></div>

    <!-- Main Builder Split View -->
    <div class="row g-3">
        <!-- Left: Blocks Canvas & Manager -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
                <div class="card-header d-flex justify-content-between align-items-center p-3 border-bottom" style="background: rgba(255,255,255,0.02); border-color: var(--admin-border) !important;">
                    <h5 class="h6 fw-bold mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="layers" class="text-primary" style="width: 16px; height: 16px;"></i>
                        <span>Page Sections & Blocks</span>
                    </h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-primary dropdown-toggle d-flex align-items-center gap-1" type="button" data-bs-toggle="dropdown">
                            <i data-lucide="plus" style="width: 14px; height: 14px;"></i>
                            <span>Add Block</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            @foreach ($availableBlocks as $def)
                                <li>
                                    <button class="dropdown-item py-2 add-block-btn" type="button" data-block-type="{{ $def['type'] }}">
                                        <div class="fw-semibold">{{ $def['name'] }}</div>
                                        <small class="text-secondary">{{ $def['description'] }}</small>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="card-body p-3">
                    <div id="blocksList" class="d-flex flex-column gap-3">
                        <!-- Populated by JS -->
                    </div>
                    <div id="emptyBlocksMessage" class="text-center py-5 text-secondary d-none">
                        <i data-lucide="box" class="mb-2" style="width: 32px; height: 32px;"></i>
                        <p class="mb-2">No blocks added yet.</p>
                        <small>Click "Add Block" above to compose this page layout.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Real-time Responsive Preview -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
                <div class="card-header d-flex justify-content-between align-items-center p-3 border-bottom" style="background: rgba(255,255,255,0.02); border-color: var(--admin-border) !important;">
                    <h5 class="h6 fw-bold mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="eye" class="text-success" style="width: 16px; height: 16px;"></i>
                        <span>Live Preview Frame</span>
                    </h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnRefreshPreview" title="Refresh Preview">
                        <i data-lucide="refresh-cw" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>
                <div class="card-body p-2 d-flex justify-content-center align-items-start" style="background: #020408; min-height: 600px; overflow-x: auto;">
                    <div id="previewFrameWrapper" style="width: 100%; transition: width 0.3s ease; height: 750px;">
                        <iframe id="previewIframe" src="{{ route('admin.pages.builder.preview', $page) }}" style="width: 100%; height: 100%; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; background: #070a12;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revisions Modal -->
<div class="modal fade" id="revisionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border); color: var(--admin-text);">
            <div class="modal-header border-bottom" style="border-color: var(--admin-border) !important;">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i data-lucide="history" class="text-primary"></i>
                    <span>Revision History</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="color: var(--admin-text);">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">Revision</th>
                                <th>Created At</th>
                                <th>Blocks</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($page->revisions as $rev)
                                <tr>
                                    <td class="ps-3">
                                        <span class="badge bg-secondary">Rev #{{ $rev->revision_number }}</span>
                                    </td>
                                    <td>{{ $rev->created_at->format('M d, Y H:i:s') }}</td>
                                    <td>{{ count($rev->content_json ?? []) }} blocks</td>
                                    <td class="text-end pe-3">
                                        <form action="{{ route('admin.pages.builder.restore', [$page, $rev->revision_number]) }}" method="POST" onsubmit="return confirm('Restore Revision #{{ $rev->revision_number }}?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                                Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-secondary">
                                        No revisions recorded yet. Revisions are created automatically upon publishing.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentBlocks = @json($blocks ?? []);
    const availableDefinitions = @json($availableBlocks);
    const saveDraftUrl = @json(route('admin.pages.builder.save-draft', $page));
    const publishUrl = @json(route('admin.pages.builder.publish', $page));
    const csrfToken = '{{ csrf_token() }}';

    const blocksListEl = document.getElementById('blocksList');
    const emptyMsgEl = document.getElementById('emptyBlocksMessage');
    const alertEl = document.getElementById('builderAlert');
    const iframeEl = document.getElementById('previewIframe');
    const frameWrapper = document.getElementById('previewFrameWrapper');

    function showAlert(type, msg) {
        alertEl.className = `alert alert-${type} mb-3`;
        alertEl.textContent = msg;
        alertEl.classList.remove('d-none');
        setTimeout(() => alertEl.classList.add('d-none'), 5000);
    }

    // Viewport controls
    document.getElementById('viewportDesktop').addEventListener('click', function() {
        frameWrapper.style.width = '100%';
        setActiveViewport(this);
    });
    document.getElementById('viewportTablet').addEventListener('click', function() {
        frameWrapper.style.width = '768px';
        setActiveViewport(this);
    });
    document.getElementById('viewportMobile').addEventListener('click', function() {
        frameWrapper.style.width = '375px';
        setActiveViewport(this);
    });

    function setActiveViewport(btn) {
        document.querySelectorAll('#viewportDesktop, #viewportTablet, #viewportMobile').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    document.getElementById('btnRefreshPreview').addEventListener('click', function() {
        iframeEl.contentWindow.location.reload();
    });

    // Render Blocks
    function renderBlocks() {
        blocksListEl.innerHTML = '';
        if (!currentBlocks || currentBlocks.length === 0) {
            emptyMsgEl.classList.remove('d-none');
            return;
        }
        emptyMsgEl.classList.add('d-none');

        currentBlocks.forEach((block, index) => {
            const def = availableDefinitions.find(d => d.type === block.type) || { name: block.type, icon: 'box' };
            const card = document.createElement('div');
            card.className = 'card border-secondary mb-2';
            card.style.background = 'rgba(255,255,255,0.02)';

            card.innerHTML = `
                <div class="card-header d-flex justify-content-between align-items-center p-2 bg-dark">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary">${index + 1}</span>
                        <strong class="small">${def.name}</strong>
                        <span class="badge ${block.enabled ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'} small">${block.enabled ? 'Active' : 'Disabled'}</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-1 btn-move-up" data-index="${index}" title="Move Up" ${index === 0 ? 'disabled' : ''}>&uarr;</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-1 btn-move-down" data-index="${index}" title="Move Down" ${index === currentBlocks.length - 1 ? 'disabled' : ''}>&darr;</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 btn-toggle-settings" data-index="${index}" title="Configure">Settings</button>
                        <button type="button" class="btn btn-sm btn-outline-danger py-0 px-1 btn-remove-block" data-index="${index}" title="Delete">&times;</button>
                    </div>
                </div>
                <div class="card-body p-3 settings-panel d-none" id="settings-${index}">
                    ${renderSettingsFields(block, index)}
                </div>
            `;

            blocksListEl.appendChild(card);
        });

        attachBlockEvents();
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }

    function renderSettingsFields(block, index) {
        const s = block.settings || {};
        let fieldsHtml = `
            <div class="form-check form-switch mb-3">
                <input class="form-check-input field-input" type="checkbox" data-index="${index}" data-prop="enabled" ${block.enabled ? 'checked' : ''} id="enableSwitch-${index}">
                <label class="form-check-label small" for="enableSwitch-${index}">Section Enabled</label>
            </div>
        `;

        if (block.type === 'hero') {
            fieldsHtml += `
                <div class="mb-2">
                    <label class="form-label small">Badge Text</label>
                    <input type="text" class="form-control form-control-sm field-setting" data-index="${index}" data-key="badge" value="${escapeHtml(s.badge || '')}">
                </div>
                <div class="mb-2">
                    <label class="form-label small">Headline</label>
                    <input type="text" class="form-control form-control-sm field-setting" data-index="${index}" data-key="headline" value="${escapeHtml(s.headline || '')}">
                </div>
                <div class="mb-2">
                    <label class="form-label small">Subheadline</label>
                    <textarea class="form-control form-control-sm field-setting" data-index="${index}" data-key="subheadline" rows="2">${escapeHtml(s.subheadline || '')}</textarea>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <label class="form-label small">Primary CTA Label</label>
                        <input type="text" class="form-control form-control-sm field-setting" data-index="${index}" data-key="cta_primary_label" value="${escapeHtml(s.cta_primary_label || '')}">
                    </div>
                    <div class="col-6">
                        <label class="form-label small">Primary CTA URL</label>
                        <input type="text" class="form-control form-control-sm field-setting" data-index="${index}" data-key="cta_primary_url" value="${escapeHtml(s.cta_primary_url || '')}">
                    </div>
                </div>
            `;
        } else if (block.type === 'about') {
            fieldsHtml += `
                <div class="mb-2">
                    <label class="form-label small">Title</label>
                    <input type="text" class="form-control form-control-sm field-setting" data-index="${index}" data-key="title" value="${escapeHtml(s.title || '')}">
                </div>
                <div class="mb-2">
                    <label class="form-label small">Subtitle</label>
                    <input type="text" class="form-control form-control-sm field-setting" data-index="${index}" data-key="subtitle" value="${escapeHtml(s.subtitle || '')}">
                </div>
                <div class="mb-2">
                    <label class="form-label small">Bio Paragraph</label>
                    <textarea class="form-control form-control-sm field-setting" data-index="${index}" data-key="bio" rows="4">${escapeHtml(s.bio || '')}</textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label small">Highlights (Comma-separated)</label>
                    <input type="text" class="form-control form-control-sm field-setting" data-index="${index}" data-key="highlights" value="${escapeHtml(s.highlights || '')}">
                </div>
            `;
        } else if (block.type === 'custom_html') {
            fieldsHtml += `
                <div class="mb-2">
                    <label class="form-label small">Custom HTML (Sanitized)</label>
                    <textarea class="form-control form-control-sm font-monospace field-setting" data-index="${index}" data-key="html" rows="6">${escapeHtml(s.html || '')}</textarea>
                    <small class="text-secondary">Note: unsafe script tags are stripped automatically.</small>
                </div>
            `;
        } else {
            fieldsHtml += `
                <div class="mb-2">
                    <label class="form-label small">Title</label>
                    <input type="text" class="form-control form-control-sm field-setting" data-index="${index}" data-key="title" value="${escapeHtml(s.title || '')}">
                </div>
                <div class="mb-2">
                    <label class="form-label small">Subtitle</label>
                    <input type="text" class="form-control form-control-sm field-setting" data-index="${index}" data-key="subtitle" value="${escapeHtml(s.subtitle || '')}">
                </div>
            `;
        }

        return fieldsHtml;
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    function attachBlockEvents() {
        document.querySelectorAll('.btn-toggle-settings').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = this.dataset.index;
                const panel = document.getElementById(`settings-${idx}`);
                panel.classList.toggle('d-none');
            });
        });

        document.querySelectorAll('.btn-remove-block').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.dataset.index, 10);
                currentBlocks.splice(idx, 1);
                renderBlocks();
            });
        });

        document.querySelectorAll('.btn-move-up').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.dataset.index, 10);
                if (idx > 0) {
                    const temp = currentBlocks[idx - 1];
                    currentBlocks[idx - 1] = currentBlocks[idx];
                    currentBlocks[idx] = temp;
                    renderBlocks();
                }
            });
        });

        document.querySelectorAll('.btn-move-down').forEach(btn => {
            btn.addEventListener('click', function() {
                const idx = parseInt(this.dataset.index, 10);
                if (idx < currentBlocks.length - 1) {
                    const temp = currentBlocks[idx + 1];
                    currentBlocks[idx + 1] = currentBlocks[idx];
                    currentBlocks[idx] = temp;
                    renderBlocks();
                }
            });
        });

        document.querySelectorAll('.field-input').forEach(input => {
            input.addEventListener('change', function() {
                const idx = parseInt(this.dataset.index, 10);
                currentBlocks[idx].enabled = this.checked;
            });
        });

        document.querySelectorAll('.field-setting').forEach(input => {
            input.addEventListener('input', function() {
                const idx = parseInt(this.dataset.index, 10);
                const key = this.dataset.key;
                if (!currentBlocks[idx].settings) currentBlocks[idx].settings = {};
                currentBlocks[idx].settings[key] = this.value;
            });
        });
    }

    // Add Block
    document.querySelectorAll('.add-block-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.dataset.blockType;
            const def = availableDefinitions.find(d => d.type === type);
            const newBlock = {
                id: 'block-' + (Date.now()),
                type: type,
                enabled: true,
                settings: def ? Object.assign({}, def.defaultSettings) : {}
            };
            currentBlocks.push(newBlock);
            renderBlocks();
        });
    });

    // Save Draft
    document.getElementById('btnSaveDraft').addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        document.getElementById('saveDraftText').textContent = 'Saving...';

        fetch(saveDraftUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ blocks: currentBlocks })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            document.getElementById('saveDraftText').textContent = 'Save Draft';
            if (data.success) {
                showAlert('success', 'Draft saved successfully.');
                iframeEl.contentWindow.location.reload();
            } else {
                showAlert('danger', data.message || 'Error saving draft.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            document.getElementById('saveDraftText').textContent = 'Save Draft';
            showAlert('danger', 'Network error saving draft.');
        });
    });

    // Publish
    document.getElementById('btnPublish').addEventListener('click', function() {
        const btn = this;
        btn.disabled = true;
        document.getElementById('publishText').textContent = 'Publishing...';

        fetch(publishUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ blocks: currentBlocks })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            document.getElementById('publishText').textContent = 'Publish';
            if (data.success) {
                showAlert('success', data.message || 'Page published successfully.');
                document.getElementById('pageStatusBadge').className = 'badge bg-success-subtle text-success border border-success-subtle px-2 py-1';
                document.getElementById('pageStatusBadge').textContent = 'Published';
                iframeEl.contentWindow.location.reload();
            } else {
                showAlert('danger', data.message || 'Error publishing page.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            document.getElementById('publishText').textContent = 'Publish';
            showAlert('danger', 'Network error publishing page.');
        });
    });

    // Initial render
    renderBlocks();
});
</script>
@endsection
