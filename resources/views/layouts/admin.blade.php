<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — ICV E-Learning</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--navy:#002147;--gold:#f1c40f;--blue:#1a56db;--red:#e74c3c;--green:#27ae60;--purple:#7c3aed;--gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;--sidebar-w:260px}
    body{font-family:'Inter',sans-serif;background:var(--gray-50);color:var(--gray-800);display:flex;min-height:100vh}
    a{color:inherit;text-decoration:none}

    /* Sidebar */
    .sidebar{width:var(--sidebar-w);background:var(--navy);min-height:100vh;position:fixed;left:0;top:0;z-index:200;display:flex;flex-direction:column;transition:transform .3s}
    .sidebar-logo{padding:24px 20px;border-bottom:1px solid rgba(255,255,255,.1)}
    .sidebar-logo h2{color:#fff;font-size:16px;font-weight:700;margin-bottom:2px}
    .sidebar-logo p{color:rgba(255,255,255,.5);font-size:12px}
    .sidebar-nav{flex:1;padding:16px 0;overflow-y:auto}
    .nav-group-label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:rgba(255,255,255,.4);padding:12px 20px 6px}
    .nav-item{display:flex;align-items:center;gap:12px;padding:12px 20px;color:rgba(255,255,255,.7);font-size:13px;font-weight:500;transition:all .2s;border-left:3px solid transparent}
    .nav-item:hover{background:rgba(255,255,255,.08);color:#fff;border-left-color:rgba(255,255,255,.3)}
    .nav-item.active{background:rgba(255,255,255,.12);color:#fff;border-left-color:var(--gold)}
    .nav-item i{width:18px;font-size:15px}
    .sidebar-footer{padding:16px 20px;border-top:1px solid rgba(255,255,255,.1)}
    .logout-btn{display:flex;align-items:center;gap:10px;width:100%;padding:10px 14px;background:rgba(231,76,60,.15);border:none;border-radius:8px;color:rgba(255,255,255,.8);font-size:13px;font-weight:500;cursor:pointer;transition:all .2s}
    .logout-btn:hover{background:rgba(231,76,60,.3);color:#fff}

    /* Main */
    .main{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column}
    .topbar{background:#fff;border-bottom:1px solid var(--gray-200);padding:16px 28px;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:100;box-shadow:0 1px 4px rgba(0,0,0,.06)}
    .topbar-title{font-size:20px;font-weight:700;color:var(--gray-800)}
    .topbar-user{display:flex;align-items:center;gap:10px;font-size:14px;color:var(--gray-600)}
    .topbar-avatar{width:36px;height:36px;border-radius:50%;background:var(--navy);color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700}
    .page-body{padding:28px;flex:1}

    /* Cards */
    .card{background:#fff;border-radius:12px;border:1.5px solid var(--gray-200);overflow:hidden;margin-bottom:20px}
    .card-head{padding:18px 24px;border-bottom:1px solid var(--gray-200);display:flex;justify-content:space-between;align-items:center}
    .card-title{font-size:15px;font-weight:700}
    .card-body{padding:24px}

    /* Flash */
    .flash{padding:12px 16px;margin-bottom:16px;border-radius:8px;border-left:4px solid;font-size:14px}
    .flash-success{background:#d4edda;border-color:var(--green);color:#155724}
    .flash-error{background:#f8d7da;border-color:var(--red);color:#721c24}

    /* Stats */
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;margin-bottom:24px}
    .stat-card{background:#fff;border-radius:12px;padding:20px;border:1.5px solid var(--gray-200);border-top:4px solid var(--blue)}
    .stat-num{font-size:28px;font-weight:800;color:var(--gray-800);margin-bottom:4px}
    .stat-label{font-size:12px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.5px}
    .stat-icon{font-size:20px;margin-bottom:10px}

    /* Table */
    .data-table{width:100%;border-collapse:collapse}
    .data-table th{padding:11px 14px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--gray-500);background:var(--gray-50);border-bottom:1.5px solid var(--gray-200)}
    .data-table td{padding:12px 14px;font-size:13px;border-bottom:1px solid var(--gray-100);vertical-align:middle}
    .data-table tbody tr:hover{background:var(--gray-50)}

    /* Badges */
    .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700}
    .badge-admin{background:#fee2e2;color:#991b1b}
    .badge-faculty{background:#dbeafe;color:#1e40af}
    .badge-student{background:#d1fae5;color:#065f46}
    .badge-active{background:#d1fae5;color:#065f46}
    .badge-inactive{background:#fee2e2;color:#991b1b}

    /* Buttons */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:7px;font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all .2s}
    .btn-sm{padding:5px 10px;font-size:11px}
    .btn-primary{background:var(--navy);color:#fff}
    .btn-primary:hover{background:#001630}
    .btn-success{background:var(--green);color:#fff}
    .btn-success:hover{background:#219150}
    .btn-danger{background:var(--red);color:#fff}
    .btn-danger:hover{background:#c0392b}
    .btn-warning{background:#f59e0b;color:#fff}
    .btn-info{background:var(--blue);color:#fff}
    .btn-outline{background:transparent;border:1.5px solid var(--gray-200);color:var(--gray-600)}
    .btn-outline:hover{border-color:var(--gray-400);color:var(--gray-800)}

    /* Modal */
    .modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:500;align-items:center;justify-content:center;padding:20px}
    .modal.open{display:flex}
    .modal-box{background:#fff;border-radius:12px;width:100%;max-width:560px;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.2)}
    .modal-head{padding:20px 24px;border-bottom:1px solid var(--gray-200);display:flex;justify-content:space-between;align-items:center}
    .modal-head h3{font-size:16px;font-weight:700}
    .modal-body{padding:24px}
    .modal-close{background:none;border:none;font-size:20px;cursor:pointer;color:var(--gray-400);line-height:1}
    .modal-close:hover{color:var(--gray-800)}

    /* Forms */
    .form-group{margin-bottom:18px}
    .form-label{display:block;font-size:13px;font-weight:600;color:var(--gray-700);margin-bottom:6px}
    .form-control{width:100%;padding:10px 12px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;transition:border-color .2s}
    .form-control:focus{border-color:var(--navy)}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <h2><i class="fas fa-graduation-cap" style="color:var(--gold)"></i> Admin Panel</h2>
        <p>ICV Polytechnic</p>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-group-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.analytics') }}" class="nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Analytics
        </a>
        <div class="nav-group-label" style="margin-top:8px">Management</div>
        <a href="{{ route('admin.materials') }}" class="nav-item {{ request()->routeIs('admin.materials') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Materials
        </a>
        <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Users
        </a>
        <a href="{{ route('admin.institutes') }}" class="nav-item {{ request()->routeIs('admin.institutes') ? 'active' : '' }}">
            <i class="fas fa-university"></i> Institutes
        </a>
        <a href="{{ route('admin.departments') }}" class="nav-item {{ request()->routeIs('admin.departments') ? 'active' : '' }}">
            <i class="fas fa-building"></i> Departments
        </a>
        <div class="nav-group-label" style="margin-top:8px">Site</div>
        <a href="{{ url('/') }}" class="nav-item" target="_blank">
            <i class="fas fa-external-link-alt"></i> View Site
        </a>
        <a href="{{ route('materials.index') }}" class="nav-item">
            <i class="fas fa-book-open"></i> Materials Portal
        </a>
    </nav>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Sign Out</button>
        </form>
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-user">
            <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div style="font-weight:600;color:var(--gray-800)">{{ auth()->user()->name }}</div>
                <div style="font-size:11px;color:var(--red)">Administrator</div>
            </div>
        </div>
    </header>

    <div class="page-body">
        @if(session('success'))<div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
        @if(session('error'))<div class="flash flash-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>@endif
        @if($errors->any())
        <div class="flash flash-error">
            @foreach($errors->all() as $e)<div><i class="fas fa-times-circle"></i> {{ $e }}</div>@endforeach
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
// Modal helpers
document.querySelectorAll('[data-modal]').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.modal;
        document.getElementById(id)?.classList.add('open');
    });
});
document.querySelectorAll('.modal-close, .modal-backdrop').forEach(el => {
    el.addEventListener('click', () => el.closest('.modal')?.classList.remove('open'));
});
document.querySelectorAll('.modal').forEach(m => {
    m.addEventListener('click', e => { if(e.target === m) m.classList.remove('open'); });
});
</script>
@stack('scripts')
</body>
</html>