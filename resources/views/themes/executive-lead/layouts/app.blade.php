<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Md. Alif Ahmed — Web Developer | Technical Project Lead')</title>
    <meta name="description" content="@yield('meta_description', 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', system-ui, sans-serif;
            --font-body: 'Inter', system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            --exec-navy: #0a192f;
            --exec-surface: #112240;
            --exec-gold: #f59e0b;
            --exec-gold-dark: #d97706;
            --exec-text: #ccd6f6;
            --exec-muted: #8892b0;
            --exec-border: rgba(245, 158, 11, 0.2);
        }

        body {
            background-color: var(--exec-navy);
            color: var(--exec-muted);
            font-family: var(--font-body);
            line-height: 1.65;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .exec-card {
            background: var(--exec-surface);
            border: 1px solid var(--exec-border);
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .exec-card:hover {
            border-color: rgba(245, 158, 11, 0.45);
            transform: translateY(-4px);
            box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.5);
        }

        .exec-nav {
            max-width: 960px;
            margin: 18px auto 0;
            background: rgba(17, 34, 64, 0.9);
            backdrop-filter: blur(24px);
            border: 1px solid var(--exec-border);
            border-radius: 9999px;
            padding: 8px 24px;
        }

        .exec-nav .nav-link {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--exec-text);
            padding: 6px 14px !important;
            border-radius: 9999px;
            transition: all 0.2s ease;
        }

        .exec-nav .nav-link:hover {
            color: var(--exec-gold);
            background: rgba(245, 158, 11, 0.1);
        }

        .badge-gold {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 9999px;
            background: rgba(245, 158, 11, 0.12);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
            display: inline-block;
        }

        .btn-gold {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #0a192f;
            border: none;
            border-radius: 9999px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            transition: all 0.2s ease;
        }

        .btn-gold:hover {
            background: linear-gradient(135deg, #fbbf24 0%, #b45309 100%);
            color: #0a192f;
            transform: translateY(-2px);
        }

        .btn-gold-outline {
            background: transparent;
            color: var(--exec-gold);
            border: 1px solid rgba(245, 158, 11, 0.4);
            border-radius: 9999px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-gold-outline:hover {
            background: rgba(245, 158, 11, 0.15);
            color: #ffffff;
        }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-2 px-3 small text-center mb-0 border-0 rounded-0 d-flex align-items-center justify-content-center gap-2">
            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
            <strong>Theme Preview Mode:</strong> Rendering with <code>Executive Lead</code>. Live site remains unaffected.
            <a href="{{ url('/') }}" class="btn btn-xs btn-outline-dark ms-2">Exit Preview</a>
        </div>
    @endif

    <header class="sticky-top px-3 z-3">
        <nav class="navbar navbar-expand-lg exec-nav">
            <div class="container-fluid px-0">
                <a class="navbar-brand fw-bold text-warning d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <div class="rounded-circle p-1" style="background: rgba(245, 158, 11, 0.2);">
                        <i data-lucide="shield" style="width: 16px; height: 16px;" class="text-warning"></i>
                    </div>
                    <span>ALIF AHMED</span>
                </a>

                <button class="navbar-toggler border-0 shadow-none text-light" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                    <i data-lucide="menu" style="width: 22px; height: 22px;"></i>
                </button>

                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1 align-items-center">
                        <li class="nav-item"><a class="nav-link" href="#projects">Work</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#expertise">Stack</a></li>
                        <li class="nav-item"><a class="nav-link" href="#experience">Experience</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ url('/admin/login') }}" class="btn btn-sm btn-gold px-3 py-1">
                            Admin
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="position-relative z-2">
        @yield('content')
    </main>

    <footer class="py-5 text-center text-secondary small border-top border-secondary-subtle mt-5">
        <div class="container">
            <p class="mb-1 text-light fw-bold">Md. Alif Ahmed</p>
            <p class="mb-3 text-secondary">Web Developer | Technical Project Lead | E-commerce Solutions Specialist</p>
            <p class="mb-0 text-muted">Theme: <strong>Executive Lead</strong> • Enterprise Architecture &amp; Delivery Management</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
