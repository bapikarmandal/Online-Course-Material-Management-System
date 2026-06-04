<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ICV Polytechnic E-Learning Portal')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --navy:#002147;--gold:#f1c40f;--gold-dark:#d4ac0d;
            --blue:#1a56db;--red:#e74c3c;--green:#27ae60;
            --gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;
            --gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;
            --shadow-sm:0 1px 3px rgba(0,0,0,.08);
            --shadow-md:0 4px 12px rgba(0,0,0,.1);
            --shadow-lg:0 8px 24px rgba(0,0,0,.12);
            --radius:8px;--radius-lg:12px;
        }
        body{font-family:'Inter',sans-serif;background:var(--gray-50);color:var(--gray-800);line-height:1.6}
        a{color:inherit;text-decoration:none}

        /* Top utility bar */
        .util-bar{background:#d35400;color:#fff;font-size:12px;padding:6px 0}
        .util-bar .inner{max-width:1280px;margin:0 auto;padding:0 20px;display:flex;justify-content:space-between;align-items:center}

        /* Header */
        .site-header{background:#fff;border-bottom:3px solid var(--navy);box-shadow:var(--shadow-sm)}
        .site-header .inner{max-width:1280px;margin:0 auto;padding:12px 20px;display:flex;justify-content:space-between;align-items:center;gap:16px}
        .brand{display:flex;align-items:center;gap:14px}
        .brand img{height:70px;width:70px;object-fit:contain}
        .brand-text h1{font-size:18px;font-weight:700;color:var(--navy);line-height:1.2}
        .brand-text p{font-size:12px;color:var(--gray-600)}

        /* Navigation */
        .site-nav{background:var(--navy);position:sticky;top:0;z-index:100;box-shadow:0 2px 8px rgba(0,0,0,.2)}
        .site-nav .inner{max-width:1280px;margin:0 auto;padding:0 20px;display:flex;justify-content:space-between;align-items:center}
        .nav-links{display:flex}
        .nav-links a{color:#fff;padding:14px 18px;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.4px;transition:background .2s;display:flex;align-items:center;gap:6px}
        .nav-links a:hover,.nav-links a.active{background:rgba(255,255,255,.15)}
        .nav-links a.active{border-bottom:3px solid var(--gold)}
        .nav-auth{display:flex;align-items:center;gap:8px;padding:8px 0}
        .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;border-radius:var(--radius);font-size:13px;font-weight:600;border:none;cursor:pointer;transition:all .2s}
        .btn-gold{background:var(--gold);color:var(--navy)}
        .btn-gold:hover{background:var(--gold-dark)}
        .btn-outline{background:transparent;border:1.5px solid rgba(255,255,255,.5);color:#fff}
        .btn-outline:hover{background:rgba(255,255,255,.15);border-color:#fff}
        .btn-red{background:var(--red);color:#fff}
        .btn-red:hover{background:#c0392b}
        .btn-green{background:var(--green);color:#fff}
        .btn-green:hover{background:#219150}
        .btn-blue{background:var(--blue);color:#fff}
        .btn-blue:hover{background:#1643a3}

        /* User pill */
        .user-pill{display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.1);padding:6px 12px;border-radius:20px;color:#fff;font-size:13px}
        .user-pill i{color:var(--gold)}

        /* Flash messages */
        .flash{padding:14px 20px;margin:16px 0;border-radius:var(--radius);border-left:4px solid;font-size:14px}
        .flash-success{background:#d4edda;border-color:var(--green);color:#155724}
        .flash-error{background:#f8d7da;border-color:var(--red);color:#721c24}
        .flash-info{background:#d1ecf1;border-color:#17a2b8;color:#0c5460}

        /* Footer */
        .site-footer{background:#001a38;color:#9ca3af;padding:48px 0 24px;margin-top:auto}
        .site-footer .inner{max-width:1280px;margin:0 auto;padding:0 20px}
        .footer-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:32px;margin-bottom:32px}
        .footer-col h4{color:#fff;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:.8px;margin-bottom:16px;padding-bottom:8px;border-bottom:1px solid rgba(255,255,255,.1)}
        .footer-col p,.footer-col li{font-size:13px;line-height:1.8}
        .footer-col ul{list-style:none}
        .footer-col li a:hover{color:#fff}
        .footer-bottom{text-align:center;padding-top:24px;border-top:1px solid rgba(255,255,255,.1);font-size:12px}

        /* Page wrapper */
        .page-content{min-height:calc(100vh - 280px)}

        /* Responsive */
        @media(max-width:768px){
            .brand-text h1{font-size:15px}
            .nav-links a{padding:12px 10px;font-size:12px}
            .footer-grid{grid-template-columns:1fr 1fr}
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- Utility bar -->
<div class="util-bar">
    <div class="inner">
        <a href="{{ url('/') }}" style="color:rgba(255,255,255,.8);font-size:13px"><i class="fas fa-home"></i> Home</a>
        <span id="live-clock" style="font-weight:600"></span>
        <span><i class="fas fa-universal-access"></i> Screen Reader Access</span>
    </div>
</div>

<!-- Header -->
<header class="site-header">
    <div class="inner">
        <div class="brand">
            <img src="{{ asset('images/college-logo.png') }}" alt="ICV Polytechnic Logo"
                 onerror="this.src='https://via.placeholder.com/70?text=ICV'">
            <div class="brand-text">
                <h1>Iswar Chandra Vidyasagar Polytechnic</h1>
                <p>Govt. of West Bengal | WBSCTVESD Affiliated | AICTE Approved | Est. 1957</p>
            </div>
        </div>
        <div style="text-align:right;color:var(--gray-600);font-size:13px">
            <div style="font-weight:600;color:var(--navy)">E-Learning Portal</div>
            <div>Sevayatan, Jhargram, WB - 721514</div>
        </div>
    </div>
</header>

<!-- Navigation -->
<nav class="site-nav">
    <div class="inner">
        <div class="nav-links">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="{{ route('home') }}" class="{{ request()->is('home') || request()->is('admin/*') || request()->is('faculty/*') ? 'active' : '' }}">
                <i class="fas fa-laptop-code"></i> E-Learning
            </a>
            <a href="{{ route('materials.index') }}" class="{{ request()->routeIs('materials.*') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i> Study Materials
            </a>
        </div>
        <div class="nav-auth">
            @auth
                <div class="user-pill">
                    <i class="fas fa-user-circle"></i>
                    {{ Auth::user()->name }}
                    <span style="background:{{ Auth::user()->role === 'admin' ? '#e74c3c' : (Auth::user()->role === 'faculty' ? '#3498db' : '#27ae60') }};color:#fff;padding:2px 8px;border-radius:10px;font-size:11px">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-gold" style="padding:6px 14px;font-size:12px"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                @elseif(Auth::user()->isFaculty())
                    <a href="{{ route('faculty.dashboard') }}" class="btn btn-gold" style="padding:6px 14px;font-size:12px"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin:0">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="padding:6px 14px;font-size:12px"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-green" style="padding:6px 16px;font-size:12px"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline" style="padding:6px 16px;font-size:12px"><i class="fas fa-user-plus"></i> Register</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Flash Messages -->
<div style="max-width:1280px;margin:0 auto;padding:0 20px">
    @if(session('success'))
        <div class="flash flash-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="flash flash-error">
            @foreach($errors->all() as $e)<div><i class="fas fa-times-circle"></i> {{ $e }}</div>@endforeach
        </div>
    @endif
</div>

<!-- Main Content -->
<main class="page-content">
    @yield('content')
</main>

<!-- Footer -->
<footer class="site-footer">
    <div class="inner">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Contact</h4>
                <p>Iswar Chandra Vidyasagar Polytechnic<br>Sevayatan, Jhargram<br>West Bengal — 721514<br>
                <a href="mailto:icvp@wb.gov.in" style="color:var(--gold)">icvp@wb.gov.in</a></p>
            </div>
            <div class="footer-col">
                <h4>Departments</h4>
                <ul>
                    <li>Computer Science & Technology</li>
                    <li>Mechanical Engineering</li>
                    <li>Electrical Engineering</li>
                    <li>Civil Engineering</li>
                    <li>Metallurgical Engineering</li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('materials.index') }}">Study Materials</a></li>
                    <li><a href="{{ route('login') }}">Student Login</a></li>
                    <li><a href="{{ route('register') }}">New Registration</a></li>
                    <li><a href="#">WBSCTVESD</a></li>
                    <li><a href="#">AICTE</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>About Portal</h4>
                <p>The official digital repository for lecture notes, syllabi, previous year questions and academic resources for all departments.</p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Iswar Chandra Vidyasagar Polytechnic — Online Course Material Management System. All rights reserved.
        </div>
    </div>
</footer>

<script>
function tick() {
    const now = new Date();
    document.getElementById('live-clock').textContent =
        now.toLocaleDateString('en-IN', {weekday:'short',day:'2-digit',month:'short',year:'numeric'}) + ' ' +
        now.toLocaleTimeString('en-IN', {hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:false}) + ' IST';
}
setInterval(tick, 1000); tick();
</script>
@stack('scripts')
</body>
</html>