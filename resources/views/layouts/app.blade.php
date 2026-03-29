<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Iswar Chandra Vidyasagar Polytechnic')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Navigation Links */
        .nav-link { 
            padding: 16px 24px; 
            display: inline-block; 
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
            color: white;
            text-transform: uppercase;
            transition: all 0.2s;
        }
        .nav-link:hover { background-color: #003366; }
        
        /* The Yellow Active Box */
        .active-yellow {
            background-color: #f1c40f !important;
            color: #002147 !important; 
        }
        
        /* Buttons */
        .btn-custom { padding: 8px 20px; border-radius: 4px; font-size: 13px; font-weight: 700; text-transform: uppercase; transition: 0.3s; color: white; }
        .btn-login { background-color: #27ae60; } 
        .btn-login:hover { background-color: #219150; }
        .btn-register { background-color: #2980b9; } 
        .btn-register:hover { background-color: #2471a3; }
        .btn-logout { background-color: #c0392b; } 
        .btn-logout:hover { background-color: #a93226; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <div class="bg-[#d35400] text-white text-xs py-2 relative z-50">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="hover:text-gray-200 text-base"><i class="fas fa-home"></i></a>
            <div id="live-clock" class="font-bold tracking-wide hidden sm:block">Loading...</div>
            <div class="flex items-center gap-2 font-medium">
                <i class="fas fa-volume-up"></i> <span class="hidden sm:inline">Screen Reader Access</span>
            </div>
        </div>
    </div>

    <div class="bg-white py-4 border-b-4 border-[#002147] relative z-40">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-[#002147] font-bold text-center md:text-right w-full md:w-1/3 leading-snug">
                <h2 class="text-lg">পশ্চিমবঙ্গ সরকার</h2>
                <h3 class="text-sm">কারিগরি শিক্ষা ও প্রশিক্ষণ বিভাগ</h3>
                <div class="hidden md:block w-full h-0.5 bg-[#002147] mt-1 ml-auto"></div>
            </div>
            <div class="flex-shrink-0">
                <img src="{{ asset('images/college-logo.png') }}" alt="Logo" class="h-24 w-24 object-contain" onerror="this.src='https://via.placeholder.com/100?text=Logo'">
            </div>
            <div class="text-[#002147] font-bold text-center md:text-left w-full md:w-1/3 leading-snug">
                <h1 class="text-xl md:text-2xl uppercase tracking-tight">Iswar Chandra Vidyasagar <br> Polytechnic</h1>
                <p class="text-sm font-semibold text-gray-600">Jhargram, West Bengal</p>
                <div class="hidden md:block w-full h-0.5 bg-[#002147] mt-1 mr-auto"></div>
            </div>
        </div>
    </div>

    <div class="bg-[#002147] text-white shadow-lg sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div class="flex">
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active-yellow' : '' }}">HOME</a>
                <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') || request()->is('admin/*') || request()->is('faculty/*') ? 'active-yellow' : '' }}">E-LEARNING</a>
                <a href="{{ route('materials.index') }}" class="nav-link {{ request()->routeIs('materials.*') ? 'active-yellow' : '' }}">STUDY MATERIALS</a>
            </div>
            <div class="flex items-center gap-3 py-2">
                @if (Route::has('login'))
                    @auth
                        <div class="flex items-center gap-3 bg-[#001a38] px-4 py-1 rounded">
                            <i class="fas fa-user text-yellow-400"></i>
                            <span class="text-white text-xs font-bold uppercase">{{ Auth::user()->name }}</span>
                        </div>
                        @php
                            $dash = 'home';
                            if(Auth::user()->role === 'admin') $dash = 'admin.dashboard';
                            elseif(Auth::user()->role === 'faculty') $dash = 'faculty.dashboard';
                        @endphp
                        <a href="{{ route($dash) }}" class="btn-custom bg-blue-500 hover:bg-blue-600">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-custom btn-logout">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-custom btn-login">LOGIN</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-custom btn-register">REGISTER</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-[#00152e] text-gray-400 py-8 border-t-4 border-[#d35400] mt-auto">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
            <div>
                <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-widest border-b border-gray-700 pb-2">Contact Us</h4>
                <p class="leading-relaxed">Iswar Chandra Vidyasagar Polytechnic<br>Sevsyatan, Jhargram<br>West Bengal, Pin-721514</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-widest border-b border-gray-700 pb-2">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white transition"><i class="fas fa-angle-right mr-2"></i>WBSCTVESD</a></li>
                    <li><a href="#" class="hover:text-white transition"><i class="fas fa-angle-right mr-2"></i>AICTE</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-4 uppercase text-xs tracking-widest border-b border-gray-700 pb-2">About Portal</h4>
                <p class="leading-relaxed">The official central repository for lecture notes, syllabus, and academic resources.</p>
            </div>
        </div>
        <div class="text-center pt-8 mt-8 border-t border-gray-800 text-xs">
            &copy; {{ date('Y') }} Online Course Material Management System. All Rights Reserved.
        </div>
    </footer>

    <script>
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('live-clock').innerText = now.toLocaleDateString('en-US', options) + " IST";
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>