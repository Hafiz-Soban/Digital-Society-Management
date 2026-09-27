<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Registration | Digital Society Management</title>
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
        .register-wrapper {
            width: 100%;
            max-width: 1000px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08);
            display: flex;
            overflow: hidden;
        }
        .register-side-info {
            flex: 1;
            background: linear-gradient(rgba(37, 99, 235, 0.9), rgba(30, 64, 175, 0.9)), 
                        url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=1000&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
        }
        .register-form-side {
            width: 500px;
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
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--primary);
        }
        .btn-register {
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
        .btn-register:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
        
        @media (max-width: 992px) {
            .register-side-info { display: none; }
            .register-form-side { width: 100%; padding: 32px; }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-side-info">
            <div class="mb-4">
                <i class="bi bi-shield-check fs-1"></i>
            </div>
            <h2 class="fw-bold mb-3">Owner Registration</h2>
            <p class="lead mb-4">Register your property to access the Digital Society Management System.</p>
            <ul class="list-unstyled">
                <li class="mb-3 d-flex gap-3 align-items-center">
                    <i class="bi bi-check-circle-fill text-white"></i>
                    <span>Verify property ownership instantly</span>
                </li>
                <li class="mb-3 d-flex gap-3 align-items-center">
                    <i class="bi bi-check-circle-fill text-white"></i>
                    <span>Secure OTP verification</span>
                </li>
                <li class="mb-3 d-flex gap-3 align-items-center">
                    <i class="bi bi-check-circle-fill text-white"></i>
                    <span>One property, one owner account</span>
                </li>
            </ul>
        </div>

        <div class="register-form-side">
            <div class="login-logo">
                <i class="bi bi-building-fill-check fs-4"></i>
            </div>
            <h4 class="fw-bold text-slate-900 mb-1">Join the Portal</h4>
            <p class="text-muted small mb-4">Only property owners can register here.</p>

            @if($errors->any())
                <div class="alert alert-danger border-0 small mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Owner Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="As per society records" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">CNIC Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" name="cnic" class="form-control" value="{{ old('cnic') }}" placeholder="42101-XXXXXXX-X" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">House Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-house"></i></span>
                            <input type="text" name="house_number" class="form-control" value="{{ old('house_number') }}" placeholder="e.g. A-101" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="your@email.com" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-register w-100 mt-4">
                    Verify & Send OTP
                </button>

                <p class="text-center mt-4 small text-muted">
                    Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Login Here</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
