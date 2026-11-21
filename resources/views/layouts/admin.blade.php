<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | {{ config('app.name') }}</title>
    
    <!-- Bootstrap 5.3 & Lucide Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        :root {
            --admin-accent: #10b981;
            --admin-accent-hover: #059669;
            --admin-sidebar-width: 270px;
            --admin-topbar-height: 64px;
        }

        [data-bs-theme="dark"] {
            --admin-bg: #090d16;
            --admin-sidebar-bg: #0f172a;
            --admin-card-bg: #131d33;
            --admin-border: #1e293b;
            --admin-text-muted: #94a3b8;
        }

        [data-bs-theme="light"] {
            --admin-bg: #f8fafc;
            --admin-sidebar-bg: #ffffff;
            --admin-card-bg: #ffffff;
            --admin-border: #e2e8f0;
            --admin-text-muted: #64748b;
        }

        body {
            background-color: var(--admin-bg);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .admin-sidebar {
            width: var(--admin-sidebar-width);
            background: var(--admin-sidebar-bg);
            border-right: 1px solid var(--admin-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            transition: transform 0.25s ease-in-out;
            overflow-y: auto;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
        }

        .admin-main {
            margin-left: var(--admin-sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        @media (max-width: 991.98px) {
            .admin-main {
                margin-left: 0;
            }
        }

        .admin-topbar {
            height: var(--admin-topbar-height);
            background: var(--admin-sidebar-bg);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: var(--admin-accent);
            text-decoration: none;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--admin-border);
        }

        .nav-section-header {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--admin-text-muted);
            padding: 1rem 1.5rem 0.35rem;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 1.5rem;
            color: inherit;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.15s ease;
        }

        .nav-link-item:hover {
            background: rgba(16, 185, 129, 0.08);
            color: var(--admin-accent);
        }

        .nav-link-item.active {
            color: var(--admin-accent);
            background: rgba(16, 185, 129, 0.12);
            border-left-color: var(--admin-accent);
        }

        .nav-link-item .badge-phase {
            font-size: 0.65rem;
            margin-left: auto;
            opacity: 0.7;
        }

        .admin-card {
            background: var(--admin-card-bg);
            border: 1px solid var(--admin-border);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .btn-emerald {
            background: var(--admin-accent);
            border-color: var(--admin-accent);
            color: #ffffff;
            font-weight: 600;
        }

        .btn-emerald:hover, .btn-emerald:focus {
            background: var(--admin-accent-hover);
            border-color: var(--admin-accent-hover);
            color: #ffffff;
        }

        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--admin-accent);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.85rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <a href="{{ route('admin.dashboard') }}" class="brand-badge">
                <i data-lucide="shield-check" class="text-success"></i>
                <span>ALIF AHMED <small class="text-secondary fw-normal">CMS</small></span>
            </a>

            <div class="py-2">
                <!-- Overview -->
                <div class="nav-section-header">Overview</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Content -->
                <div class="nav-section-header">Content</div>
                <a href="{{ Route::has('admin.identity.index') ? route('admin.identity.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.identity*') ? 'active' : '' }}">
                    <i data-lucide="user"></i>
                    <span>Identity & Profile</span>
                    @if (! Route::has('admin.identity.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 2</span>
                    @endif
                </a>
                <a href="{{ Route::has('admin.projects.index') ? route('admin.projects.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.projects*') ? 'active' : '' }}">
                    <i data-lucide="folder-git-2"></i>
                    <span>Projects & Cases</span>
                    @if (! Route::has('admin.projects.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 2</span>
                    @endif
                </a>
                <a href="{{ Route::has('admin.skills.index') ? route('admin.skills.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.skills*') ? 'active' : '' }}">
                    <i data-lucide="cpu"></i>
                    <span>Skills & Expertise</span>
                    @if (! Route::has('admin.skills.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 2</span>
                    @endif
                </a>
                <a href="{{ Route::has('admin.experience.index') ? route('admin.experience.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.experience*') ? 'active' : '' }}">
                    <i data-lucide="briefcase"></i>
                    <span>Experience & Edu</span>
                    @if (! Route::has('admin.experience.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 2</span>
                    @endif
                </a>
                <a href="{{ Route::has('admin.services.index') ? route('admin.services.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                    <i data-lucide="sparkles"></i>
                    <span>Services</span>
                    @if (! Route::has('admin.services.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 2</span>
                    @endif
                </a>
                <a href="{{ Route::has('admin.media.index') ? route('admin.media.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.media*') ? 'active' : '' }}">
                    <i data-lucide="images"></i>
                    <span>Media Library</span>
                    @if (! Route::has('admin.media.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 2</span>
                    @endif
                </a>
                <a href="{{ Route::has('admin.sections.index') ? route('admin.sections.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.sections*') ? 'active' : '' }}">
                    <i data-lucide="layers"></i>
                    <span>Homepage Sections</span>
                    @if (! Route::has('admin.sections.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 2</span>
                    @endif
                </a>

                <!-- Appearance -->
                <div class="nav-section-header">Appearance</div>
                <a href="{{ Route::has('admin.themes.index') ? route('admin.themes.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.themes*') ? 'active' : '' }}">
                    <i data-lucide="palette"></i>
                    <span>Theme Studio</span>
                    @if (! Route::has('admin.themes.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 3</span>
                    @endif
                </a>
                <a href="{{ Route::has('admin.code-editor.index') ? route('admin.code-editor.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.code-editor*') ? 'active' : '' }}">
                    <i data-lucide="code-2"></i>
                    <span>Trusted Code Editor</span>
                    @if (! Route::has('admin.code-editor.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 5</span>
                    @endif
                </a>

                <!-- Pages & Builder -->
                <div class="nav-section-header">Pages & Builder</div>
                <a href="{{ Route::has('admin.pages.index') ? route('admin.pages.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.pages*') ? 'active' : '' }}">
                    <i data-lucide="file-text"></i>
                    <span>Page Manager</span>
                    @if (! Route::has('admin.pages.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 4</span>
                    @endif
                </a>

                <!-- Inbox & Blog -->
                <div class="nav-section-header">Inbox & Articles</div>
                <a href="{{ Route::has('admin.posts.index') ? route('admin.posts.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.posts*') ? 'active' : '' }}">
                    <i data-lucide="newspaper"></i>
                    <span>Blog Posts</span>
                    @if (! Route::has('admin.posts.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 7</span>
                    @endif
                </a>
                <a href="{{ Route::has('admin.contacts.index') ? route('admin.contacts.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
                    <i data-lucide="mail"></i>
                    <span>Contact Inbox</span>
                    @if (! Route::has('admin.contacts.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 7</span>
                    @endif
                </a>

                <!-- System -->
                <div class="nav-section-header">System</div>
                <a href="{{ Route::has('admin.seo.index') ? route('admin.seo.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.seo*') ? 'active' : '' }}">
                    <i data-lucide="search"></i>
                    <span>SEO & Analytics</span>
                    @if (! Route::has('admin.seo.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 7</span>
                    @endif
                </a>
                <a href="{{ Route::has('admin.settings.index') ? route('admin.settings.index') : '#' }}" class="nav-link-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <i data-lucide="settings"></i>
                    <span>Settings & Backup</span>
                    @if (! Route::has('admin.settings.index'))
                        <span class="badge bg-secondary-subtle text-secondary badge-phase">Phase 8</span>
                    @endif
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="admin-main">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-outline-secondary d-lg-none" type="button" id="sidebarToggle" aria-label="Toggle navigation">
                        <i data-lucide="menu"></i>
                    </button>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                        <i data-lucide="database" class="me-1" style="width: 14px; height: 14px;"></i>
                        {{ \App\Services\WorkspaceResolver::resolve()?->name ?? 'Single Workspace' }}
                    </span>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-secondary d-none d-sm-inline-flex align-items-center gap-1">
                        <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
                        <span>View Portfolio</span>
                    </a>

                    <!-- Theme Toggle -->
                    <button class="btn btn-sm btn-outline-secondary" id="themeToggle" type="button" title="Toggle Dark/Light Mode">
                        <i data-lucide="sun" id="themeIconSun" class="d-none"></i>
                        <i data-lucide="moon" id="themeIconMoon"></i>
                    </button>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-link text-decoration-none p-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar-circle">
                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline small fw-semibold text-body">
                                {{ auth()->user()->name ?? 'Owner' }}
                            </span>
                            <i data-lucide="chevron-down" style="width: 16px; height: 16px;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-secondary-subtle">
                            <li class="dropdown-header">
                                <small class="text-muted">Signed in as</small><br>
                                <strong>{{ auth()->user()->email ?? 'admin' }}</strong>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i data-lucide="log-out" style="width: 16px; height: 16px;"></i>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-3 p-md-4 flex-grow-1">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                        <i data-lucide="check-circle" class="text-success"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                        <i data-lucide="alert-triangle" class="text-danger"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i data-lucide="alert-circle" class="text-danger"></i>
                            <strong>Please correct the following errors:</strong>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Admin Footer -->
            <footer class="p-3 px-md-4 border-top text-muted small d-flex flex-wrap justify-content-between align-items-center">
                <span>Alif Ahmed Portfolio CMS • Phase 1 Foundation</span>
                <span>Laravel v{{ app()->version() }} • PHP v{{ PHP_VERSION }}</span>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Theme Toggle Persistence
        const themeToggle = document.getElementById('themeToggle');
        const sunIcon = document.getElementById('themeIconSun');
        const moonIcon = document.getElementById('themeIconMoon');

        function setTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('admin_theme', theme);
            if (theme === 'light') {
                sunIcon.classList.remove('d-none');
                moonIcon.classList.add('d-none');
            } else {
                sunIcon.classList.add('d-none');
                moonIcon.classList.remove('d-none');
            }
        }

        const savedTheme = localStorage.getItem('admin_theme') || 'dark';
        setTheme(savedTheme);

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-bs-theme');
                setTheme(current === 'dark' ? 'light' : 'dark');
            });
        }

        // Mobile Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('adminSidebar');
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
