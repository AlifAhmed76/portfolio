<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Md. Alif Ahmed — Web Developer | Technical Project Lead')</title>
    <meta name="description" content="@yield('meta_description', 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Syne:wght@600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --font-display: 'Syne', system-ui, -apple-system, sans-serif;
            --font-body: 'Space Grotesk', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            --bg-noir: #09090b;
            --surface-noir: #121215;
            --border-stark: rgba(255, 255, 255, 0.14);
            --text-stark: #fafafa;
            --text-dim: #a1a1aa;
            --accent-crimson: #e11d48;
        }

        [data-bs-theme="light"] {
            --bg-noir: #fafafa;
            --surface-noir: #ffffff;
            --border-stark: rgba(0, 0, 0, 0.12);
            --text-stark: #09090b;
            --text-dim: #52525b;
            --accent-crimson: #be123c;
        }

        body {
            background-color: var(--bg-noir);
            color: var(--text-dim);
            font-family: var(--font-body);
            line-height: 1.6;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: var(--font-display);
            color: var(--text-stark);
            letter-spacing: -0.03em;
        }

        .brutalist-border {
            border: 1px solid var(--border-stark);
        }

        .brutalist-border-bottom {
            border-bottom: 1px solid var(--border-stark);
        }

        .brutalist-border-top {
            border-top: 1px solid var(--border-stark);
        }

        .case-number {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--border-stark);
            transition: color 0.3s ease;
            line-height: 1;
        }

        .editorial-card:hover .case-number {
            color: var(--accent-crimson);
        }

        .editorial-nav-link {
            font-family: var(--font-body);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--text-dim);
            text-decoration: none;
            padding: 8px 16px;
            transition: color 0.2s ease;
        }

        .editorial-nav-link:hover {
            color: var(--text-stark);
        }

        .badge-editorial {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            text-transform: uppercase;
            padding: 4px 10px;
            border: 1px solid var(--border-stark);
            color: var(--text-dim);
            background: transparent;
        }

        .btn-brutalist {
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-radius: 0;
            padding: 12px 28px;
            border: 1px solid var(--text-stark);
            color: var(--bg-noir);
            background: var(--text-stark);
            transition: all 0.2s ease;
        }

        .btn-brutalist:hover {
            background: transparent;
            color: var(--text-stark);
        }

        .btn-brutalist-outline {
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-radius: 0;
            padding: 12px 28px;
            border: 1px solid var(--border-stark);
            color: var(--text-stark);
            background: transparent;
            transition: all 0.2s ease;
        }

        .btn-brutalist-outline:hover {
            border-color: var(--text-stark);
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-stark);
        }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-2 px-3 small text-center mb-0 border-0 rounded-0 d-flex align-items-center justify-content-center gap-2">
            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
            <strong>Theme Preview Mode:</strong> Rendering with <code>Editorial Brutalist</code>. Live site remains unaffected.
            <a href="{{ url('/') }}" class="btn btn-xs btn-outline-dark ms-2">Exit Preview</a>
        </div>
    @endif

    <!-- Header Navigation Bar -->
    <header class="brutalist-border-bottom sticky-top" style="background: var(--bg-noir);">
        <div class="container-fluid px-4 py-3 d-flex justify-content-between align-items-center">
            <a href="{{ url('/') }}" class="text-decoration-none text-reset d-flex align-items-center gap-2">
                <span class="fw-bold font-display text-uppercase" style="letter-spacing: 0.05em; font-size: 1.1rem;">
                    ALIF AHMED
                </span>
                <span class="text-secondary small font-mono">/ LEAD ARCHITECT</span>
            </a>

            <nav class="d-none d-md-flex align-items-center gap-2">
                <a href="#projects" class="editorial-nav-link">Work</a>
                <a href="#services" class="editorial-nav-link">Services</a>
                <a href="#experience" class="editorial-nav-link">Experience</a>
                <a href="#expertise" class="editorial-nav-link">Competencies</a>
                <a href="#about" class="editorial-nav-link">About</a>
                <a href="#contact" class="editorial-nav-link">Contact</a>
            </nav>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ url('/admin/login') }}" class="btn-brutalist-outline py-1 px-3" style="font-size: 0.75rem;">
                    Admin
                </a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="brutalist-border-top py-5 mt-5">
        <div class="container px-4">
            <div class="row g-4 align-items-center justify-content-between">
                <div class="col-md-6">
                    <div class="font-display fw-bold text-uppercase h5 mb-1">Md. Alif Ahmed</div>
                    <p class="small text-secondary mb-0">Web Developer | Technical Project Lead | E-commerce Solutions Specialist</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="small text-secondary mb-0">
                        Inspired by Anton &amp; Irene and Tobias van Schneider. Engineered with Laravel 11.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
