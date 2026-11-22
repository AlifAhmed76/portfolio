<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Md. Alif Ahmed — Web Developer | Technical Project Lead')</title>
    <meta name="description" content="@yield('meta_description', 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', system-ui, sans-serif;
            --font-body: 'Inter', system-ui, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;

            --theme-accent: #8b5cf6;
            --theme-accent-hover: #7c3aed;
            --theme-accent-glow: rgba(139, 92, 246, 0.35);
            --theme-bg: #0d0c1d;
            --theme-bg-gradient: radial-gradient(circle at 50% 0%, rgba(139, 92, 246, 0.18) 0%, rgba(13, 12, 29, 1) 75%);
            --theme-surface: rgba(23, 21, 48, 0.75);
            --theme-border: rgba(139, 92, 246, 0.2);
            --card-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.7), inset 0 1px 0 0 rgba(255, 255, 255, 0.15);
        }

        body {
            background-color: var(--theme-bg);
            background-image: var(--theme-bg-gradient);
            background-attachment: fixed;
            color: #cbd5e1;
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

        .animattor-pill-nav {
            max-width: 960px;
            margin: 18px auto 0;
            background: var(--theme-surface);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border: 1px solid var(--theme-border);
            border-radius: 9999px;
            padding: 8px 24px;
            box-shadow: 0 12px 36px -10px rgba(0, 0, 0, 0.6);
        }

        .animattor-pill-nav .nav-link {
            font-size: 0.9rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.75);
            padding: 6px 14px !important;
            border-radius: 9999px;
            transition: all 0.2s ease;
        }

        .animattor-pill-nav .nav-link:hover {
            color: #ffffff;
            background: rgba(139, 92, 246, 0.2);
        }

        .animattor-card {
            background: var(--theme-surface);
            backdrop-filter: blur(20px);
            border: 1px solid var(--theme-border);
            border-radius: 1.25rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .animattor-card:hover {
            border-color: rgba(139, 92, 246, 0.5);
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.25);
        }

        .text-violet-glow {
            color: #a78bfa;
            text-shadow: 0 0 20px rgba(139, 92, 246, 0.4);
        }

        .badge-violet {
            font-family: var(--font-mono);
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 9999px;
            background: rgba(139, 92, 246, 0.15);
            color: #c4b5fd;
            border: 1px solid rgba(139, 92, 246, 0.35);
        }

        .btn-violet {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
            color: #ffffff;
            border: none;
            border-radius: 9999px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
            transition: all 0.2s ease;
        }

        .btn-violet:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.6);
        }

        .btn-violet-outline {
            background: transparent;
            color: #c4b5fd;
            border: 1px solid rgba(139, 92, 246, 0.4);
            border-radius: 9999px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-violet-outline:hover {
            background: rgba(139, 92, 246, 0.15);
            border-color: #8b5cf6;
            color: #ffffff;
        }

        .spotlight-glow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 0;
            background: radial-gradient(650px circle at var(--mouse-x, -500px) var(--mouse-y, -500px), rgba(139, 92, 246, 0.08), transparent 70%);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="spotlight-glow" id="cursorSpotlight"></div>

    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-2 px-3 small text-center mb-0 border-0 rounded-0 d-flex align-items-center justify-content-center gap-2">
            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
            <strong>Theme Preview Mode:</strong> Rendering with <code>Animattor 3D</code>. Live site remains unaffected.
            <a href="{{ url('/') }}" class="btn btn-xs btn-outline-dark ms-2">Exit Preview</a>
        </div>
    @endif

    <!-- Floating Pill Navigation -->
    <header class="sticky-top px-3 z-3">
        <nav class="navbar navbar-expand-lg animattor-pill-nav">
            <div class="container-fluid px-0">
                <a class="navbar-brand fw-bold text-violet-glow d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <div class="rounded-circle p-1" style="background: rgba(139, 92, 246, 0.2);">
                        <i data-lucide="sparkles" style="width: 16px; height: 16px;" class="text-violet-glow"></i>
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
                        <a href="{{ url('/admin/login') }}" class="btn btn-sm btn-violet px-3 py-1">
                            <i data-lucide="shield" style="width: 14px; height: 14px;" class="me-1"></i> Admin
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
            <p class="mb-0 text-muted">Theme: <strong>Animattor 3D</strong> • High-Performance Laravel 11 CMS</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();
        document.addEventListener('mousemove', e => {
            document.documentElement.style.setProperty('--mouse-x', `${e.clientX}px`);
            document.documentElement.style.setProperty('--mouse-y', `${e.clientY}px`);
        });
    </script>
</body>
</html>
