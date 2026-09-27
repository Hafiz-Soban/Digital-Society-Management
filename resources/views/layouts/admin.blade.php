<!DOCTYPE html>
<html lang="en" data-theme="light" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Portal') - {{ config('app.name') }}</title>

    <!-- Theme Initialization (Critical: Before any rendering) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Set Chart.js defaults based on current theme
        const currentTheme = localStorage.getItem('theme') || 'light';
        Chart.defaults.color = currentTheme === 'dark' ? '#94a3b8' : '#64748b';
        Chart.defaults.borderColor = currentTheme === 'dark' ? '#334155' : '#e2e8f0';
        Chart.defaults.font.family = "'Inter', sans-serif";
    </script>

    <style>
        :root {
            /* Light Theme Variables */
            --bg-body: #f8fafc;
            --sidebar-bg: #ffffff;
            --sidebar-color: #475569;
            --sidebar-active-bg: #f1f5f9;
            --sidebar-active-color: #2563eb;
            --sidebar-border: #e2e8f0;
            --topbar-bg: rgba(255, 255, 255, 0.9);
            --topbar-border: #e2e8f0;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --primary: #2563eb;
            --primary-rgb: 37, 99, 235;
            --sidebar-width: 260px;
            --topbar-height: 64px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --dropdown-bg: #ffffff;
            --dropdown-border: #e2e8f0;
            --dropdown-link-hover: #f1f5f9;
            --modal-bg: #ffffff;
            --modal-border: #e2e8f0;
        }

        [data-theme="dark"] {
            /* Dark Theme Variables */
            --bg-body: #0f172a;
            --sidebar-bg: #1e293b;
            --sidebar-color: #94a3b8;
            --sidebar-active-bg: #334155;
            --sidebar-active-color: #3b82f6;
            --sidebar-border: #334155;
            --topbar-bg: rgba(30, 41, 59, 0.9);
            --topbar-border: #334155;
            --card-bg: #1e293b;
            --card-border: #334155;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #3b82f6;
            --primary-rgb: 59, 130, 246;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.3);
            --shadow: 0 10px 15px -3px rgb(0 0 0 / 0.5), 0 4px 6px -4px rgb(0 0 0 / 0.5);
            --dropdown-bg: #1e293b;
            --dropdown-border: #334155;
            --dropdown-link-hover: #334155;
            --modal-bg: #1e293b;
            --modal-border: #334155;
        }

        * { font-family: 'Inter', sans-serif; }
        body { 
            background-color: var(--bg-body); 
            color: var(--text-main); 
            min-height: 100vh; 
            overflow-x: hidden;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* Sidebar */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--sidebar-border);
            z-index: 1050;
            overflow-y: auto;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.2s, border-color 0.2s;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: var(--sidebar-border); border-radius: 10px; }

        .sidebar-brand {
            height: var(--topbar-height);
            display: flex; align-items: center; padding: 0 20px;
            border-bottom: 1px solid var(--sidebar-border);
            text-decoration: none;
            gap: 12px;
        }
        .sidebar-brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), #1d4ed8);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.3rem;
            box-shadow: 0 4px 6px -1px rgba(var(--primary-rgb), 0.3);
        }
        .sidebar-brand-text {
            font-weight: 700; color: var(--text-main); font-size: 0.9rem;
            letter-spacing: -0.02em; line-height: 1.1;
            text-transform: uppercase;
        }

        .nav-list { padding: 16px 12px; list-style: none; margin: 0; }
        .nav-item { margin-bottom: 4px; }
        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 8px;
            color: var(--sidebar-color); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; transition: all 0.2s ease;
        }
        .nav-link:hover { background-color: var(--sidebar-active-bg); color: var(--sidebar-active-color); }
        .nav-link.active { background-color: var(--sidebar-active-bg); color: var(--sidebar-active-color); font-weight: 600; }
        .nav-link i { font-size: 1.1rem; width: 20px; text-align: center; }

        /* Sidebar Dropdowns */
        .nav-group-title {
            display: flex; align-items: center; justify-content: space-between;
            cursor: pointer;
        }
        .nav-group-title::after {
            content: "\F282"; font-family: "bootstrap-icons";
            font-size: 0.75rem; transition: transform 0.25s ease;
            opacity: 0.5;
        }
        .nav-group-title[aria-expanded="true"]::after { transform: rotate(180deg); opacity: 1; }
        .nav-group-content { list-style: none; padding: 4px 0 4px 32px; }
        .nav-group-content .nav-link { padding: 8px 12px; font-size: 0.8125rem; }

        /* Main Content */
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; transition: margin-left 0.3s ease, background-color 0.2s; }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background-color: var(--topbar-bg);
            border-bottom: 1px solid var(--topbar-border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 24px; position: sticky; top: 0; z-index: 1000;
            backdrop-filter: blur(12px);
            transition: background-color 0.2s, border-color 0.2s;
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .btn-icon {
            width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;
            border-radius: 10px; border: none; background: transparent;
            color: var(--text-muted); cursor: pointer; transition: all 0.2s;
        }
        .btn-icon:hover { background-color: var(--sidebar-active-bg); color: var(--text-main); }

        /* Page Content */
        .content-body { padding: 24px; flex: 1; }

        /* UI Components Upgrade */
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            transition: background-color 0.2s, border-color 0.2s, box-shadow 0.2s;
        }
        .card-header {
            background-color: transparent; border-bottom: 1px solid var(--card-border);
            padding: 16px 20px; font-weight: 600; color: var(--text-main);
        }
        
        /* Dropdowns, Modals, Popovers */
        .dropdown-menu {
            background-color: var(--dropdown-bg);
            border: 1px solid var(--dropdown-border);
            box-shadow: var(--shadow);
            padding: 8px;
            border-radius: 12px;
            transition: background-color 0.2s, border-color 0.2s;
        }
        .dropdown-item {
            color: var(--text-main);
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.875rem;
            transition: all 0.15s;
        }
        .dropdown-item:hover { background-color: var(--dropdown-link-hover); color: var(--primary); }
        .dropdown-divider { border-top: 1px solid var(--sidebar-border); opacity: 1; margin: 8px 0; }

        .modal-content {
            background-color: var(--modal-bg);
            border: 1px solid var(--modal-border);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }
        .modal-header, .modal-footer { border-color: var(--modal-border); }
        .modal-title { color: var(--text-main); }

        .table { color: var(--text-main); border-color: var(--card-border); transition: all 0.2s ease; }
        .table thead th {
            background-color: var(--sidebar-active-bg);
            color: var(--text-muted); font-size: 0.725rem; text-transform: uppercase;
            letter-spacing: 0.06em; padding: 14px 20px; border-bottom: 1px solid var(--card-border);
            font-weight: 700;
        }
        .table tbody td { padding: 16px 20px; border-bottom: 1px solid var(--card-border); vertical-align: middle; }
        
        .form-control, .form-select {
            background-color: var(--card-bg); border: 1.5px solid var(--card-border);
            color: var(--text-main); border-radius: 10px; padding: 10px 14px;
            font-size: 0.9rem; transition: border-color 0.2s, box-shadow 0.2s, background-color 0.2s;
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--card-bg); border-color: var(--primary);
            color: var(--text-main); box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.1);
        }
        .form-control::placeholder { color: var(--text-muted); opacity: 0.6; }

        .badge { font-weight: 600; padding: 6px 10px; border-radius: 6px; font-size: 0.725rem; }

        /* Stats Widget */
        .stat-widget { padding: 24px; }
        .stat-icon-box {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
            margin-bottom: 16px;
        }

