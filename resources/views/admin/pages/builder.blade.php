@extends('layouts.admin')

@section('title', 'Visual Builder: ' . $page->title)

@push('styles')
<!-- GrapesJS Core Styles -->
<link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
<style>
    /* Elementor-Style Studio Container */
    .builder-studio-wrapper {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--admin-border);
        box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.5);
        background: #090d16;
        height: calc(100vh - 120px);
        min-height: 720px;
    }

    /* Left Sidebar: Widgets, Styles, Code Paste, Layers */
    .builder-sidebar-panel {
        width: 350px;
        min-width: 350px;
        background: #0d1322;
        border-right: 1px solid var(--admin-border);
        display: flex;
        flex-direction: column;
        z-index: 20;
    }

    .builder-sidebar-panel .nav-tabs {
        background: #080c16;
        border-bottom: 1px solid var(--admin-border);
    }

    .builder-sidebar-panel .nav-link {
        color: #94a3b8;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 8px;
        font-size: 0.78rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .builder-sidebar-panel .nav-link:hover {
        color: #f8fafc;
        background: rgba(255, 255, 255, 0.03);
    }

    .builder-sidebar-panel .nav-link.active {
        color: #10b981;
        background: #0d1322;
        border-bottom: 2px solid #10b981;
    }

    /* Block Elements Palette */
    #blocks-container {
        padding: 8px;
    }

    .gjs-block-category .gjs-title {
        background: #141d33 !important;
        color: #cbd5e1 !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        padding: 8px 12px !important;
        border-radius: 6px !important;
        margin-top: 10px !important;
        margin-bottom: 6px !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    .gjs-blocks-c {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 8px !important;
        padding: 4px 0 !important;
    }

    .gjs-block {
        user-select: none;
        width: 100% !important;
        min-height: 70px !important;
        margin: 0 !important;
        padding: 12px 8px !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 8px !important;
        background: #111a2e !important;
        color: #e2e8f0 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        text-align: center !important;
        cursor: grab !important;
        transition: all 0.18s ease !important;
    }

    .gjs-block:hover {
        border-color: #10b981 !important;
        color: #10b981 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25) !important;
        background: #14223d !important;
    }

    .gjs-block-label {
        font-size: 0.72rem !important;
        font-weight: 600 !important;
        margin-top: 4px !important;
        line-height: 1.25 !important;
    }

    /* Style Manager Overrides */
    #styles-container {
        padding: 8px;
    }

    .gjs-sm-sector .gjs-sm-sector-title {
        background: #141d33 !important;
        color: #cbd5e1 !important;
        font-weight: 600 !important;
        font-size: 0.78rem !important;
        border-radius: 6px !important;
        padding: 8px 12px !important;
        margin-bottom: 4px !important;
        border: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    .gjs-sm-properties {
        background: transparent !important;
        padding: 6px 4px !important;
    }

    .gjs-field {
        background-color: #080c16 !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #f8fafc !important;
        border-radius: 6px !important;
    }

    /* Canvas Area */
    .builder-canvas-wrapper {
        flex: 1;
        position: relative;
        background: #03060d;
        overflow: hidden;
    }

    .gjs-cv-canvas {
        width: 100% !important;
        height: 100% !important;
        top: 0 !important;
    }

    /* GrapesJS internal toolbar cleanup: hide redundant default topbar */
    .gjs-pn-views, .gjs-pn-views-container {
        display: none !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <!-- 1. Top Action Bar -->
    <div class="admin-card p-3 mb-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-outline-secondary" title="Back to Page Manager">
                <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            </a>
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h1 class="h5 fw-bold mb-0 text-white">{{ $page->title }}</h1>
                    <code class="text-emerald small px-2 py-0 bg-dark rounded border border-secondary-subtle">/{{ $page->slug }}</code>
                    <span id="pageStatusBadge" class="badge {{ $page->status === 'published' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }} px-2 py-1">
                        {{ ucfirst($page->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Controls: Responsive Viewports, Code Paste, Revisions, Save/Publish -->
        <div class="d-flex align-items-center gap-2">
            <!-- Viewport Switchers -->
            <div class="btn-group btn-group-sm me-1" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="btnDeviceDesktop" title="Desktop View (100%)">
                    <i data-lucide="monitor" style="width: 14px; height: 14px;"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnDeviceTablet" title="Tablet View (768px)">
                    <i data-lucide="tablet" style="width: 14px; height: 14px;"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnDeviceMobile" title="Mobile View (375px)">
                    <i data-lucide="smartphone" style="width: 14px; height: 14px;"></i>
                </button>
            </div>

            <!-- Undo / Redo -->
            <div class="btn-group btn-group-sm me-1" role="group">
                <button type="button" class="btn btn-outline-secondary" id="btnUndo" title="Undo (Ctrl+Z)">
                    <i data-lucide="undo-2" style="width: 14px; height: 14px;"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnRedo" title="Redo (Ctrl+Y)">
                    <i data-lucide="redo-2" style="width: 14px; height: 14px;"></i>
                </button>
            </div>

            <!-- Paste & Import Code Button -->
            <button type="button" class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#pasteCodeModal" title="Paste Custom HTML / CSS / JS">
                <i data-lucide="clipboard-paste" style="width: 14px; height: 14px;"></i>
                <span>Paste Code</span>
            </button>

            <!-- Inspect / Export Code Button -->
            <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#codeViewModal" title="View & Inspect Code">
                <i data-lucide="code-2" style="width: 14px; height: 14px;"></i>
                <span>View Code</span>
            </button>

            <!-- Revisions History Modal -->
            <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#revisionsModal">
                <i data-lucide="history" style="width: 14px; height: 14px;"></i>
                <span>Revisions ({{ $page->revisions->count() }})</span>
            </button>

            <!-- Save Draft -->
            <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" id="btnSaveDraft">
                <i data-lucide="save" style="width: 14px; height: 14px;"></i>
                <span id="saveDraftText">Save Draft</span>
            </button>

            <!-- Publish Button -->
            <button type="button" class="btn btn-sm btn-emerald d-flex align-items-center gap-1" id="btnPublish">
                <i data-lucide="send" style="width: 14px; height: 14px;"></i>
                <span id="publishText">Publish</span>
            </button>

            @if ($page->isPublished())
                <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View Live Page">
                    <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
                </a>
            @endif
        </div>
    </div>

    <!-- Alert / Toast Banner -->
    <div id="builderAlert" class="alert d-none mb-3"></div>

    <!-- 2. Elementor Pro Style Studio: Always-Visible Sidebar + Canvas -->
    <div class="d-flex builder-studio-wrapper">
        <!-- Left Sidebar (Always Visible) -->
        <div class="builder-sidebar-panel">
            <!-- Sidebar Navigation Tabs -->
            <ul class="nav nav-tabs nav-fill" id="builderSidebarTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active d-flex align-items-center justify-content-center gap-1" id="tab-blocks-btn" data-bs-toggle="tab" data-bs-target="#tab-blocks">
                        <i data-lucide="plus-circle" style="width: 14px; height: 14px;"></i>
                        <span>Elements</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link d-flex align-items-center justify-content-center gap-1" id="tab-styles-btn" data-bs-toggle="tab" data-bs-target="#tab-styles">
                        <i data-lucide="sliders" style="width: 14px; height: 14px;"></i>
                        <span>Styles</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link d-flex align-items-center justify-content-center gap-1" id="tab-paste-btn" data-bs-toggle="tab" data-bs-target="#tab-paste">
                        <i data-lucide="file-code-2" style="width: 14px; height: 14px;"></i>
                        <span>Paste Code</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link d-flex align-items-center justify-content-center gap-1" id="tab-layers-btn" data-bs-toggle="tab" data-bs-target="#tab-layers">
                        <i data-lucide="layers" style="width: 14px; height: 14px;"></i>
                        <span>Layers</span>
                    </button>
                </li>
            </ul>

            <!-- Tab Content Panes -->
            <div class="tab-content flex-grow-1 overflow-y-auto" id="builderTabContent">
                <!-- 1. Elements Palette (Blocks) -->
                <div class="tab-pane fade show active p-2" id="tab-blocks">
                    <div class="mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-dark border-secondary-subtle text-secondary">
                                <i data-lucide="search" style="width: 13px; height: 13px;"></i>
                            </span>
                            <input type="text" id="searchBlocksInput" class="form-control form-control-sm bg-dark border-secondary-subtle text-light" placeholder="Filter elements (hero, card, button...)">
                        </div>
                    </div>
                    <!-- Block Manager Target Container -->
                    <div id="blocks-container"></div>
                </div>

                <!-- 2. Styles Panel (Style Manager) -->
                <div class="tab-pane fade p-2" id="tab-styles">
                    <div id="styleNotice" class="p-2 mb-2 bg-dark rounded border border-secondary-subtle text-secondary small d-flex align-items-center gap-2">
                        <i data-lucide="mouse-pointer" style="width: 14px; height: 14px;"></i>
                        <span>Click any element on canvas to customize typography, colors, padding &amp; borders.</span>
                    </div>
                    <!-- Style Manager Target Container -->
                    <div id="styles-container"></div>
                </div>

                <!-- 3. Direct Code Paste Tab (HTML / CSS / JS) -->
                <div class="tab-pane fade p-3" id="tab-paste">
                    <div class="mb-2">
                        <h6 class="fw-bold text-white small mb-1">Paste Custom HTML &amp; Inline Code</h6>
                        <p class="text-secondary small" style="font-size: 0.75rem;">Paste any hand-crafted HTML, inline styles, or component code directly into the canvas.</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Custom HTML Code</label>
                        <textarea id="sidebarHtmlInput" class="form-control bg-dark text-light font-monospace small" rows="8" placeholder="<div class='custom-hero'><h1>Hello World</h1><p>My custom design</p></div>"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-semibold">Custom CSS Styles (Optional)</label>
                        <textarea id="sidebarCssInput" class="form-control bg-dark text-info font-monospace small" rows="5" placeholder=".custom-hero { background: #0b1120; color: #10b981; padding: 40px; }"></textarea>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <button type="button" class="btn btn-sm btn-emerald w-100" id="btnApplySidebarCode">
                            <i data-lucide="check" style="width: 14px; height: 14px;" class="me-1"></i> Apply &amp; Render on Canvas
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary w-100" id="btnAppendSidebarCode">
                            <i data-lucide="plus" style="width: 14px; height: 14px;" class="me-1"></i> Append to Bottom
                        </button>
                    </div>
                </div>

                <!-- 4. Layers Tree Panel -->
                <div class="tab-pane fade p-2" id="tab-layers">
                    <div class="text-secondary small p-2">DOM Elements Hierarchy:</div>
                    <div id="layers-container"></div>
                </div>
            </div>
        </div>

        <!-- Canvas Area (Center & Right) -->
        <div class="builder-canvas-wrapper">
            <div id="gjs"></div>
        </div>
    </div>
</div>

<!-- Modal 1: Paste & Import Full Code Modal (With Clean Tabs) -->
<div class="modal fade" id="pasteCodeModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-dark border border-secondary text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i data-lucide="clipboard-paste" class="text-warning"></i>
                    <span>Paste &amp; Import Custom HTML / CSS / JS</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <p class="text-secondary small mb-3">
                    Paste custom design code from CodePen, Tailwind, Bootstrap, Figma, or your custom template. The visual builder will parse and render it live on the canvas.
                </p>

                <ul class="nav nav-pills mb-3" id="importTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active py-1 px-3 small" data-bs-toggle="pill" data-bs-target="#importTabHtml">HTML Code</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link py-1 px-3 small" data-bs-toggle="pill" data-bs-target="#importTabCss">CSS Styles</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="importTabHtml">
                        <label class="form-label small text-secondary fw-semibold">Paste HTML (supports inline styles, divs, sections, forms, and custom components):</label>
                        <textarea id="importModalHtml" class="form-control bg-black text-light font-monospace small" rows="14" placeholder="<div class='hero-section' style='padding: 60px 20px; background: #0f172a;'>
    <h1 style='color: #ffffff; font-size: 2.5rem;'>My Custom Landing Page</h1>
    <p style='color: #94a3b8;'>Pasted directly from external design.</p>
</div>"></textarea>
                    </div>
                    <div class="tab-pane fade" id="importTabCss">
                        <label class="form-label small text-secondary fw-semibold">Paste CSS Rules:</label>
                        <textarea id="importModalCss" class="form-control bg-black text-info font-monospace small" rows="14" placeholder=".hero-section { border-radius: 12px; }
h1 { letter-spacing: -0.02em; }"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top border-secondary justify-content-between">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-light" onclick="loadStarterPortfolioTemplate()">
                        <i data-lucide="sparkles" style="width: 14px; height: 14px;" class="me-1"></i> Load Starter Portfolio Template
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="if(confirm('Clear the entire canvas?')) { editor.setComponents(''); editor.setStyle(''); }">
                        <i data-lucide="trash-2" style="width: 14px; height: 14px;" class="me-1"></i> Clear Canvas
                    </button>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-outline-info" id="btnAppendFromModal">
                        Append to Existing Content
                    </button>
                    <button type="button" class="btn btn-sm btn-emerald" id="btnApplyFromModal">
                        Replace Canvas with Pasted Code
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: View & Copy Generated Code Modal -->
<div class="modal fade" id="codeViewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-dark border border-secondary text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i data-lucide="code-2" class="text-info"></i>
                    <span>Inspect &amp; Export Page Code</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label small text-secondary fw-bold">Live HTML Structure</label>
                        <textarea id="modalHtmlCode" class="form-control bg-black text-light font-monospace small" rows="18"></textarea>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small text-secondary fw-bold">Live CSS Styling Rules</label>
                        <textarea id="modalCssCode" class="form-control bg-black text-info font-monospace small" rows="18"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top border-secondary justify-content-between">
                <button type="button" class="btn btn-sm btn-emerald" id="btnApplyFromViewCode">
                    <i data-lucide="check" style="width: 14px; height: 14px;" class="me-1"></i> Apply Edits Back to Canvas
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="navigator.clipboard.writeText(document.getElementById('modalHtmlCode').value); alert('HTML copied to clipboard!');">
                        <i data-lucide="copy" style="width: 14px; height: 14px;" class="me-1"></i> Copy HTML
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Revisions & Code Rollback Modal -->
<div class="modal fade" id="revisionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark border border-secondary text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i data-lucide="history" class="text-emerald"></i>
                    <span>Revision History &amp; 1-Click Rollback</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-light">
                        <thead class="table-dark text-secondary small">
                            <tr>
                                <th class="ps-3">Revision</th>
                                <th>Saved Date &amp; Time</th>
                                <th>Published By</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($page->revisions as $rev)
                                <tr>
                                    <td class="ps-3">
                                        <span class="badge bg-secondary font-monospace">Rev #{{ $rev->revision_number }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $rev->created_at->format('M d, Y · h:i A') }}</div>
                                        <small class="text-secondary">{{ $rev->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <span class="small text-secondary">{{ $rev->creator?->name ?? 'Author' }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <form action="{{ route('admin.pages.builder.restore', [$page, $rev->revision_number]) }}" method="POST" onsubmit="return confirm('Restore Revision #{{ $rev->revision_number }}? This will replace your canvas with this exact snapshot.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1">
                                                <i data-lucide="rotate-ccw" style="width: 14px; height: 14px;"></i>
                                                <span>Restore Code</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-secondary">
                                        <i data-lucide="history" class="mb-2" style="width: 32px; height: 32px;"></i>
                                        <p class="mb-1">No revisions recorded yet.</p>
                                        <small>Every time you click "Publish", a permanent snapshot revision is automatically created.</small>
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

@push('scripts')
<!-- GrapesJS Core Library -->
<script src="https://unpkg.com/grapesjs/dist/grapes.min.js"></script>
<script>
let editor; // Global editor instance

document.addEventListener('DOMContentLoaded', function() {
    const rawContent = @json($blocks ?? []);
    const saveDraftUrl = @json(route('admin.pages.builder.save-draft', $page));
    const publishUrl = @json(route('admin.pages.builder.publish', $page));
    const csrfToken = '{{ csrf_token() }}';

    const alertEl = document.getElementById('builderAlert');

    function showAlert(type, msg) {
        alertEl.className = `alert alert-${type} mb-3 shadow-sm`;
        alertEl.innerHTML = `<i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="me-2" style="width: 16px; height: 16px;"></i> <span>${msg}</span>`;
        alertEl.classList.remove('d-none');
        if (window.lucide) lucide.createIcons();
        setTimeout(() => alertEl.classList.add('d-none'), 5000);
    }

    // Determine initial HTML & CSS from page content
    let initialHtml = '';
    let initialCss = '';
    let initialComponents = null;
    let initialStyle = null;

    if (rawContent) {
        if (rawContent.html) {
            initialHtml = rawContent.html;
            initialCss = rawContent.css || '';
            initialComponents = rawContent.components || null;
            initialStyle = rawContent.style || null;
        } else if (Array.isArray(rawContent) && rawContent.length > 0) {
            initialHtml = `
                <div class="py-5 text-center" style="font-family: system-ui, sans-serif; background: #070a14; color: #f8fafc; min-height: 100vh; padding: 60px 20px;">
                    <div style="max-width: 900px; margin: 0 auto;">
                        <span style="display: inline-block; padding: 6px 14px; border-radius: 9999px; background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px; border: 1px solid rgba(16, 185, 129, 0.3);">
                            ✦ Available for High-Impact Projects
                        </span>
                        <h1 style="font-size: 3rem; font-weight: 800; line-height: 1.15; margin-bottom: 20px; color: #ffffff;">
                            ${@json($page->title)}
                        </h1>
                        <p style="font-size: 1.25rem; color: #94a3b8; max-width: 700px; margin: 0 auto 35px auto; line-height: 1.6;">
                            Crafting scalable web architectures, custom Laravel solutions, and seamless user experiences.
                        </p>
                        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                            <a href="#projects" style="display: inline-block; padding: 12px 28px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">Explore Projects &rarr;</a>
                            <a href="#contact" style="display: inline-block; padding: 12px 28px; background: rgba(255,255,255,0.08); color: #f8fafc; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid rgba(255,255,255,0.15);">Get in Touch</a>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    if (!initialHtml) {
        initialHtml = `
            <div style="font-family: system-ui, sans-serif; background: #070a14; color: #f8fafc; min-height: 100vh; padding: 60px 20px;">
                <div style="max-width: 960px; margin: 0 auto; text-align: center;">
                    <span style="display: inline-block; padding: 6px 14px; border-radius: 9999px; background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px;">
                        ✦ Professional Portfolio Builder
                    </span>
                    <h1 style="font-size: 3.25rem; font-weight: 800; line-height: 1.15; margin-bottom: 20px; color: #ffffff;">
                        ${@json($page->title)}
                    </h1>
                    <p style="font-size: 1.2rem; color: #94a3b8; max-width: 680px; margin: 0 auto 35px auto;">
                        Drag and drop blocks from the left panel to customize your layout. Click any text to edit directly.
                    </p>
                    <div style="display: flex; gap: 16px; justify-content: center;">
                        <a href="#work" style="display: inline-block; padding: 12px 28px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">View Portfolio</a>
                        <a href="#contact" style="display: inline-block; padding: 12px 28px; background: rgba(255,255,255,0.08); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">Contact Me</a>
                    </div>
                </div>
            </div>
        `;
    }

    // Initialize GrapesJS Visual Editor with Dedicated Container IDs
    editor = grapesjs.init({
        container: '#gjs',
        fromElement: false,
        height: '100%',
        width: 'auto',
        storageManager: false,
        panels: { defaults: [] }, // Hide confusing default duplicate buttons
        blockManager: {
            appendTo: '#blocks-container',
        },
        styleManager: {
            appendTo: '#styles-container',
            sectors: [
                {
                    name: 'Typography',
                    open: true,
                    properties: [
                        { name: 'Font', property: 'font-family', type: 'select', defaults: 'Inter', options: [
                            { value: 'Inter, sans-serif', name: 'Inter' },
                            { value: 'Plus Jakarta Sans, sans-serif', name: 'Plus Jakarta' },
                            { value: 'JetBrains Mono, monospace', name: 'JetBrains Mono' },
                            { value: 'serif', name: 'Serif' }
                        ]},
                        { name: 'Size', property: 'font-size', type: 'integer', units: ['px', 'rem', 'em'], defaults: '16px' },
                        { name: 'Weight', property: 'font-weight', type: 'select', options: [
                            { value: '300', name: 'Light' },
                            { value: '400', name: 'Regular' },
                            { value: '600', name: 'Semi-Bold' },
                            { value: '700', name: 'Bold' },
                            { value: '800', name: 'Extra-Bold' }
                        ]},
                        { name: 'Color', property: 'color', type: 'color' },
                        { name: 'Align', property: 'text-align', type: 'radio', options: [
                            { value: 'left', name: 'Left' },
                            { value: 'center', name: 'Center' },
                            { value: 'right', name: 'Right' },
                            { value: 'justify', name: 'Justify' }
                        ]},
                        { name: 'Line Height', property: 'line-height' }
                    ]
                },
                {
                    name: 'Dimensions & Spacing',
                    open: true,
                    properties: [
                        { name: 'Width', property: 'width' },
                        { name: 'Height', property: 'height' },
                        { name: 'Max Width', property: 'max-width' },
                        { name: 'Margin', property: 'margin' },
                        { name: 'Padding', property: 'padding' }
                    ]
                },
                {
                    name: 'Background & Colors',
                    open: false,
                    properties: [
                        { name: 'Background Color', property: 'background-color', type: 'color' },
                        { name: 'Background', property: 'background' }
                    ]
                },
                {
                    name: 'Borders & Shadow',
                    open: false,
                    properties: [
                        { name: 'Border Radius', property: 'border-radius', type: 'integer', units: ['px', '%'] },
                        { name: 'Border', property: 'border' },
                        { name: 'Box Shadow', property: 'box-shadow' },
                        { name: 'Opacity', property: 'opacity' }
                    ]
                }
            ]
        },
        layerManager: {
            appendTo: '#layers-container'
        },
        canvas: {
            styles: [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
                'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap'
            ]
        },
        deviceManager: {
            devices: [
                { id: 'desktop', name: 'Desktop', width: '' },
                { id: 'tablet', name: 'Tablet', width: '768px', widthMedia: '992px' },
                { id: 'mobile', name: 'Mobile', width: '375px', widthMedia: '480px' }
            ]
        }
    });

    // Populate All Custom Elementor-style Drag-and-Drop Blocks
    const bm = editor.BlockManager;

    // 1. Grid & Layout
    bm.add('grid-1col', {
        label: 'Container (1 Col)',
        category: 'Layout & Grid',
        content: '<div style="padding: 40px 20px; max-width: 1100px; margin: 0 auto;"><p style="font-size: 1.1rem; color: #94a3b8;">Container block. Drop elements here.</p></div>',
        attributes: { class: 'gjs-fonts gjs-f-b1' }
    });

    bm.add('grid-2col', {
        label: '2 Columns (50/50)',
        category: 'Layout & Grid',
        content: `
            <div style="display: flex; flex-wrap: wrap; gap: 24px; padding: 30px 20px; max-width: 1100px; margin: 0 auto;">
                <div style="flex: 1 1 300px; background: #0f172a; padding: 28px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h3 style="color: #ffffff; font-size: 1.3rem; margin-bottom: 8px;">Column One</h3>
                    <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6;">Highlight your architecture, technical process, or vision here.</p>
                </div>
                <div style="flex: 1 1 300px; background: #0f172a; padding: 28px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h3 style="color: #ffffff; font-size: 1.3rem; margin-bottom: 8px;">Column Two</h3>
                    <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6;">Add metrics, performance evidence, or case study details.</p>
                </div>
            </div>
        `,
        attributes: { class: 'gjs-fonts gjs-f-b2' }
    });

    bm.add('grid-3col', {
        label: '3 Columns (33/33/33)',
        category: 'Layout & Grid',
        content: `
            <div style="display: flex; flex-wrap: wrap; gap: 20px; padding: 30px 20px; max-width: 1100px; margin: 0 auto;">
                <div style="flex: 1 1 260px; background: #0f172a; padding: 24px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h4 style="color: #ffffff; font-size: 1.15rem; margin-bottom: 8px;">Full-Stack Laravel</h4>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Clean architecture, multi-tenant databases, and robust APIs.</p>
                </div>
                <div style="flex: 1 1 260px; background: #0f172a; padding: 24px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h4 style="color: #ffffff; font-size: 1.15rem; margin-bottom: 8px;">Meta CAPI Tracking</h4>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Server-side attribution with zero data loss telemetry.</p>
                </div>
                <div style="flex: 1 1 260px; background: #0f172a; padding: 24px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h4 style="color: #ffffff; font-size: 1.15rem; margin-bottom: 8px;">Courier Integrations</h4>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Automated consignment dispatch and tracking webhooks.</p>
                </div>
            </div>
        `,
        attributes: { class: 'gjs-fonts gjs-f-b3' }
    });

    // 2. Portfolio Elements
    bm.add('portfolio-hero', {
        label: 'Hero Profile Banner',
        category: 'Portfolio Elements',
        content: `
            <section style="padding: 70px 20px; background: radial-gradient(circle at 50% 0%, rgba(16, 185, 129, 0.15) 0%, #070a14 70%); text-align: center;">
                <div style="max-width: 850px; margin: 0 auto;">
                    <div style="display: inline-block; padding: 6px 16px; border-radius: 9999px; background: rgba(16, 185, 129, 0.12); color: #10b981; font-size: 0.85rem; font-weight: 600; margin-bottom: 24px; border: 1px solid rgba(16, 185, 129, 0.3);">
                        ● Available for Select Projects
                    </div>
                    <h1 style="font-size: 3.25rem; font-weight: 800; color: #ffffff; line-height: 1.15; margin-bottom: 20px;">
                        Engineering Digital Experiences &amp; Business Solutions
                    </h1>
                    <p style="font-size: 1.2rem; color: #94a3b8; line-height: 1.6; margin-bottom: 35px;">
                        Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and server-side tracking.
                    </p>
                    <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                        <a href="#projects" style="padding: 14px 32px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);">View Projects &rarr;</a>
                        <a href="#contact" style="padding: 14px 32px; background: #1e293b; color: #f8fafc; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid rgba(255,255,255,0.1);">Initiate Contact</a>
                    </div>
                </div>
            </section>
        `
    });

    bm.add('project-card', {
        label: 'Project Case Study Card',
        category: 'Portfolio Elements',
        content: `
            <div style="background: #0f172a; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.08); overflow: hidden; max-width: 480px; margin: 20px auto; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.4);">
                <div style="height: 200px; background: #1e293b; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 600;">
                    [ Project Preview Image ]
                </div>
                <div style="padding: 24px;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: #10b981; text-transform: uppercase; letter-spacing: 0.05em;">Enterprise SaaS</span>
                    <h3 style="color: #ffffff; font-size: 1.35rem; margin-top: 8px; margin-bottom: 12px;">Flagship E-Commerce Engine</h3>
                    <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                        Custom order orchestration hub with multi-carrier API integrations, automated inventory sync, and real-time conversion telemetry.
                    </p>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px;">
                        <span style="padding: 4px 10px; background: rgba(255,255,255,0.06); color: #cbd5e1; border-radius: 6px; font-size: 0.75rem;">Laravel 11</span>
                        <span style="padding: 4px 10px; background: rgba(255,255,255,0.06); color: #cbd5e1; border-radius: 6px; font-size: 0.75rem;">Vue.js</span>
                        <span style="padding: 4px 10px; background: rgba(255,255,255,0.06); color: #cbd5e1; border-radius: 6px; font-size: 0.75rem;">MySQL</span>
                    </div>
                    <a href="#" style="color: #10b981; text-decoration: none; font-weight: 600; font-size: 0.95rem;">View Full Case Study &rarr;</a>
                </div>
            </div>
        `
    });

    bm.add('skills-cloud', {
        label: 'Skills Badge Matrix',
        category: 'Portfolio Elements',
        content: `
            <div style="padding: 40px 20px; max-width: 900px; margin: 0 auto; text-align: center;">
                <h3 style="color: #ffffff; margin-bottom: 24px; font-size: 1.75rem;">Core Technical Competencies</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center;">
                    <span style="padding: 10px 20px; background: #0f172a; color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">PHP / Laravel</span>
                    <span style="padding: 10px 20px; background: #0f172a; color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">JavaScript / Vue</span>
                    <span style="padding: 10px 20px; background: #0f172a; color: #f43f5e; border: 1px solid rgba(244, 63, 94, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">Meta CAPI Tracking</span>
                    <span style="padding: 10px 20px; background: #0f172a; color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">Courier APIs</span>
                    <span style="padding: 10px 20px; background: #0f172a; color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">REST Architecture</span>
                </div>
            </div>
        `
    });

    bm.add('service-feature-box', {
        label: 'Service Feature Box',
        category: 'Portfolio Elements',
        content: `
            <div style="background: #0f172a; padding: 32px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); max-width: 480px; margin: 20px auto;">
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 1.5rem; margin-bottom: 20px;">
                    ⚡
                </div>
                <h3 style="color: #ffffff; font-size: 1.35rem; margin-bottom: 12px;">Custom Web Applications</h3>
                <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                    End-to-end bespoke web engineering built for high throughput, seamless usability, and maintainability.
                </p>
                <ul style="color: #cbd5e1; font-size: 0.9rem; line-height: 1.8; padding-left: 20px; margin-bottom: 0;">
                    <li>Domain-driven design</li>
                    <li>Automated test pipelines</li>
                    <li>Sub-second query optimization</li>
                </ul>
            </div>
        `
    });

    bm.add('contact-form-block', {
        label: 'Contact Form Block',
        category: 'Portfolio Elements',
        content: `
            <div style="background: #0f172a; padding: 40px; border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.08); max-width: 600px; margin: 40px auto; text-align: center;">
                <h2 style="color: #ffffff; font-size: 2rem; margin-bottom: 12px;">Let's Build Something Exceptional</h2>
                <p style="color: #94a3b8; font-size: 1rem; margin-bottom: 30px;">Have an upcoming project or technical architecture challenge? Drop a message below.</p>
                <form action="/contact" method="POST" style="text-align: left;">
                    <div style="margin-bottom: 16px;">
                        <label style="color: #cbd5e1; font-size: 0.85rem; display: block; margin-bottom: 6px;">Your Name</label>
                        <input type="text" name="name" placeholder="John Doe" style="width: 100%; padding: 12px; background: #070a14; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #ffffff;" required>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="color: #cbd5e1; font-size: 0.85rem; display: block; margin-bottom: 6px;">Email Address</label>
                        <input type="email" name="email" placeholder="john@example.com" style="width: 100%; padding: 12px; background: #070a14; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #ffffff;" required>
                    </div>
                    <div style="margin-bottom: 24px;">
                        <label style="color: #cbd5e1; font-size: 0.85rem; display: block; margin-bottom: 6px;">Message &amp; Project Details</label>
                        <textarea name="message" rows="4" placeholder="Tell me about your goals, timeline, and tech requirements..." style="width: 100%; padding: 12px; background: #070a14; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #ffffff;" required></textarea>
                    </div>
                    <button type="submit" style="width: 100%; padding: 14px; background: #10b981; color: #ffffff; font-weight: 700; border: none; border-radius: 8px; cursor: pointer;">Send Message &rarr;</button>
                </form>
            </div>
        `
    });

    // 3. Basic Content Elements
    bm.add('text-heading', {
        label: 'Heading',
        category: 'Basic Content',
        content: '<h2 style="color: #ffffff; font-size: 2.25rem; font-weight: 700; margin-bottom: 16px;">Compelling Section Title</h2>'
    });

    bm.add('text-paragraph', {
        label: 'Paragraph Text',
        category: 'Basic Content',
        content: '<p style="color: #94a3b8; font-size: 1.05rem; line-height: 1.7; margin-bottom: 20px;">Write your story or detailed project explanation here. Clean typography and optimal contrast.</p>'
    });

    bm.add('button-primary', {
        label: 'CTA Button',
        category: 'Basic Content',
        content: '<a href="#" style="display: inline-block; padding: 12px 28px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">Action Button &rarr;</a>'
    });

    bm.add('custom-html-block', {
        label: 'Custom HTML Embed',
        category: 'Basic Content',
        content: '<div style="padding: 24px; border: 1px dashed rgba(255,255,255,0.2); border-radius: 8px; text-align: center; color: #cbd5e1;"><p class="mb-0">Insert your custom HTML embed code here.</p></div>'
    });

    // Set initial components
    if (initialComponents) {
        editor.setComponents(initialComponents);
    } else {
        editor.setComponents(initialHtml);
    }
    if (initialStyle) {
        editor.setStyle(initialStyle);
    } else if (initialCss) {
        editor.setStyle(initialCss);
    }

    // When an element is selected on canvas, automatically switch tab to Styles!
    editor.on('component:selected', () => {
        const stylesTabBtn = document.getElementById('tab-styles-btn');
        if (stylesTabBtn) {
            const tab = new bootstrap.Tab(stylesTabBtn);
            tab.show();
        }
    });

    // Search/Filter blocks in Elements tab
    const searchBlocksInput = document.getElementById('searchBlocksInput');
    if (searchBlocksInput) {
        searchBlocksInput.addEventListener('input', function() {
            const term = this.value.toLowerCase().trim();
            const blocks = document.querySelectorAll('#blocks-container .gjs-block');
            blocks.forEach(block => {
                const text = block.innerText.toLowerCase();
                block.style.display = text.includes(term) ? 'flex' : 'none';
            });
        });
    }

    // Top Bar Device Switchers
    document.getElementById('btnDeviceDesktop').addEventListener('click', function() {
        editor.setDevice('Desktop');
        setDeviceActive(this);
    });
    document.getElementById('btnDeviceTablet').addEventListener('click', function() {
        editor.setDevice('Tablet');
        setDeviceActive(this);
    });
    document.getElementById('btnDeviceMobile').addEventListener('click', function() {
        editor.setDevice('Mobile');
        setDeviceActive(this);
    });

    function setDeviceActive(btn) {
        document.querySelectorAll('#btnDeviceDesktop, #btnDeviceTablet, #btnDeviceMobile').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    // Undo / Redo
    document.getElementById('btnUndo').addEventListener('click', () => {
        if (editor.UndoManager && typeof editor.UndoManager.undo === 'function') {
            editor.UndoManager.undo();
        } else if (editor.runCommand) {
            editor.runCommand('core:undo');
        }
    });
    document.getElementById('btnRedo').addEventListener('click', () => {
        if (editor.UndoManager && typeof editor.UndoManager.redo === 'function') {
            editor.UndoManager.redo();
        } else if (editor.runCommand) {
            editor.runCommand('core:redo');
        }
    });

    // 1. Sidebar Code Paste Handler
    document.getElementById('btnApplySidebarCode').addEventListener('click', function() {
        const html = document.getElementById('sidebarHtmlInput').value.trim();
        const css = document.getElementById('sidebarCssInput').value.trim();

        if (!html) {
            alert('Please paste some HTML code first.');
            return;
        }

        editor.setComponents(html);
        if (css) {
            editor.setStyle(css);
        }
        showAlert('success', '✓ Custom code applied to canvas successfully!');
    });

    document.getElementById('btnAppendSidebarCode').addEventListener('click', function() {
        const html = document.getElementById('sidebarHtmlInput').value.trim();
        const css = document.getElementById('sidebarCssInput').value.trim();

        if (!html) {
            alert('Please paste some HTML code first.');
            return;
        }

        editor.addComponents(html);
        if (css) {
            editor.setStyle(editor.getCss() + '\n' + css);
        }
        showAlert('success', '✓ Custom code appended to bottom of canvas!');
    });

    // 2. Paste Modal Code Apply Handler
    document.getElementById('btnApplyFromModal').addEventListener('click', function() {
        const html = document.getElementById('importModalHtml').value.trim();
        const css = document.getElementById('importModalCss').value.trim();

        if (!html) {
            alert('Please paste some HTML code to import.');
            return;
        }

        editor.setComponents(html);
        if (css) {
            editor.setStyle(css);
        }

        bootstrap.Modal.getInstance(document.getElementById('pasteCodeModal')).hide();
        showAlert('success', '✓ Canvas replaced with your custom code.');
    });

    document.getElementById('btnAppendFromModal').addEventListener('click', function() {
        const html = document.getElementById('importModalHtml').value.trim();
        const css = document.getElementById('importModalCss').value.trim();

        if (!html) {
            alert('Please paste some HTML code to import.');
            return;
        }

        editor.addComponents(html);
        if (css) {
            editor.setStyle(editor.getCss() + '\n' + css);
        }

        bootstrap.Modal.getInstance(document.getElementById('pasteCodeModal')).hide();
        showAlert('success', '✓ Custom code appended to canvas.');
    });

    // 3. View Code Modal Population & Apply Edits
    const codeModal = document.getElementById('codeViewModal');
    codeModal.addEventListener('show.bs.modal', function() {
        document.getElementById('modalHtmlCode').value = editor.getHtml();
        document.getElementById('modalCssCode').value = editor.getCss();
    });

    document.getElementById('btnApplyFromViewCode').addEventListener('click', function() {
        const editedHtml = document.getElementById('modalHtmlCode').value;
        const editedCss = document.getElementById('modalCssCode').value;

        editor.setComponents(editedHtml);
        editor.setStyle(editedCss);

        bootstrap.Modal.getInstance(codeModal).hide();
        showAlert('success', '✓ Edited code applied back to canvas.');
    });

    // 4. Save Draft AJAX
    document.getElementById('btnSaveDraft').addEventListener('click', function() {
        const btn = this;
        const textSpan = document.getElementById('saveDraftText');
        btn.disabled = true;
        textSpan.textContent = 'Saving...';

        const payload = {
            mode: 'grapesjs',
            html: editor.getHtml(),
            css: editor.getCss(),
            components: editor.getComponents(),
            style: editor.getStyle()
        };

        fetch(saveDraftUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ blocks: payload })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            textSpan.textContent = 'Save Draft';
            if (data.success) {
                showAlert('success', '✓ Draft successfully saved.');
            } else {
                showAlert('danger', data.message || 'Error saving draft.');
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            textSpan.textContent = 'Save Draft';
            showAlert('danger', 'Network error while saving draft.');
        });
    });

    // 5. Publish Page AJAX
    document.getElementById('btnPublish').addEventListener('click', function() {
        const btn = this;
        const textSpan = document.getElementById('publishText');
        btn.disabled = true;
        textSpan.textContent = 'Publishing...';

        const payload = {
            mode: 'grapesjs',
            html: editor.getHtml(),
            css: editor.getCss(),
            components: editor.getComponents(),
            style: editor.getStyle()
        };

        fetch(publishUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ blocks: payload })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            textSpan.textContent = 'Publish';
            if (data.success) {
                showAlert('success', '✓ Page published successfully! Snapshot revision created.');
                const badge = document.getElementById('pageStatusBadge');
                if (badge) {
                    badge.className = 'badge bg-success-subtle text-success border border-success-subtle px-2 py-1';
                    badge.textContent = 'Published';
                }
            } else {
                showAlert('danger', data.message || 'Error publishing page.');
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            textSpan.textContent = 'Publish';
            showAlert('danger', 'Network error while publishing page.');
        });
    });
});

// Helper for starter template loading
function loadStarterPortfolioTemplate() {
    const starterHtml = `
        <div style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif; background: #070a14; color: #f8fafc; min-height: 100vh; padding: 60px 20px;">
            <div style="max-width: 1000px; margin: 0 auto; text-align: center;">
                <span style="display: inline-block; padding: 6px 16px; border-radius: 9999px; background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 0.85rem; font-weight: 600; margin-bottom: 24px; border: 1px solid rgba(16, 185, 129, 0.3);">
                    ● Available for Technical Leadership Roles
                </span>
                <h1 style="font-size: 3.5rem; font-weight: 800; line-height: 1.15; margin-bottom: 24px; color: #ffffff;">
                    Architecting Scalable Web Systems &amp; High-Impact Digital Products
                </h1>
                <p style="font-size: 1.25rem; color: #94a3b8; max-width: 720px; margin: 0 auto 40px auto; line-height: 1.6;">
                    Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, and server-side tracking.
                </p>
                <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                    <a href="#work" style="padding: 14px 32px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">Explore Selected Works &rarr;</a>
                    <a href="#contact" style="padding: 14px 32px; background: #1e293b; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid rgba(255,255,255,0.1);">Get in Touch</a>
                </div>
            </div>
        </div>
    `;
    const starterCss = `
        h1 { letter-spacing: -0.03em; }
        a:hover { opacity: 0.9; }
    `;
    document.getElementById('importModalHtml').value = starterHtml.trim();
    document.getElementById('importModalCss').value = starterCss.trim();
}
</script>
@endpush
@endsection
