<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login | Digital Society Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            min-height: 100vh;
            background: var(--bg-gradient);
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
        }
        .login-wrapper {
            width: 100%;
            max-width: 900px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08);
            display: flex;
            overflow: hidden;
        }
        .login-side-image {
            flex: 1;
            background: linear-gradient(rgba(37, 99, 235, 0.9), rgba(30, 64, 175, 0.9)), 
                        url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?q=80&w=1000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
        }
        .login-form-side {
            width: 420px;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-logo {
            width: 48px; height: 48px;
            background: #eff6ff;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px;
            color: var(--primary);
        }
        .form-label { font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 8px; }
        .input-group { position: relative; }
        .input-group-text {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #64748b;
        }
        .form-control {
            border-radius: 0 12px 12px 0;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-left: none;
            font-size: 0.95rem;
            color: #1e293b;
        }
        .form-control:focus {
            border-color: #e2e8f0;
            box-shadow: none;
            background: #fdfdfd;
        }
        .form-control.is-invalid { border-color: #ef4444; }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--primary);
        }
        .btn-login {
            background: var(--primary);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            color: #fff;
            margin-top: 12px;
            transition: all 0.2s;
        }
        .btn-login:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
        .btn-login:active { transform: translateY(0); }
        .btn-login .spinner-border { width: 1.2rem; height: 1.2rem; display: none; }
        .loading .btn-login .spinner-border { display: inline-block; }
        .loading .btn-login span { display: none; }

        @media (max-width: 850px) {
            .login-side-image { display: none; }
            .login-form-side { width: 100%; padding: 40px 32px; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Branding Side -->
        <div class="login-side-image">
            <h1 class="fw-bold mb-3">Modern Living,<br>Simplified Management.</h1>
            <p class="opacity-75 fs-5">Everything you need to manage your community, all in one secure place.</p>
            <div class="mt-5 d-flex gap-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-shield-check fs-4"></i>
                    <span class="small fw-500">Secure Access</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-lightning-charge fs-4"></i>
                    <span class="small fw-500">Real-time Alerts</span>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="login-form-side">
            <div class="login-logo">
                <i class="bi bi-building-fill fs-4"></i>
            </div>
            <h3 class="fw-bold text-dark mb-1">Welcome Back</h3>
            <p class="text-muted mb-4 pb-2">Please enter your credentials to login.</p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 mb-4" style="background:#f0fdf4; color:#166534">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" id="loginForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" placeholder="name@society.com" required autofocus>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label">Password</label>
                        <a href="#" class="text-decoration-none small fw-bold text-primary">Forgot?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="passwordInput" 
                               class="form-control border-end-0 @error('password') is-invalid @enderror" 
                               placeholder="••••••••" required>
                        <button type="button" class="input-group-text bg-white border-start-0" 
                                style="border-radius: 0 12px 12px 0; border: 1.5px solid #e2e8f0; border-left: none;"
                                onclick="togglePassword()">
                            <i class="bi bi-eye text-muted" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label text-muted small" for="remember">Keep me logged in</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100 d-flex align-items-center justify-content-center">
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    <span>Sign In to Dashboard</span>
                </button>
            </form>

            <p class="text-center mt-5 text-muted small mb-0">
                Authorized access only. By logging in, you agree to our <a href="#" class="text-dark fw-bold text-decoration-none">Terms of Service</a>.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function() {
            this.classList.add('loading');
            this.querySelector('button[type="submit"]').disabled = true;
        });
    </script>
</body>
</html>
