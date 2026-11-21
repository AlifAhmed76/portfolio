<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Md. Alif Ahmed — Web Developer & Technical Project Lead')</title>
    <meta name="description" content="@yield('meta_description', 'Md. Alif Ahmed — Web Developer | Technical Project Lead | E-commerce Solutions Specialist. Custom Laravel engineering, high-performance APIs, and conversion-focused architectures.')">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --theme-accent: #10b981;
            --theme-accent-rgb: 16, 185, 129;
            --theme-bg: #070a12;
            --theme-surface: rgba(15, 23, 42, 0.72);
            --theme-surface-hover: rgba(30, 41, 59, 0.85);
            --theme-border: rgba(255, 255, 255, 0.08);
            --theme-border-glow: rgba(16, 185, 129, 0.35);
            --glass-blur: 16px;
            --font-heading: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-body: 'Inter', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        [data-bs-theme="light"] {
            --theme-bg: #f8fafc;
            --theme-surface: rgba(255, 255, 255, 0.88);
            --theme-surface-hover: #ffffff;
            --theme-border: rgba(0, 0, 0, 0.08);
            --theme-border-glow: rgba(5, 150, 105, 0.35);
        }

        body {
            background-color: var(--theme-bg);
            color: var(--bs-body-color);
            font-family: var(--font-body);
            min-height: 100vh;
            overflow-x: hidden;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: var(--font-heading);
            letter-spacing: -0.02em;
        }

        .crystal-surface {
            background: var(--theme-surface);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: 1px solid var(--theme-border);
            border-radius: 1rem;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .crystal-surface:hover {
            border-color: var(--theme-border-glow);
        }

        .crystal-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px -10px rgba(0, 0, 0, 0.3), 0 0 20px -5px rgba(16, 185, 129, 0.15);
        }

        .text-emerald { color: var(--theme-accent) !important; }
        .bg-emerald { background-color: var(--theme-accent) !important; }
        
        .btn-emerald {
            background: var(--theme-accent);
            border-color: var(--theme-accent);
            color: #fff;
            font-weight: 600;
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        .btn-emerald:hover {
            background: #059669;
            border-color: #059669;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
        }

        .btn-outline-emerald {
            border-color: var(--theme-border);
            color: var(--bs-body-color);
            background: rgba(255, 255, 255, 0.02);
            font-weight: 600;
            padding: 0.65rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        .btn-outline-emerald:hover {
            border-color: var(--theme-accent);
            color: var(--theme-accent);
            background: rgba(16, 185, 129, 0.08);
            transform: translateY(-1px);
        }

        /* 3D Crystal Prism Canvas / Layer */
        .crystal-hero-wrapper {
            perspective: 1000px;
        }
        .crystal-hero-card {
            transform-style: preserve-3d;
            transition: transform 0.2s ease-out;
            position: relative;
            overflow: hidden;
        }
        .crystal-hero-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.08), transparent 60%);
            pointer-events: none;
            z-index: 0;
        }

        .nav-link {
            font-weight: 500;
            color: var(--bs-secondary-color);
            transition: color 0.15s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--theme-accent) !important;
        }

        .section-tag {
            font-family: var(--font-mono);
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--theme-accent);
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        @media (prefers-reduced-motion: reduce) {
            .crystal-surface, .crystal-hero-card, .btn-emerald {
                transition: none !important;
                transform: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-2 px-3 small text-center mb-0 border-0 rounded-0 d-flex align-items-center justify-content-center gap-2 sticky-top" style="z-index: 1050;">
            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
            <strong>Theme Preview Mode:</strong> Rendering with theme <code>{{ \App\Services\ThemeResolver::resolve()->name }}</code>. Live site remains unaffected.
            <a href="{{ url('/') }}" class="btn btn-xs btn-outline-dark ms-2 py-0 px-2" style="font-size: 11px;">Exit Preview</a>
        </div>
    @endif

    <!-- 1. Header & Navigation -->
    <header class="sticky-top mx-3 mt-3 px-1" style="z-index: 1030;">
        <nav class="navbar navbar-expand-lg crystal-surface px-3 py-2">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold text-emerald d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <span class="d-inline-block rounded-circle bg-emerald" style="width: 10px; height: 10px;"></span>
                    <span class="tracking-tight">ALIF AHMED</span>
                </a>
                
                <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i data-lucide="menu"></i>
                </button>

                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-3 align-items-center">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#expertise') }}">Expertise</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#projects') }}">Projects</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#services') }}">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#experience') }}">Experience</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#process') }}">Process</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/#contact') }}">Contact</a></li>
                        <li class="nav-item ms-lg-2">
                            <button class="btn btn-sm btn-outline-secondary p-1 px-2 rounded-3" id="themeToggleBtn" type="button" title="Toggle Dark/Light Mode">
                                <i data-lucide="moon" id="publicThemeIcon" style="width: 16px; height: 16px;"></i>
                            </button>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a href="{{ url('/#contact') }}" class="btn btn-sm btn-emerald py-1 px-3 d-none d-lg-inline-block">
                                Hire / Connect
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="container py-5 text-center text-secondary small border-top mt-5" style="border-color: var(--theme-border) !important;">
        <div class="row align-items-center justify-content-between g-3">
            <div class="col-md-4 text-md-start">
                <span class="fw-bold text-light">Md. Alif Ahmed</span>
                <p class="mb-0 text-secondary" style="font-size: 12px;">Web Developer | Technical Project Lead | E-commerce Solutions Specialist</p>
            </div>
            <div class="col-md-4 text-center">
                <p class="mb-0">© {{ date('Y') }} All Rights Reserved. Production-Grade Portfolio Architecture.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                    Theme: {{ \App\Services\ThemeResolver::resolve()->name }}
                </span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Init Lucide icons
        if (window.lucide) {
            lucide.createIcons();
        }

        // Theme Toggle with Zero-Flash LocalStorage Persistence
        const toggleBtn = document.getElementById('themeToggleBtn');
        const icon = document.getElementById('publicThemeIcon');

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('site_theme', theme);
            if (icon) {
                icon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon');
                if (window.lucide) lucide.createIcons();
            }
        }

        const savedTheme = localStorage.getItem('site_theme') || 
            (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
        applyTheme(savedTheme);

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-bs-theme') || 'dark';
                applyTheme(current === 'dark' ? 'light' : 'dark');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