<<<<<<< HEAD
        /* Stat Cards (Dashboard) */
        .stat-card {
            padding: 20px;
            border: none;
            border-radius: 14px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.15);
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-label {
            font-size: 0.8rem;
            font-weight: 500;
        }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        /* Pagination */
        .pagination .page-link {
            background-color: var(--card-bg); border: 1px solid var(--card-border);
            color: var(--text-main); margin: 0 2px; border-radius: 8px;
            padding: 8px 14px; font-size: 0.875rem;
        }
        .pagination .page-item.active .page-link { background-color: var(--primary); border-color: var(--primary); color: #fff; }
        .pagination .page-item.disabled .page-link { background-color: var(--sidebar-active-bg); color: var(--text-muted); border-color: var(--card-border); }

        /* Alerts */
        .alert { border-radius: 12px; border-width: 0; box-shadow: var(--shadow-sm); }

        /* Dark Mode Utility Overrides */
        [data-theme="dark"] .bg-white { background-color: var(--card-bg) !important; }
        [data-theme="dark"] .bg-light { background-color: var(--sidebar-active-bg) !important; }
        [data-theme="dark"] .card.border-0 { border: 1px solid var(--card-border) !important; }
        [data-theme="dark"] .table-light { background-color: var(--sidebar-active-bg) !important; color: var(--text-main) !important; }
        [data-theme="dark"] .card-header.bg-white { background-color: transparent !important; }
        [data-theme="dark"] .text-dark { color: var(--text-main) !important; }
        [data-theme="dark"] .border-bottom { border-color: var(--card-border) !important; }
        [data-theme="dark"] .dropdown-divider { border-color: var(--card-border) !important; }
        [data-theme="dark"] .hover-bg:hover { background-color: var(--sidebar-active-bg) !important; }
        [data-theme="dark"] .modal-header, [data-theme="dark"] .modal-footer { border-color: var(--card-border) !important; }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .sidebar-overlay {
                display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1040;
                backdrop-filter: blur(4px);
            }
            .sidebar-overlay.show { display: block; }
        }

        /* Theme Icon Visibility */
        .theme-icon-light, .theme-icon-dark { display: none; }
        [data-theme="light"] .theme-icon-dark { display: block !important; }
        [data-theme="dark"] .theme-icon-light { display: block !important; }

        /* Animations */
        @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        .fade-in { animation: fadeIn 0.3s ease-out; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-building-fill-check"></i>
            </div>
            <div class="sidebar-brand-text">
                <span class="d-block fw-bold text-primary">Digital Society</span>
                <span class="d-block text-muted" style="font-size: 0.65rem; letter-spacing: 0.05em; margin-top: -2px;">MANAGEMENT SYSTEM</span>
            </div>
        </a>

        <ul class="nav-list">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Management Group -->
            <li class="nav-item">
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.residents.*', 'admin.houses.*', 'admin.visitors.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#mgmtMenu" role="button" 
                   aria-expanded="{{ request()->routeIs('admin.residents.*', 'admin.houses.*', 'admin.visitors.*') ? 'true' : 'false' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Management</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.residents.*', 'admin.houses.*', 'admin.visitors.*') ? 'show' : '' }}" id="mgmtMenu">
                    <ul class="nav-group-content">
                        <li><a href="{{ route('admin.residents.index') }}" class="nav-link {{ request()->routeIs('admin.residents.index') ? 'active' : '' }}">All Residents</a></li>
                        <li><a href="{{ route('admin.residents.create') }}" class="nav-link {{ request()->routeIs('admin.residents.create') ? 'active' : '' }}">Add Resident</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a href="{{ route('admin.houses.index') }}" class="nav-link {{ request()->routeIs('admin.houses.index') ? 'active' : '' }}">All Houses</a></li>
                        <li><a href="{{ route('admin.houses.create') }}" class="nav-link {{ request()->routeIs('admin.houses.create') ? 'active' : '' }}">Add House</a></li>
                        <li><hr class="dropdown-divider"></li>
<<<<<<< HEAD
=======
                        <li><a href="{{ route('admin.staff.index') }}" class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">Society Staff</a></li>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        <li><a href="{{ route('admin.visitors.index') }}" class="nav-link {{ request()->routeIs('admin.visitors.*') ? 'active' : '' }}">Visitor Logs</a></li>
                    </ul>
                </div>
            </li>

            <!-- Operations Group -->
            <li class="nav-item">
<<<<<<< HEAD
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.complaints.*', 'admin.maintenance.*', 'admin.maintenance-management.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#opsMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.complaints.*', 'admin.maintenance.*', 'admin.maintenance-management.*') ? 'true' : 'false' }}">
                    <i class="bi bi-gear-wide-connected"></i>
                    <span>Operations</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.complaints.*', 'admin.maintenance.*', 'admin.maintenance-management.*') ? 'show' : '' }}" id="opsMenu">
=======
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.complaints.*', 'admin.maintenance.*', 'admin.expenses.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#opsMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.complaints.*', 'admin.maintenance.*', 'admin.expenses.*') ? 'true' : 'false' }}">
                    <i class="bi bi-gear-wide-connected"></i>
                    <span>Operations</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.complaints.*', 'admin.maintenance.*', 'admin.expenses.*') ? 'show' : '' }}" id="opsMenu">
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    <ul class="nav-group-content">
                        <li>
                            <a href="{{ route('admin.complaints.index') }}" class="nav-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                                Complaints
                                @php $pendingComplaints = \App\Models\Complaint::where('status','pending')->count(); @endphp
                                @if($pendingComplaints > 0)
                                    <span class="badge bg-danger ms-auto">{{ $pendingComplaints }}</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{ route('admin.maintenance.index') }}" class="nav-link {{ request()->routeIs('admin.maintenance.index') ? 'active' : '' }}">Maintenance Requests</a></li>
                        <li><a href="{{ route('admin.maintenance.staff') }}" class="nav-link {{ request()->routeIs('admin.maintenance.staff') ? 'active' : '' }}">Maintenance Staff</a></li>
                        <li><hr class="dropdown-divider"></li>
