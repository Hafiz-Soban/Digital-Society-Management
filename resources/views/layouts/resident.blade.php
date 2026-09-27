<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Resident Portal') — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 255px;
            --primary: #0f4c81;
            --primary-light: #1a6bb5;
            --topbar-h: 62px;
        }
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        body { background: #f0f4f8; min-height: 100vh; }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0f4c81 0%, #0a3560 100%);
            z-index: 1040; overflow-y: auto; overflow-x: hidden;
            transition: transform .3s ease;
        }
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.2); border-radius: 2px; }

        .sidebar-brand {
            padding: 18px 20px 14px;
            border-bottom: 1px solid rgba(255,255,255,.12);
            display: flex; align-items: center; gap: 12px;
        }
        .sidebar-brand .brand-icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: rgba(255,255,255,.15);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-brand h6 { color: #fff; font-weight: 700; margin: 0; font-size: .9rem; }
        .sidebar-brand small { color: rgba(255,255,255,.55); font-size: .72rem; }

        .nav-section {
            color: rgba(255,255,255,.35);
            font-size: .65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.2px;
            padding: 14px 20px 4px;
        }
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,.72);
            padding: 9px 20px;
            display: flex; align-items: center; gap: 10px;
            font-size: .845rem; border-radius: 0;
            transition: all .18s; position: relative;
        }
        .sidebar-nav .nav-link i { font-size: .95rem; width: 18px; flex-shrink: 0; }
        .sidebar-nav .nav-link:hover { color: #fff; background: rgba(255,255,255,.1); }
        .sidebar-nav .nav-link.active {
            color: #fff; background: rgba(255,255,255,.18);
            border-left: 3px solid #fff;
        }
        .sidebar-nav .nav-link .badge { margin-left: auto; font-size: .62rem; }

        /* ── Main ── */
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; }

        /* ── Topbar ── */
        .topbar {
            height: var(--topbar-h); background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; padding: 0 22px;
            position: sticky; top: 0; z-index: 1030; gap: 14px;
        }
        .topbar .page-title { font-weight: 600; font-size: .95rem; color: #1e293b; flex: 1; }
        .topbar .btn-icon {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: #f1f5f9; border: none; color: #64748b;
            transition: all .15s; position: relative;
        }
        .topbar .btn-icon:hover { background: #e2e8f0; color: #1e293b; }

        /* ── Content ── */
        .content-area { padding: 24px; }

        /* ── Cards ── */
        .card { border: none; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,.07); }
        .stat-card { border-radius: 12px; padding: 20px; border: none; }
        .stat-card .stat-icon {
            width: 48px; height: 48px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
        }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; line-height: 1; }
        .stat-card .stat-label { font-size: .75rem; opacity: .75; margin-top: 2px; }

        /* ── Tables ── */
        .table th { font-size: .75rem; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #64748b; }
        .table td { font-size: .855rem; vertical-align: middle; }

        /* ── Alerts ── */
        .alert { border: none; border-radius: 10px; }

        /* ── Timeline ── */
        .timeline { position: relative; padding-left: 28px; }
        .timeline::before { content: ''; position: absolute; left: 9px; top: 0; bottom: 0; width: 2px; background: #e2e8f0; }
        .timeline-item { position: relative; margin-bottom: 20px; }
        .timeline-item::before {
            content: ''; position: absolute; left: -23px; top: 4px;
            width: 12px; height: 12px; border-radius: 50%;
            background: #0f4c81; border: 2px solid #fff;
            box-shadow: 0 0 0 2px #0f4c81;
        }
        .timeline-item.success::before { background: #198754; box-shadow: 0 0 0 2px #198754; }
        .timeline-item.warning::before { background: #ffc107; box-shadow: 0 0 0 2px #ffc107; }
        .timeline-item.danger::before  { background: #dc3545; box-shadow: 0 0 0 2px #dc3545; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- ═══════════════ SIDEBAR ═══════════════ -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="bi bi-house-heart-fill text-white fs-5"></i>
        </div>
        <div>
            <h6>My Portal</h6>
            <small>Resident Dashboard</small>
        </div>
    </div>

    <div class="sidebar-nav mt-1">
<<<<<<< HEAD
=======
        @php $isRestricted = auth()->user()->resident?->isRestricted(); @endphp
        
        @if($isRestricted)
            <div class="px-3 mb-3">
                <div class="alert alert-danger py-2 px-3 border-0 small" style="font-size: 0.75rem; background: rgba(220, 53, 69, 0.2); color: #ff8a94;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Account Restricted
                </div>
            </div>
        @endif

>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        <div class="nav-section">Main</div>
        <a href="{{ route('resident.dashboard') }}"
           class="nav-link {{ request()->routeIs('resident.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">My Account</div>
        <a href="{{ route('resident.profile.show') }}"
           class="nav-link {{ request()->routeIs('resident.profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> My Profile
        </a>
<<<<<<< HEAD
=======
        
        @if(!$isRestricted)
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        <a href="{{ route('resident.house.index') }}"
           class="nav-link {{ request()->routeIs('resident.house.*') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> My House
        </a>

        <div class="nav-section">Services</div>
<<<<<<< HEAD
=======
        <a href="{{ route('resident.domestic-staff.index') }}"
           class="nav-link {{ request()->routeIs('resident.domestic-staff.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Domestic Staff
        </a>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        <a href="{{ route('resident.visitors.index') }}"
           class="nav-link {{ request()->routeIs('resident.visitors.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Visitors
            @php $pv = auth()->user()->resident?->visitors()->where('status','pending')->count() ?? 0; @endphp
            @if($pv) <span class="badge bg-warning text-dark">{{ $pv }}</span> @endif
        </a>
        <a href="{{ route('resident.complaints.index') }}"
           class="nav-link {{ request()->routeIs('resident.complaints.*') ? 'active' : '' }}">
            <i class="bi bi-chat-square-text"></i> Complaints
            @php $pendingComp = auth()->user()->resident?->complaints()->where('status','pending')->count() ?? 0; @endphp
            @if($pendingComp) <span class="badge bg-danger">{{ $pendingComp }}</span> @endif
        </a>
        <a href="{{ route('resident.maintenance.index') }}"
           class="nav-link {{ request()->routeIs('resident.maintenance.*') ? 'active' : '' }}">
            <i class="bi bi-tools"></i> Maintenance
        </a>

        <div class="nav-section">Information</div>
        <a href="{{ route('resident.notices.index') }}"
           class="nav-link {{ request()->routeIs('resident.notices.*') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i> Notices
        </a>
<<<<<<< HEAD
=======
        @endif

        @if($isRestricted)
            <div class="nav-section text-danger">Emergency Only</div>
        @endif

>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        <a href="{{ route('resident.emergency.index') }}"
           class="nav-link {{ request()->routeIs('resident.emergency.*') ? 'active' : '' }}">
            <i class="bi bi-exclamation-triangle"></i> Emergency
            @php $ea = \App\Models\EmergencyAlert::where('status','active')->count(); @endphp
            @if($ea) <span class="badge bg-danger">{{ $ea }}</span> @endif
        </a>
<<<<<<< HEAD
=======

        @if(!$isRestricted)
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        <a href="{{ route('resident.directory.index') }}"
           class="nav-link {{ request()->routeIs('resident.directory.*') ? 'active' : '' }}">
            <i class="bi bi-telephone-fill"></i> Directory
        </a>
<<<<<<< HEAD
=======
        @endif

>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        <a href="{{ route('resident.notifications.index') }}"
           class="nav-link {{ request()->routeIs('resident.notifications.*') ? 'active' : '' }}">
            <i class="bi bi-bell"></i> Notifications
            @php $un = auth()->user()->unreadNotifications()->count(); @endphp
            @if($un) <span class="badge bg-danger">{{ $un }}</span> @endif
        </a>

        <div class="nav-section">Account</div>
        <a href="{{ route('resident.settings') }}"
           class="nav-link {{ request()->routeIs('resident.settings') ? 'active' : '' }}">
            <i class="bi bi-gear"></i> Settings
        </a>
        <div class="px-3 pb-4 mt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm w-100 text-start"
                    style="background:rgba(255,255,255,.1);color:rgba(255,255,255,.8);border-radius:8px;padding:8px 12px">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- ═══════════════ MAIN CONTENT ═══════════════ -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <button class="btn-icon d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
            <i class="bi bi-list fs-5"></i>
        </button>
        <span class="page-title">@yield('page-title', 'Dashboard')</span>

        <!-- Notification Bell -->
        <div class="dropdown">
            <button class="btn-icon position-relative" data-bs-toggle="dropdown" id="notifBtn">
                <i class="bi bi-bell fs-5"></i>
                @if($un ?? 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                          style="font-size:.55rem" id="notifBadge">{{ $un }}</span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0"
                 style="width:320px;border-radius:12px;overflow:hidden">
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                    <strong style="font-size:.875rem">Notifications</strong>
                    @if($un ?? 0)
                        <form method="POST" action="{{ route('resident.notifications.read-all') }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-link btn-sm p-0 text-primary" style="font-size:.75rem">
                                Mark all read
                            </button>
                        </form>
                    @endif
                </div>
                <div style="max-height:320px;overflow-y:auto">
                    @forelse(auth()->user()->notifications()->latest()->take(6)->get() as $notif)
                        <a href="{{ $notif->link ?? '#' }}"
                           class="dropdown-item py-2 px-3 {{ !$notif->is_read ? 'bg-light' : '' }}"
                           style="border-bottom:1px solid #f1f5f9">
                            <div class="d-flex gap-2">
                                <div class="flex-shrink-0 mt-1">
                                    <i class="bi {{ $notif->icon ?? 'bi-bell' }} text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:.78rem">{{ $notif->title }}</div>
                                    <div class="text-muted" style="font-size:.72rem">{{ Str::limit($notif->message,55) }}</div>
                                    <div class="text-muted" style="font-size:.68rem">{{ $notif->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center text-muted py-4" style="font-size:.82rem">
                            <i class="bi bi-bell-slash d-block fs-3 mb-1"></i>No notifications
                        </div>
                    @endforelse
                </div>
                <div class="text-center py-2 border-top">
                    <a href="{{ route('resident.notifications.index') }}" class="text-primary" style="font-size:.78rem">
                        View all notifications
                    </a>
                </div>
            </div>
        </div>

        <!-- User Menu -->
        <div class="dropdown">
            <button class="d-flex align-items-center gap-2 border-0 bg-transparent" data-bs-toggle="dropdown">
                <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle border"
                     width="34" height="34" alt="Avatar" style="object-fit:cover">
                <div class="d-none d-md-block text-start">
                    <div style="font-size:.8rem;font-weight:600;color:#1e293b;line-height:1.2">
                        {{ Str::limit(auth()->user()->name, 18) }}
                    </div>
                    <div style="font-size:.68rem;color:#64748b">Resident</div>
                </div>
                <i class="bi bi-chevron-down d-none d-md-block" style="font-size:.65rem;color:#64748b"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:10px;min-width:180px">
                <li><h6 class="dropdown-header" style="font-size:.72rem">{{ auth()->user()->email }}</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('resident.profile.show') }}" style="font-size:.83rem">
                        <i class="bi bi-person me-2"></i>My Profile
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('resident.settings') }}" style="font-size:.83rem">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                </li>
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger" style="font-size:.83rem">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="content-area pb-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('sos_sent'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3 border border-danger">
                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                <span><strong>{{ session('sos_sent') }}</strong></span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)<li style="font-size:.85rem">{{ $error }}</li>@endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <div class="content-area pt-2">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Auto-dismiss alerts after 5s
document.querySelectorAll('.alert').forEach(el => {
    setTimeout(() => {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
        if (bsAlert) bsAlert.close();
    }, 5000);
});
</script>
@stack('scripts')
</body>
</html>
