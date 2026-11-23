<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Md. Alif Ahmed — Web Developer & Technical Project Lead')</title>
    <meta name="description" content="@yield('meta_description', 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --font-serif: 'Fraunces', Georgia, serif;
            --font-sans: 'Inter', system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            --nordic-bg: #f8f6f0;
            --nordic-surface: #ffffff;
            --nordic-text: #1c1917;
            --nordic-muted: #78716c;
            --nordic-border: #e7e5e4;
        }

        [data-bs-theme="dark"] {
            --nordic-bg: #141312;
            --nordic-surface: #1c1a18;
            --nordic-text: #f5f5f4;
            --nordic-muted: #a8a29e;
            --nordic-border: #292524;
        }

        body {
            background-color: var(--nordic-bg);
            color: var(--nordic-text);
            font-family: var(--font-sans);
            line-height: 1.7;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6, .font-serif {
            font-family: var(--font-serif);
            font-weight: 600;
            letter-spacing: -0.02em;
        }

        .nordic-nav {
            max-width: 860px;
            margin: 20px auto 0;
            background: var(--nordic-surface);
            border: 1px solid var(--nordic-border);
            border-radius: 9999px;
            padding: 8px 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        }

        .nordic-nav .nav-link {
            font-size: 0.88rem;
            color: var(--nordic-muted);
            padding: 6px 14px !important;
            transition: color 0.2s ease;
        }

        .nordic-nav .nav-link:hover {
            color: var(--nordic-text);
        }

        .nordic-card {
            background: var(--nordic-surface);
            border: 1px solid var(--nordic-border);
            border-radius: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .nordic-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.06);
        }

        .badge-nordic {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 4px 10px;
            background: rgba(0, 0, 0, 0.04);
            color: var(--nordic-muted);
            border: 1px solid var(--nordic-border);
            border-radius: 4px;
        }

        .btn-nordic {
            background: var(--nordic-text);
            color: var(--nordic-bg);
            border-radius: 9999px;
            padding: 10px 24px;
            font-size: 0.88rem;
            font-weight: 500;
            border: 1px solid var(--nordic-text);
            transition: all 0.2s ease;
        }

        .btn-nordic:hover {
            background: transparent;
            color: var(--nordic-text);
        }

        .btn-nordic-outline {
            background: transparent;
            color: var(--nordic-text);
            border-radius: 9999px;
            padding: 10px 24px;
            font-size: 0.88rem;
            font-weight: 500;
            border: 1px solid var(--nordic-border);
            transition: all 0.2s ease;
        }

        .btn-nordic-outline:hover {
            border-color: var(--nordic-text);
        }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-2 px-3 small text-center mb-0 border-0 rounded-0 d-flex align-items-center justify-content-center gap-2">
            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
            <strong>Theme Preview Mode:</strong> Rendering with <code>Nordic Minimal</code>. Live site remains unaffected.
            <a href="{{ url('/') }}" class="btn btn-xs btn-outline-dark ms-2">Exit Preview</a>
        </div>
    @endif

    <header class="sticky-top px-3 z-3">
        <nav class="navbar navbar-expand-lg nordic-nav">
            <div class="container-fluid px-0">
                <a class="navbar-brand font-serif fw-bold text-dark d-flex align-items-center gap-2" href="{{ isset($currentWorkspace) && $currentWorkspace->slug !== 'default' ? url('/u/' . $currentWorkspace->slug) : url('/') }}" style="color: var(--nordic-text) !important;">
                    <span>{{ $profile->name ?? 'Portfolio Builder' }}</span>
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                    <i data-lucide="menu" style="width: 22px; height: 22px;"></i>
                </button>

                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1 align-items-center">
                        <li class="nav-item"><a class="nav-link" href="#projects">Work</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#experience">Experience</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ url('/admin/login') }}" class="btn btn-sm btn-nordic py-1 px-3">
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

    <footer class="py-5 text-center small text-secondary border-top mt-5" style="border-color: var(--nordic-border) !important;">
        <div class="container">
            <p class="font-serif fw-bold h6 mb-1" style="color: var(--nordic-text);">{{ $profile->name ?? 'Portfolio Builder' }}</p>
            <p class="mb-3 text-muted">Web Developer | Technical Project Lead | E-commerce Solutions Specialist</p>
            <p class="mb-0 text-muted">Theme: <strong>Nordic Minimal</strong> • Inspired by Tobias van Schneider</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