<<<<<<< HEAD
                        <li><a href="{{ route('admin.maintenance-management.dashboard') }}" class="nav-link {{ request()->routeIs('admin.maintenance-management.dashboard') ? 'active' : '' }}">Maintenance Dashboard</a></li>
                        <li><a href="{{ route('admin.maintenance-management.records') }}" class="nav-link {{ request()->routeIs('admin.maintenance-management.records') ? 'active' : '' }}">Resident Records</a></li>
                        <li><a href="{{ route('admin.maintenance-management.payments') }}" class="nav-link {{ request()->routeIs('admin.maintenance-management.payments') ? 'active' : '' }}">Payment History</a></li>
                        <li><a href="{{ route('admin.maintenance-management.payments.create') }}" class="nav-link {{ request()->routeIs('admin.maintenance-management.payments.create') ? 'active' : '' }}">Add Payment</a></li>
                        <li><a href="{{ route('admin.maintenance-management.settings') }}" class="nav-link {{ request()->routeIs('admin.maintenance-management.settings') ? 'active' : '' }}">Maintenance Settings</a></li>
=======
                        <li><a href="{{ route('admin.expenses.index') }}" class="nav-link {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">Monthly Expenses</a></li>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    </ul>
                </div>
            </li>

            <!-- Security Group -->
            <li class="nav-item">
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.security.*', 'admin.emergency.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#securityMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.security.*', 'admin.emergency.*') ? 'true' : 'false' }}">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span>Security</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.security.*', 'admin.emergency.*') ? 'show' : '' }}" id="securityMenu">
                    <ul class="nav-group-content">
                        <li><a href="{{ route('admin.security.index') }}" class="nav-link {{ request()->routeIs('admin.security.index') ? 'active' : '' }}">Security Logs</a></li>
                        <li>
                            <a href="{{ route('admin.emergency.index') }}" class="nav-link {{ request()->routeIs('admin.emergency.*') ? 'active' : '' }}">
                                Emergency Alerts
                                @php $activeAlerts = \App\Models\EmergencyAlert::where('status','active')->count(); @endphp
                                @if($activeAlerts > 0)
                                    <span class="badge bg-danger ms-auto">{{ $activeAlerts }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

<<<<<<< HEAD
            <!-- Vehicle Management Group -->
            <li class="nav-item">
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.vehicles.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#vehicleMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.vehicles.*') ? 'true' : 'false' }}">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Vehicle Management</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.vehicles.*') ? 'show' : '' }}" id="vehicleMenu">
                    <ul class="nav-group-content">
                        <li><a href="{{ route('admin.vehicles.dashboard') }}" class="nav-link {{ request()->routeIs('admin.vehicles.dashboard') ? 'active' : '' }}">Vehicle Dashboard</a></li>
                        <li><a href="{{ route('admin.vehicles.create') }}" class="nav-link {{ request()->routeIs('admin.vehicles.create') ? 'active' : '' }}">Add Vehicle</a></li>
                        <li><a href="{{ route('admin.vehicles.index') }}" class="nav-link {{ request()->routeIs('admin.vehicles.index') ? 'active' : '' }}">Vehicle List</a></li>
                        <li><a href="{{ route('admin.vehicles.logs.index') }}" class="nav-link {{ request()->routeIs('admin.vehicles.logs.index') ? 'active' : '' }}">Vehicle Entry Logs</a></li>
                        <li><a href="{{ route('admin.vehicles.alerts.index') }}" class="nav-link {{ request()->routeIs('admin.vehicles.alerts.index') ? 'active' : '' }}">Suspicious Alerts</a></li>
                    </ul>
                </div>
            </li>

            <!-- Staff Management Group -->
            <li class="nav-item">
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.staff*', 'admin.staff-salaries.*', 'admin.staff-advances.*', 'admin.emergency-contacts.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#staffMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.staff*', 'admin.staff-salaries.*', 'admin.staff-advances.*', 'admin.emergency-contacts.*') ? 'true' : 'false' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Staff Management</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.staff*', 'admin.staff-salaries.*', 'admin.staff-advances.*', 'admin.emergency-contacts.*') ? 'show' : '' }}" id="staffMenu">
                    <ul class="nav-group-content">
                        <li><a href="{{ route('admin.staff.dashboard') }}" class="nav-link {{ request()->routeIs('admin.staff.dashboard') ? 'active' : '' }}">Staff Dashboard</a></li>
                        <li><a href="{{ route('admin.staff.create') }}" class="nav-link {{ request()->routeIs('admin.staff.create') ? 'active' : '' }}">Add Staff</a></li>
                        <li><a href="{{ route('admin.staff.index') }}" class="nav-link {{ request()->routeIs('admin.staff.index') ? 'active' : '' }}">Staff List</a></li>
                        <li><a href="{{ route('admin.staff.attendance.index') }}" class="nav-link {{ request()->routeIs('admin.staff.attendance.*') ? 'active' : '' }}">Staff Attendance</a></li>
                        <li><a href="{{ route('admin.staff-salaries.index') }}" class="nav-link {{ request()->routeIs('admin.staff-salaries.*') ? 'active' : '' }}">Salary Management</a></li>
                        <li><a href="{{ route('admin.staff-advances.index') }}" class="nav-link {{ request()->routeIs('admin.staff-advances.*') ? 'active' : '' }}">Advance Salary</a></li>
                        <li><a href="{{ route('admin.emergency-contacts.index') }}" class="nav-link {{ request()->routeIs('admin.emergency-contacts.*') ? 'active' : '' }}">Emergency Contacts</a></li>
                    </ul>
                </div>
            </li>

            <!-- Expense Management Group -->
            <li class="nav-item">
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.expenses.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#expenseMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.expenses.*') ? 'true' : 'false' }}">
                    <i class="bi bi-wallet2"></i>
                    <span>Expense Management</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.expenses.*') ? 'show' : '' }}" id="expenseMenu">
                    <ul class="nav-group-content">
                        <li><a href="{{ route('admin.expenses.create') }}" class="nav-link {{ request()->routeIs('admin.expenses.create') ? 'active' : '' }}">Add Expense</a></li>
                        <li><a href="{{ route('admin.expenses.index') }}" class="nav-link {{ request()->routeIs('admin.expenses.index') ? 'active' : '' }}">Expense List</a></li>
                        <li><a href="{{ route('admin.expenses.report') }}" class="nav-link {{ request()->routeIs('admin.expenses.report') ? 'active' : '' }}">Expense Report</a></li>
                    </ul>
                </div>
            </li>

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            <!-- Information Group -->
            <li class="nav-item">
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.notices.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#infoMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.notices.*') ? 'true' : 'false' }}">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Information</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.notices.*') ? 'show' : '' }}" id="infoMenu">
                    <ul class="nav-group-content">
                        <li><a href="{{ route('admin.notices.index') }}" class="nav-link {{ request()->routeIs('admin.notices.index') ? 'active' : '' }}">All Notices</a></li>
                        <li><a href="{{ route('admin.notices.create') }}" class="nav-link {{ request()->routeIs('admin.notices.create') ? 'active' : '' }}">Create Notice</a></li>
                    </ul>
                </div>
            </li>

            <!-- Analytics Group -->
            <li class="nav-item">
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.reports.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#reportsMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }}">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Analytics</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.reports.*') ? 'show' : '' }}" id="reportsMenu">
                    <ul class="nav-group-content">
                        <li><a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">Reports Center</a></li>
                        <li><a href="{{ route('admin.reports.residents') }}" class="nav-link {{ request()->routeIs('admin.reports.residents') ? 'active' : '' }}">Resident Data</a></li>
<<<<<<< HEAD
                        <li><a href="{{ route('admin.reports.vehicles') }}" class="nav-link {{ request()->routeIs('admin.reports.vehicles') ? 'active' : '' }}">Vehicle Reports</a></li>
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    </ul>
                </div>
            </li>

            <!-- System Group -->
            <li class="nav-item">
<<<<<<< HEAD
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.settings.*', 'admin.recycle-bin.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#systemMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.settings.*', 'admin.recycle-bin.*') ? 'true' : 'false' }}">
                    <i class="bi bi-cpu-fill"></i>
                    <span>System</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.settings.*', 'admin.recycle-bin.*') ? 'show' : '' }}" id="systemMenu">
                    <ul class="nav-group-content">
                        <li><a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">General Settings</a></li>
                        <li><a href="{{ route('admin.settings.users.create') }}" class="nav-link {{ request()->routeIs('admin.settings.users.create') ? 'active' : '' }}">User Management</a></li>
                        <li><a href="{{ route('admin.recycle-bin.index') }}" class="nav-link {{ request()->routeIs('admin.recycle-bin.*') ? 'active' : '' }}">Recycle Bin</a></li>
=======
                <a class="nav-link nav-group-title {{ request()->routeIs('admin.settings.*') ? '' : 'collapsed' }}" 
                   data-bs-toggle="collapse" href="#systemMenu" role="button"
                   aria-expanded="{{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }}">
                    <i class="bi bi-cpu-fill"></i>
                    <span>System</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.settings.*') ? 'show' : '' }}" id="systemMenu">
                    <ul class="nav-group-content">
                        <li><a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">General Settings</a></li>
                        <li><a href="{{ route('admin.settings.users.create') }}" class="nav-link {{ request()->routeIs('admin.settings.users.create') ? 'active' : '' }}">User Management</a></li>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    </ul>
                </div>
            </li>
        </ul>

        <div class="mt-auto p-4 border-top" style="border-color: var(--sidebar-border) !important;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 btn-sm d-flex align-items-center justify-content-center gap-2 py-2">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="btn-icon d-lg-none" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h5 class="mb-0 fw-semibold d-none d-md-block text-main">@yield('page-title', 'Dashboard')</h5>
            </div>

            <div class="topbar-right">
                <!-- Theme Toggle -->
                <button class="btn-icon" id="themeToggle" title="Toggle Theme">
                    <i class="bi bi-moon-fill theme-icon-dark"></i>
                    <i class="bi bi-sun-fill theme-icon-light"></i>
                </button>

                <!-- Notifications -->
                <div class="dropdown">
                    <button class="btn-icon position-relative" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        @php $unread = auth()->user()->unreadNotifications()->count(); @endphp
                        @if($unread > 0)
                            <span class="position-absolute top-2 end-2 p-1 bg-danger border border-light rounded-circle"></span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-0" style="width: 320px;">
                        <div class="px-3 py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold">Notifications</h6>
                            @if($unread > 0)
                                <span class="badge bg-primary-subtle text-primary">{{ $unread }} new</span>
                            @endif
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;">
                            @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notif)
                                <a href="{{ $notif->link ?? '#' }}" class="dropdown-item px-3 py-2 border-bottom {{ !$notif->is_read ? 'bg-light-subtle' : '' }}">
                                    <div class="d-flex gap-3">
                                        <div class="flex-shrink-0 pt-1 text-primary">
                                            <i class="bi {{ $notif->icon ?? 'bi-bell' }} fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold small text-truncate" style="max-width: 220px;">{{ $notif->title }}</div>
                                            <div class="text-muted small text-truncate" style="max-width: 220px;">{{ $notif->message }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">{{ $notif->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="px-3 py-4 text-center text-muted small">No new notifications</div>
                            @endforelse
                        </div>
                        <div class="p-2 border-top text-center">
                            <a href="#" class="btn btn-link btn-sm text-decoration-none">View All Notifications</a>
                        </div>
                    </div>
                </div>

                <div class="vr mx-2 opacity-10"></div>

                <!-- User Profile -->
                <div class="dropdown">
                    <button class="btn d-flex align-items-center gap-2 p-1 pe-2 rounded-pill hover-bg" data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle border" width="32" height="32" alt="Avatar">
                        <div class="text-start d-none d-sm-block">
                            <div class="fw-semibold small lh-1 text-main">{{ auth()->user()->name }}</div>
                            <small class="text-muted" style="font-size: 0.7rem;">Administrator</small>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> My Profile</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-body fade-in">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle for Mobile
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if(sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
            });
        }

        if(sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }

        // Theme Toggle Logic
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            html.setAttribute('data-theme', newTheme);
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            // Update Chart defaults if Chart.js is loaded
            if (window.Chart) {
                Chart.defaults.color = newTheme === 'dark' ? '#94a3b8' : '#64748b';
                Chart.defaults.borderColor = newTheme === 'dark' ? '#334155' : '#e2e8f0';
                
                // Find all charts and update them
                Object.values(Chart.instances).forEach(chart => {
                    chart.options.scales.x.ticks.color = Chart.defaults.color;
                    chart.options.scales.y.ticks.color = Chart.defaults.color;
                    chart.options.scales.x.grid.color = Chart.defaults.borderColor;
                    chart.options.scales.y.grid.color = Chart.defaults.borderColor;
                    chart.update();
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
