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

            --craft-pink: #ec4899;
            --craft-purple: #8b5cf6;
            --craft-blue: #3b82f6;
            --craft-gradient: linear-gradient(135deg, #ec4899 0%, #8b5cf6 50%, #3b82f6 100%);
            --craft-bg: #0f111a;
            --craft-surface: #171926;
            --craft-text: #cbd5e1;
        }

        body {
            background-color: var(--craft-bg);
            color: var(--craft-text);
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

        .craft-gradient-text {
            background: var(--craft-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .craft-card {
            background: var(--craft-surface);
            border-radius: 1.25rem;
            position: relative;
            padding: 2px;
            background-clip: padding-box;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .craft-card:hover {
            border-color: rgba(236, 72, 153, 0.4);
            transform: translateY(-4px);
            box-shadow: 0 16px 36px -10px rgba(236, 72, 153, 0.2);
        }

        .craft-nav {
            max-width: 960px;
            margin: 18px auto 0;
            background: rgba(23, 25, 38, 0.85);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 9999px;
            padding: 8px 24px;
        }

        .craft-nav .nav-link {
            font-size: 0.9rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.75);
            padding: 6px 14px !important;
            border-radius: 9999px;
            transition: all 0.2s ease;
        }

        .craft-nav .nav-link:hover {
            color: #ffffff;
            background: rgba(236, 72, 153, 0.18);
        }

        .craft-chip {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 9999px;
            background: rgba(236, 72, 153, 0.12);
            color: #f472b6;
            border: 1px solid rgba(236, 72, 153, 0.25);
            display: inline-block;
        }

        .btn-craft {
            background: var(--craft-gradient);
            color: #ffffff;
            border: none;
            border-radius: 9999px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.35);
            transition: all 0.2s ease;
        }

        .btn-craft:hover {
            opacity: 0.95;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(236, 72, 153, 0.5);
        }

        .btn-craft-outline {
            background: transparent;
            color: #f472b6;
            border: 1px solid rgba(236, 72, 153, 0.4);
            border-radius: 9999px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-craft-outline:hover {
            background: rgba(236, 72, 153, 0.15);
            color: #ffffff;
        }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-2 px-3 small text-center mb-0 border-0 rounded-0 d-flex align-items-center justify-content-center gap-2">
            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
            <strong>Theme Preview Mode:</strong> Rendering with <code>Craft & Playful</code>. Live site remains unaffected.
            <a href="{{ url('/') }}" class="btn btn-xs btn-outline-dark ms-2">Exit Preview</a>
        </div>
    @endif

    <header class="sticky-top px-3 z-3">
        <nav class="navbar navbar-expand-lg craft-nav">
            <div class="container-fluid px-0">
                <a class="navbar-brand fw-bold craft-gradient-text d-flex align-items-center gap-2" href="{{ isset($currentWorkspace) && $currentWorkspace->slug !== 'default' ? url('/u/' . $currentWorkspace->slug) : url('/') }}">
                    <div class="rounded-circle p-1" style="background: rgba(236, 72, 153, 0.2);">
                        <i data-lucide="code" style="width: 16px; height: 16px;" class="text-pink"></i>
                    </div>
                    <span>{{ $profile->name ?? 'Portfolio Builder' }}</span>
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
                        <a href="{{ url('/admin/login') }}" class="btn btn-sm btn-craft px-3 py-1">
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
            <p class="mb-1 text-light fw-bold">{{ $profile->name ?? 'Portfolio Builder' }}</p>
            <p class="mb-3 text-secondary">Web Developer | Technical Project Lead | E-commerce Solutions Specialist</p>
            <p class="mb-0 text-muted">Theme: <strong>Craft &amp; Playful</strong> • Inspired by Josh W. Comeau &amp; Lynn Fisher</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
