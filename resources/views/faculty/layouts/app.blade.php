<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Faculty') — ICV E-Learning</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--accent:#4f46e5;--navy:#002147;--green:#27ae60;--red:#e74c3c;--gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;--sidebar-w:250px}
    body{font-family:'Inter',sans-serif;background:var(--gray-50);color:var(--gray-800);display:flex;min-height:100vh}
    a{color:inherit;text-decoration:none}
    .sidebar{width:var(--sidebar-w);background:linear-gradient(180deg,#4f46e5 0%,#7c3aed 100%);min-height:100vh;position:fixed;left:0;top:0;z-index:200;display:flex;flex-direction:column}
    .sidebar-logo{padding:24px 20px;border-bottom:1px solid rgba(255,255,255,.15)}
    .sidebar-logo h2{color:#fff;font-size:15px;font-weight:700}
    .sidebar-logo p{color:rgba(255,255,255,.5);font-size:11px}
    .sidebar-nav{flex:1;padding:12px 0}
    .nav-item{display:flex;align-items:center;gap:12px;padding:12px 20px;color:rgba(255,255,255,.7);font-size:13px;font-weight:500;transition:all .2s;border-left:3px solid transparent}
    .nav-item:hover,.nav-item.active{background:rgba(255,255,255,.12);color:#fff;border-left-color:#fff}
    .nav-item i{width:18px}
    .sidebar-footer{padding:16px 20px;border-top:1px solid rgba(255,255,255,.15)}
    .logout-btn{display:flex;align-items:center;gap:10px;width:100%;padding:10px;background:rgba(255,255,255,.1);border:none;border-radius:8px;color:rgba(255,255,255,.8);font-size:13px;cursor:pointer;transition:all .2s}
    .logout-btn:hover{background:rgba(231,76,60,.3);color:#fff}
    .main{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column}
    .topbar{background:#fff;border-bottom:1px solid var(--gray-200);padding:14px 24px;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:100}
    .topbar-title{font-size:18px;font-weight:700}
    .page-body{padding:24px;flex:1}
    .card{background:#fff;border-radius:12px;border:1.5px solid var(--gray-200);overflow:hidden;margin-bottom:20px}
    .card-head{padding:16px 20px;border-bottom:1px solid var(--gray-200);display:flex;justify-content:space-between;align-items:center}
    .card-title{font-size:15px;font-weight:700}
    .flash{padding:12px 16px;margin-bottom:16px;border-radius:8px;border-left:4px solid;font-size:14px}
    .flash-success{background:#d4edda;border-color:var(--green);color:#155724}
    .flash-error{background:#f8d7da;border-color:var(--red);color:#721c24}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;border:none;cursor:pointer;transition:all .2s}
    .btn-primary{background:var(--accent);color:#fff}
    .btn-primary:hover{background:#4338ca}
    .btn-danger{background:var(--red);color:#fff}
    .btn-danger:hover{background:#c0392b}
    .btn-outline{background:transparent;border:1.5px solid var(--gray-200);color:var(--gray-600)}
    .btn-outline:hover{border-color:var(--gray-400)}
    .data-table{width:100%;border-collapse:collapse}
    .data-table th{padding:10px 14px;text-align:left;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--gray-500);background:var(--gray-50);border-bottom:1.5px solid var(--gray-200)}
    .data-table td{padding:12px 14px;font-size:13px;border-bottom:1px solid var(--gray-100);vertical-align:middle}
    .data-table tbody tr:hover{background:var(--gray-50)}
    .form-group{margin-bottom:16px}
    .form-label{display:block;font-size:13px;font-weight:600;color:var(--gray-700);margin-bottom:5px}
    .form-control{width:100%;padding:10px 12px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;outline:none;transition:border-color .2s}
    .form-control:focus{border-color:var(--accent)}
    .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    .modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:500;align-items:center;justify-content:center;padding:20px}
    .modal.open{display:flex}
    .modal-box{background:#fff;border-radius:12px;width:100%;max-width:560px;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.2)}
    .modal-head{padding:18px 22px;border-bottom:1px solid var(--gray-200);display:flex;justify-content:space-between;align-items:center}
    .modal-head h3{font-size:15px;font-weight:700}
    .modal-body{padding:22px}
    .modal-close{background:none;border:none;font-size:20px;cursor:pointer;color:var(--gray-400)}
    .modal-close:hover{color:var(--gray-800)}
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-logo">
        <h2><i class="fas fa-chalkboard-teacher" style="color:#a5b4fc"></i> Faculty Panel</h2>
        <p>ICV Polytechnic</p>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('faculty.dashboard') }}" class="nav-item {{ request()->routeIs('faculty.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('faculty.materials.create') }}" class="nav-item {{ request()->routeIs('faculty.materials.create') ? 'active' : '' }}">
            <i class="fas fa-upload"></i> Upload Material
        </a>
        <a href="{{ route('materials.index') }}" class="nav-item">
            <i class="fas fa-book-open"></i> Browse Materials
        </a>
        <a href="{{ url('/') }}" class="nav-item">
            <i class="fas fa-home"></i> Back to Site
        </a>
    </nav>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Sign Out</button>
        </form>
    </div>
</aside>
<div class="main">
    <header class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div style="font-size:14px;color:var(--gray-600)">
            <i class="fas fa-user-circle" style="color:var(--accent)"></i> {{ auth()->user()->name }}
        </div>
    </header>
    <div class="page-body">
        @if(session('success'))<div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
        @if(session('error'))<div class="flash flash-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>@endif
        @if($errors->any())<div class="flash flash-error">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
        @yield('content')
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
document.querySelectorAll('[data-modal]').forEach(btn => {
    btn.addEventListener('click', () => document.getElementById(btn.dataset.modal)?.classList.add('open'));
});
document.querySelectorAll('.modal-close').forEach(el => {
    el.addEventListener('click', () => el.closest('.modal')?.classList.remove('open'));
});
document.querySelectorAll('.modal').forEach(m => {
    m.addEventListener('click', e => { if(e.target===m) m.classList.remove('open'); });
});
</script>
@stack('scripts')
</body>
</html>