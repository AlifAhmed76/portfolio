<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Alif Ahmed — Portfolio')</title>
    <meta name="description" content="@yield('meta_description', 'Web Developer, Technical Project Lead & E-commerce Solutions Specialist.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --theme-accent: #10b981;
            --theme-accent-rgb: 16, 185, 129;
            --theme-bg: #070a12;
            --theme-surface: rgba(15, 23, 42, 0.75);
            --theme-border: rgba(255, 255, 255, 0.08);
            --glass-blur: 16px;
        }
        [data-bs-theme="light"] {
            --theme-bg: #f8fafc;
            --theme-surface: rgba(255, 255, 255, 0.85);
            --theme-border: rgba(0, 0, 0, 0.08);
        }
        body {
            background-color: var(--theme-bg);
            color: var(--bs-body-color);
            font-family: system-ui, -apple-system, sans-serif;
            min-height: 100vh;
        }
        .crystal-surface {
            background: var(--theme-surface);
            backdrop-filter: blur(var(--glass-blur));
            border: 1px solid var(--theme-border);
            border-radius: 1rem;
        }
        .text-emerald { color: var(--theme-accent) !important; }
        .bg-emerald { background-color: var(--theme-accent) !important; }
        .btn-emerald {
            background: var(--theme-accent);
            border-color: var(--theme-accent);
            color: #fff;
            font-weight: 600;
        }
        .btn-emerald:hover {
            background: #059669;
            border-color: #059669;
            color: #fff;
        }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-2 px-3 small text-center mb-0 border-0 rounded-0 d-flex align-items-center justify-content-center gap-2">
            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
            <strong>Theme Preview Mode:</strong> Rendering with theme <code>{{ \App\Services\ThemeResolver::resolve()->name }}</code>. Live site remains unaffected.
            <a href="{{ url('/') }}" class="btn btn-xs btn-outline-dark ms-2">Exit Preview</a>
        </div>
    @endif

    <nav class="navbar navbar-expand-lg sticky-top crystal-surface mx-3 mt-3 px-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-emerald" href="{{ url('/') }}">
                ALIF AHMED
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-3 align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#expertise') }}">Expertise</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/projects') }}">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#services') }}">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">Contact</a></li>
                    <li class="nav-item">
                        <button class="btn btn-sm btn-outline-secondary p-1 px-2" id="themeToggleBtn" type="button" title="Toggle Dark/Light">
                            <i data-lucide="moon" id="publicThemeIcon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="container py-4 text-center text-secondary small border-top border-secondary-subtle mt-5">
        <p class="mb-1">© {{ date('Y') }} Md. Alif Ahmed. All rights reserved.</p>
        <p class="mb-0 text-muted">Theme: Crystal 3D • Powered by Alif Ahmed Portfolio CMS</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
        const toggleBtn = document.getElementById('themeToggleBtn');
        const icon = document.getElementById('publicThemeIcon');
        const saved = localStorage.getItem('site_theme') || 'dark';
        document.documentElement.setAttribute('data-bs-theme', saved);
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-bs-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', next);
                localStorage.setItem('site_theme', next);
            });
        }
    </script>
    @stack('scripts')
</body>
</html>

