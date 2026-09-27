<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Security Portal') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f0f2f5; }
        .sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: 250px; background: #1b2838; z-index: 1000; overflow-y: auto; }
        .sidebar-brand { padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand h5 { color: #fff; font-weight: 700; margin: 0; }
        .sidebar-brand small { color: rgba(255,255,255,0.5); }
        .sidebar-nav { padding: 10px 0; }
        .nav-section-title { color: rgba(255,255,255,0.4); font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px 5px; }
        .sidebar-nav .nav-link { color: rgba(255,255,255,0.7); padding: 10px 20px; display: flex; align-items: center; gap: 10px; font-size: 0.875rem; transition: all 0.2s; }
        .sidebar-nav .nav-link:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .sidebar-nav .nav-link.active { color: #fff; background: #dc3545; }
        .sidebar-nav .nav-link i { font-size: 1rem; width: 20px; }
        .main-content { margin-left: 250px; min-height: 100vh; }
        .topbar { height: 60px; background: #fff; border-bottom: 1px solid #e9ecef; display: flex; align-items: center; padding: 0 20px; position: sticky; top: 0; z-index: 999; gap: 15px; }
        .topbar .page-title { font-weight: 600; font-size: 1rem; color: #333; flex: 1; }
        .content-area { padding: 25px; }
        .alert { border: none; border-radius: 10px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-danger rounded-2 p-2">
                    <i class="bi bi-shield-fill text-white fs-5"></i>
                </div>
                <div>
                    <h5>Security</h5>
                    <small>Guard Portal</small>
                </div>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="nav-section-title">Main</div>
            <a href="{{ route('security.dashboard') }}" class="nav-link {{ request()->routeIs('security.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="nav-section-title">Visitor Management</div>
            <a href="{{ route('security.visitors.index') }}" class="nav-link {{ request()->routeIs('security.visitors.index') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Visitor Logs
            </a>
            <a href="{{ route('security.visitors.create') }}" class="nav-link {{ request()->routeIs('security.visitors.create') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i> Add Visitor Entry
            </a>

            <div class="nav-section-title">Security & Incidents</div>
            <a href="{{ route('security.incidents.index') }}" class="nav-link {{ request()->routeIs('security.incidents.*') ? 'active' : '' }}">
                <i class="bi bi-shield-exclamation"></i> Incidents
            </a>
            <a href="{{ route('security.logs.index') }}" class="nav-link {{ request()->routeIs('security.logs.index') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i> Entry/Exit Logs
            </a>

<<<<<<< HEAD
            <div class="nav-section-title">Vehicle Security</div>
            <a href="{{ route('security.vehicles.logs.index') }}" class="nav-link {{ request()->routeIs('security.vehicles.logs.*') ? 'active' : '' }}">
                <i class="bi bi-car-front"></i> Vehicle Entry Logs
            </a>

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            <div class="nav-section-title">Emergency</div>
            <a href="{{ route('security.emergency.index') }}" class="nav-link {{ request()->routeIs('security.emergency.*') ? 'active' : '' }}">
                <i class="bi bi-exclamation-triangle"></i> Emergency Alerts
                @php $activeAlerts = \App\Models\EmergencyAlert::where('status','active')->count(); @endphp
                @if($activeAlerts > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $activeAlerts }}</span>
                @endif
            </a>

            <div class="nav-section-title">Directory</div>
            <a href="{{ route('security.residents.index') }}" class="nav-link {{ request()->routeIs('security.residents.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Verify Resident
            </a>
            <a href="{{ route('security.notices.index') }}" class="nav-link {{ request()->routeIs('security.notices.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i> Notices
            </a>

            <div class="nav-section-title">Account</div>
            <a href="{{ route('security.profile.show') }}" class="nav-link {{ request()->routeIs('security.profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> My Profile
            </a>
            <a href="{{ route('security.notifications.index') }}" class="nav-link {{ request()->routeIs('security.notifications.*') ? 'active' : '' }}">
                <i class="bi bi-bell"></i> Notifications
                @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
                @if($unreadCount > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $unreadCount }}</span>
                @endif
            </a>
        </div>
    </nav>

    <div class="main-content">
        <div class="topbar">
            <button class="btn btn-sm btn-light d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list fs-5"></i>
            </button>
            <span class="page-title">@yield('page-title', 'Dashboard')</span>

            <div class="dropdown">
                <button class="btn btn-light btn-sm d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle" width="28" height="28" alt="Avatar">
                    <span class="d-none d-md-inline" style="font-size:0.875rem">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
