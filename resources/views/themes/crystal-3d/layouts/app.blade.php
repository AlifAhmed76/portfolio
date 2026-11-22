<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Md. Alif Ahmed — Web Developer | Technical Project Lead')</title>
    <meta name="description" content="@yield('meta_description', 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-body: 'Inter', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            --theme-accent: #10b981;
            --theme-accent-hover: #059669;
            --theme-accent-rgb: 16, 185, 129;
            --theme-accent-glow: rgba(16, 185, 129, 0.35);
            
            --theme-bg: #070a14;
            --theme-bg-gradient: radial-gradient(circle at 50% 0%, rgba(16, 185, 129, 0.12) 0%, rgba(7, 10, 20, 1) 75%);
            --theme-surface: rgba(15, 23, 42, 0.75);
            --theme-surface-solid: #0f172a;
            --theme-border: rgba(255, 255, 255, 0.10);
            --theme-border-highlight: rgba(16, 185, 129, 0.4);
            --glass-blur: 24px;
            --card-shadow: 0 16px 40px -10px rgba(0, 0, 0, 0.6), inset 0 1px 0 0 rgba(255, 255, 255, 0.15);
        }

        [data-bs-theme="light"] {
            --theme-accent: #059669;
            --theme-accent-hover: #047857;
            --theme-accent-rgb: 5, 150, 105;
            --theme-accent-glow: rgba(5, 150, 105, 0.2);
            
            --theme-bg: #f8fafc;
            --theme-bg-gradient: radial-gradient(circle at 50% 0%, rgba(5, 150, 105, 0.08) 0%, rgba(248, 250, 252, 1) 75%);
            --theme-surface: rgba(255, 255, 255, 0.90);
            --theme-surface-solid: #ffffff;
            --theme-border: rgba(0, 0, 0, 0.08);
            --theme-border-highlight: rgba(5, 150, 105, 0.4);
            --glass-blur: 24px;
            --card-shadow: 0 12px 32px -8px rgba(0, 0, 0, 0.08), inset 0 1px 0 0 rgba(255, 255, 255, 0.9);
        }

        body {
            background-color: var(--theme-bg);
            background-image: var(--theme-bg-gradient);
            background-attachment: fixed;
            color: var(--bs-body-color);
            font-family: var(--font-body);
            min-height: 100vh;
            line-height: 1.65;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: var(--font-heading);
            letter-spacing: -0.02em;
        }

        .crystal-surface {
            background: var(--theme-surface);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: 1px solid var(--theme-border);
            border-radius: 1.25rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .crystal-card-3d {
            background: var(--theme-surface);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: 1px solid var(--theme-border);
            border-radius: 1.25rem;
            box-shadow: var(--card-shadow);
            transform-style: preserve-3d;
            perspective: 1200px;
            transition: transform 0.25s ease-out, box-shadow 0.25s ease-out, border-color 0.25s ease-out;
            position: relative;
            overflow: hidden;
        }

        .crystal-card-3d:hover {
            border-color: var(--theme-border-highlight);
            box-shadow: 0 24px 50px -12px rgba(0, 0, 0, 0.7), inset 0 1px 0 0 rgba(255, 255, 255, 0.3), 0 0 28px var(--theme-accent-glow);
        }

        /* 3D Floating elements */
        .layer-depth-1 { transform: translateZ(20px); }
        .layer-depth-2 { transform: translateZ(40px); }
        .layer-depth-3 { transform: translateZ(60px); }

        .text-emerald { color: var(--theme-accent) !important; }
        .bg-emerald { background-color: var(--theme-accent) !important; }
        
        .badge-crystal {
            background: rgba(var(--theme-accent-rgb), 0.15);
            color: var(--theme-accent);
            border: 1px solid rgba(var(--theme-accent-rgb), 0.35);
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 0.02em;
            padding: 0.45rem 1rem;
            box-shadow: 0 0 15px rgba(var(--theme-accent-rgb), 0.2);
        }

        .btn-emerald {
            background: var(--theme-accent);
            border-color: var(--theme-accent);
            color: #ffffff;
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
            box-shadow: 0 6px 18px 0 rgba(var(--theme-accent-rgb), 0.4);
            transition: all 0.2s ease;
        }
        .btn-emerald:hover {
            background: var(--theme-accent-hover);
            border-color: var(--theme-accent-hover);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px 0 rgba(var(--theme-accent-rgb), 0.55);
        }

        .btn-crystal-outline {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--theme-border-highlight);
            color: var(--bs-body-color);
            font-weight: 600;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
            backdrop-filter: blur(10px);
            transition: all 0.2s ease;
        }
        .btn-crystal-outline:hover {
            background: rgba(var(--theme-accent-rgb), 0.12);
            border-color: var(--theme-accent);
            color: var(--theme-accent);
            transform: translateY(-2px);
        }

        .beacon-dot {
            width: 9px;
            height: 9px;
            background-color: var(--theme-accent);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(var(--theme-accent-rgb), 0.7);
            animation: beacon 2s infinite cubic-bezier(0.66, 0, 0, 1);
        }
        @keyframes beacon {
            to {
                box-shadow: 0 0 0 10px rgba(var(--theme-accent-rgb), 0);
            }
        }

        .timeline-node {
            position: relative;
            padding-left: 2rem;
            border-left: 2px solid rgba(var(--theme-accent-rgb), 0.35);
        }
        .timeline-node::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--theme-accent);
            box-shadow: 0 0 12px var(--theme-accent);
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(var(--theme-accent-rgb), 0.14);
            color: var(--theme-accent);
            border: 1px solid rgba(var(--theme-accent-rgb), 0.28);
            box-shadow: 0 4px 15px rgba(var(--theme-accent-rgb), 0.15);
        }

        /* 3D Orb / Prism Animation */
        .prism-orb {
            position: relative;
            width: 160px;
            height: 160px;
            margin: 0 auto;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(16, 185, 129, 0.4), rgba(15, 23, 42, 0.9));
            box-shadow: 0 0 40px rgba(16, 185, 129, 0.3), inset 0 0 20px rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(16, 185, 129, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            animation: floatOrb 6s ease-in-out infinite;
        }

        @keyframes floatOrb {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }

        .avatar-glow-ring {
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px dashed rgba(16, 185, 129, 0.4);
            animation: spinRing 20s linear infinite;
        }

        @keyframes spinRing {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .project-preview-mockup {
            height: 190px;
            border-radius: 0.85rem;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
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

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top crystal-surface mx-3 mt-3 px-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-emerald d-flex align-items-center gap-2" href="{{ url('/') }}">
                <div class="icon-box" style="width: 36px; height: 36px; border-radius: 10px;">
                    <i data-lucide="terminal" style="width: 18px; height: 18px;"></i>
                </div>
                <span>ALIF AHMED</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-2 align-items-center">
                    <li class="nav-item"><a class="nav-link px-2" href="#hero">Overview</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#expertise">Skills</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#projects">Projects</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#experience">Timeline</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#process">Process</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#blog">Insights</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#contact">Contact</a></li>
                    <li class="nav-item ms-lg-2">
                        <button class="btn btn-sm btn-crystal-outline p-1 px-2" id="themeToggleBtn" type="button" title="Toggle Dark/Light">
                            <i data-lucide="moon" id="publicThemeIcon" style="width: 18px; height: 18px;"></i>
                        </button>
                    </li>
                    <li class="nav-item ms-lg-1">
                        <a href="{{ url('/admin/login') }}" class="btn btn-sm btn-emerald py-1 px-3" style="font-size: 0.85rem;">
                            Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="container py-5 text-center text-secondary small border-top border-secondary-subtle mt-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-3">
            <div class="text-start">
                <p class="fw-bold mb-0 text-body">Md. Alif Ahmed</p>
                <p class="text-muted small mb-0">Web Developer | Technical Project Lead | E-commerce Solutions Specialist</p>
            </div>
            <div class="d-flex gap-3">
                <a href="#hero" class="text-secondary text-decoration-none">Back to Top ↑</a>
                <a href="{{ url('/projects') }}" class="text-secondary text-decoration-none">Projects</a>
                <a href="{{ url('/blog') }}" class="text-secondary text-decoration-none">Blog</a>
                <a href="{{ url('/sitemap.xml') }}" class="text-secondary text-decoration-none">Sitemap</a>
            </div>
        </div>
        <hr class="opacity-10 my-3">
        <p class="mb-1">© {{ date('Y') }} Md. Alif Ahmed. All rights reserved.</p>
        <p class="mb-0 text-muted">Theme: <strong>Crystal 3D</strong> • High-Performance Laravel 11 CMS</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Icons
        lucide.createIcons();

        // Zero-Flash Theme Switcher
        const toggleBtn = document.getElementById('themeToggleBtn');
        const icon = document.getElementById('publicThemeIcon');
        const savedTheme = localStorage.getItem('site_theme') || 'dark';
        
        function applyTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            if (icon) {
                icon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon');
                lucide.createIcons();
            }
        }
        applyTheme(savedTheme);

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-bs-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                localStorage.setItem('site_theme', next);
                applyTheme(next);
            });
        }

        // 3D Card Depth Tilt Effect
        document.querySelectorAll('.crystal-card-3d').forEach(card => {
            card.addEventListener('mousemove', e => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                const rotateX = (-y / rect.height) * 10;
                const rotateY = (x / rect.width) * 10;
                card.style.transform = `perspective(1200px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-6px)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1200px) rotateX(0deg) rotateY(0deg) translateY(0)';
            });
        });
    </script>
</body>
</html>
