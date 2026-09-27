<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | Digital Society Management</title>
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
        .otp-wrapper {
            width: 100%;
            max-width: 450px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.08);
            padding: 48px;
            text-align: center;
        }
        .otp-icon {
            width: 64px; height: 64px;
            background: #eff6ff;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
            color: var(--primary);
        }
        .form-control {
            border-radius: 12px;
            padding: 14px;
            border: 1.5px solid #e2e8f0;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5em;
            text-align: center;
            color: #1e293b;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        .btn-verify {
            background: var(--primary);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 1rem;
            color: #fff;
            width: 100%;
            margin-top: 24px;
            transition: all 0.2s;
        }
        .btn-verify:hover { background: var(--primary-dark); transform: translateY(-1px); }
    </style>
</head>
<body>
    <div class="otp-wrapper">
        <div class="otp-icon">
            <i class="bi bi-shield-lock fs-2"></i>
        </div>
        <h4 class="fw-bold mb-1">Verify Ownership</h4>
        <p class="text-muted small mb-4">We've sent a 6-digit verification code to your registered mobile number <span class="fw-bold text-dark">{{ $maskedPhone }}</span>.</p>

        @if(session('success'))
            <div class="alert alert-success border-0 small mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 small mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.otp') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label d-block text-start small fw-bold">Enter 6-Digit OTP</label>
                <input type="text" name="otp" class="form-control" maxlength="6" pattern="[0-9]{6}" required autofocus>
            </div>

            <button type="submit" class="btn btn-verify">
                Verify & Create Account
            </button>
        </form>

        <form action="{{ route('register.resend-otp') }}" method="POST" class="mt-4">
            @csrf
            <p class="small text-muted mb-0">
                Didn't receive the code? 
                <button type="submit" class="btn btn-link p-0 small fw-bold text-decoration-none">Resend OTP</button>
            </p>
        </form>

        <div class="mt-4 pt-3 border-top">
            <a href="{{ route('register') }}" class="small text-muted text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Back to registration
            </a>
        </div>
    </div>
</body>
</html>
