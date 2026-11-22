<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | {{ config('app.name') }} Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --admin-accent: #10b981;
            --admin-accent-hover: #059669;
        }
        body {
            background: radial-gradient(circle at 50% 10%, #13232c, #070b12 80%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, sans-serif;
            padding: 1.5rem;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            padding: 2.5rem;
        }
        .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--admin-accent);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .btn-emerald {
            background: var(--admin-accent);
            border-color: var(--admin-accent);
            color: #ffffff;
            font-weight: 600;
        }
        .btn-emerald:hover {
            background: var(--admin-accent-hover);
            border-color: var(--admin-accent-hover);
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i data-lucide="shield-check" style="width: 28px; height: 28px;"></i>
            </div>
            <h1 class="h4 fw-bold mb-1">ALIF AHMED</h1>
            <p class="text-secondary small mb-0">Management Portal & Dynamic CMS</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success py-2 px-3 small mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 small mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/admin/login" method="POST">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label small text-secondary">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-body-secondary border-secondary-subtle">
                        <i data-lucide="mail" style="width: 16px; height: 16px;"></i>
                    </span>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@alifahmed.com">
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label small text-secondary mb-0">Password</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-body-secondary border-secondary-subtle">
                        <i data-lucide="lock" style="width: 16px; height: 16px;"></i>
                    </span>
                    <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password" placeholder="••••••••••••">
                </div>
            </div>

            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                    <label class="form-check-label small text-secondary" for="remember">
                        Remember session
                    </label>
                </div>
                <span class="badge bg-secondary-subtle text-secondary small">Throttled (5/min)</span>
            </div>

            <button type="submit" class="btn btn-emerald w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                <span>Sign In to Dashboard</span>
                <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top border-secondary-subtle">
            <small class="text-muted">Strict Admin-Only Access • No Public Registration</small>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
