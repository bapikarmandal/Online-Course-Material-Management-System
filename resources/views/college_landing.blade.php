@extends('layouts.app')
@section('title', 'Welcome — ICV Polytechnic E-Learning Portal')

@push('styles')
<style>
.hero{position:relative;background:var(--navy);min-height:580px;display:flex;align-items:center;overflow:hidden}
.hero-bg{position:absolute;inset:0;background:url('/images/college-building.jpg') center/cover no-repeat;opacity:.2}
.hero-content{position:relative;z-index:1;max-width:1280px;margin:0 auto;padding:80px 20px;text-align:center;width:100%}
.hero-badge{display:inline-block;background:rgba(241,196,15,.15);border:1px solid var(--gold);color:var(--gold);padding:6px 16px;border-radius:20px;font-size:12px;font-weight:600;letter-spacing:1px;text-transform:uppercase;margin-bottom:20px}
.hero-title{font-size:clamp(32px,5vw,60px);font-weight:800;color:#fff;line-height:1.1;margin-bottom:16px}
.hero-title span{color:var(--gold)}
.hero-sub{font-size:18px;color:rgba(255,255,255,.75);max-width:640px;margin:0 auto 40px;line-height:1.7}
.hero-ctas{display:flex;gap:16px;justify-content:center;flex-wrap:wrap}
.hero-cta-primary{background:var(--gold);color:var(--navy);padding:16px 36px;border-radius:var(--radius);font-size:16px;font-weight:700;transition:all .2s;display:flex;align-items:center;gap:10px}
.hero-cta-primary:hover{background:var(--gold-dark);transform:translateY(-2px);box-shadow:0 8px 24px rgba(241,196,15,.3)}
.hero-cta-secondary{background:transparent;border:2px solid rgba(255,255,255,.4);color:#fff;padding:16px 36px;border-radius:var(--radius);font-size:16px;font-weight:600;transition:all .2s;display:flex;align-items:center;gap:10px}
.hero-cta-secondary:hover{border-color:#fff;background:rgba(255,255,255,.1)}

.stats-bar{background:#fff;border-bottom:1px solid var(--gray-200);box-shadow:var(--shadow-sm)}
.stats-bar .inner{max-width:1280px;margin:0 auto;padding:28px 20px;display:grid;grid-template-columns:repeat(4,1fr);gap:0;text-align:center}
.stat-item{padding:8px 0;border-right:1px solid var(--gray-200)}
.stat-item:last-child{border-right:none}
.stat-num{font-size:36px;font-weight:800;color:var(--navy)}
.stat-label{font-size:12px;font-weight:600;color:var(--gray-600);text-transform:uppercase;letter-spacing:.8px;margin-top:4px}

.section{padding:80px 20px}
.section-inner{max-width:1280px;margin:0 auto}
.section-header{text-align:center;margin-bottom:56px}
.section-eyebrow{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;color:var(--blue);margin-bottom:10px}
.section-title{font-size:clamp(28px,3.5vw,40px);font-weight:800;color:var(--gray-800);margin-bottom:16px}
.section-sub{font-size:16px;color:var(--gray-600);max-width:560px;margin:0 auto}

/* Department cards */
.dept-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px}
.dept-card{background:#fff;border:1.5px solid var(--gray-200);border-radius:var(--radius-lg);padding:28px 20px;text-align:center;transition:all .25s;cursor:pointer;border-top:4px solid var(--navy)}
.dept-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-lg);border-top-color:var(--gold)}
.dept-icon{width:52px;height:52px;border-radius:12px;background:var(--gray-100);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;color:var(--navy)}
.dept-name{font-size:14px;font-weight:700;color:var(--gray-800);margin-bottom:6px}
.dept-sem{font-size:12px;color:var(--gray-600)}

/* Feature section */
.feature-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px}
.feature-card{background:#fff;border-radius:var(--radius-lg);padding:32px;border:1.5px solid var(--gray-200);transition:all .25s}
.feature-card:hover{border-color:var(--blue);box-shadow:var(--shadow-md)}
.feature-icon{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:16px;color:#fff}
.feature-title{font-size:16px;font-weight:700;color:var(--gray-800);margin-bottom:8px}
.feature-desc{font-size:14px;color:var(--gray-600);line-height:1.7}

/* Campus section */
.campus-grid{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center}
.campus-img{border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3}
.campus-img img{width:100%;height:100%;object-fit:cover}
.campus-features{display:flex;flex-direction:column;gap:24px}
.campus-feature{display:flex;gap:16px;align-items:flex-start}
.cf-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.cf-title{font-size:15px;font-weight:700;color:var(--gray-800);margin-bottom:4px}
.cf-desc{font-size:14px;color:var(--gray-600)}

@media(max-width:768px){
    .stats-bar .inner{grid-template-columns:1fr 1fr}
    .campus-grid{grid-template-columns:1fr}
    .dept-grid{grid-template-columns:repeat(2,1fr)}
}
</style>
@endpush

@section('content')

<!-- Hero -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <div class="hero-badge"><i class="fas fa-star"></i> Est. 1957 — A Legacy of Excellence</div>
        <h1 class="hero-title">
            Iswar Chandra Vidyasagar<br><span>Polytechnic</span>
        </h1>
        <p class="hero-sub">
            Premier Government Polytechnic, Jhargram, West Bengal. Affiliated with WBSCTVESD and approved by AICTE.
            Access all your study materials, question papers, and syllabi in one place.
        </p>
        <div class="hero-ctas">
            <a href="{{ route('home') }}" class="hero-cta-primary">
                <i class="fas fa-graduation-cap"></i> Enter E-Learning Portal
            </a>
            <a href="{{ route('materials.index') }}" class="hero-cta-secondary">
                <i class="fas fa-book-open"></i> Browse Study Materials
            </a>
        </div>
    </div>
</section>

<!-- Stats -->
<div class="stats-bar">
    <div class="inner">
        <div class="stat-item">
            <div class="stat-num" id="mat-count">{{ \App\Models\Material::count() }}</div>
            <div class="stat-label">Study Materials</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">5</div>
            <div class="stat-label">Departments</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">6</div>
            <div class="stat-label">Semesters</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">1957</div>
            <div class="stat-label">Established</div>
        </div>
    </div>
</div>

<!-- Departments -->
<section class="section" style="background:#fff">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-eyebrow">Academics</div>
            <h2 class="section-title">Engineering Disciplines</h2>
            <p class="section-sub">Five specialized departments with comprehensive 6-semester programs</p>
        </div>
        <div class="dept-grid">
            @foreach([
                ['icon'=>'fas fa-laptop-code','name'=>'Computer Science & Technology','code'=>'CST'],
                ['icon'=>'fas fa-cogs','name'=>'Mechanical Engineering','code'=>'ME'],
                ['icon'=>'fas fa-bolt','name'=>'Electrical Engineering','code'=>'EE'],
                ['icon'=>'fas fa-building','name'=>'Civil Engineering','code'=>'CE'],
                ['icon'=>'fas fa-flask','name'=>'Metallurgical Engineering','code'=>'MT'],
            ] as $dept)
            <a href="{{ route('materials.index', ['search' => $dept['name']]) }}" class="dept-card">
                <div class="dept-icon"><i class="{{ $dept['icon'] }}"></i></div>
                <div class="dept-name">{{ $dept['name'] }}</div>
                <div class="dept-sem">6 Semesters · {{ $dept['code'] }}</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Features -->
<section class="section" style="background:var(--gray-50)">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-eyebrow">Platform Features</div>
            <h2 class="section-title">Everything You Need</h2>
            <p class="section-sub">A complete digital learning ecosystem for students and faculty</p>
        </div>
        <div class="feature-grid">
            @foreach([
                ['icon'=>'fas fa-search','color'=>'#1a56db','bg'=>'#1a56db','title'=>'Smart Search & Filter','desc'=>'Filter materials by department, semester, year, and material type instantly.'],
                ['icon'=>'fas fa-upload','color'=>'#27ae60','bg'=>'#27ae60','title'=>'Easy Upload','desc'=>'Faculty can upload PDFs, DOCs, PPTs, images, videos, or share Google Drive links.'],
                ['icon'=>'fas fa-download','color'=>'#8b5cf6','bg'=>'#8b5cf6','title'=>'Instant Download','desc'=>'Students can download or stream study materials with one click from any device.'],
                ['icon'=>'fas fa-shield-alt','color'=>'#e74c3c','bg'=>'#e74c3c','title'=>'Secure Access','desc'=>'Role-based access control with separate portals for admin, faculty, and students.'],
                ['icon'=>'fas fa-chart-bar','color'=>'#f59e0b','bg'=>'#f59e0b','title'=>'Analytics Dashboard','desc'=>'Admins track downloads, views, and material popularity in real time.'],
                ['icon'=>'fas fa-mobile-alt','color'=>'#10b981','bg'=>'#10b981','title'=>'Mobile Friendly','desc'=>'Fully responsive design — access the portal from any smartphone or tablet.'],
            ] as $f)
            <div class="feature-card">
                <div class="feature-icon" style="background:{{ $f['bg'] }}"><i class="{{ $f['icon'] }}"></i></div>
                <div class="feature-title">{{ $f['title'] }}</div>
                <div class="feature-desc">{{ $f['desc'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Campus -->
<section class="section" style="background:#fff">
    <div class="section-inner">
        <div class="section-header">
            <div class="section-eyebrow">Campus Life</div>
            <h2 class="section-title">Life at ICV Polytechnic</h2>
        </div>
        <div class="campus-grid">
            <div class="campus-img">
                <img src="/images/campus-life.jpg" alt="Campus" onerror="this.src='https://via.placeholder.com/600x400?text=ICV+Campus'">
            </div>
            <div class="campus-features">
                @foreach([
                    ['icon'=>'fas fa-bed','color'=>'#1a56db','title'=>'Student Hostels','desc'=>'3 Boys\' Hostels and 1 Girls\' Hostel with all necessary amenities on campus.'],
                    ['icon'=>'fas fa-book','color'=>'#27ae60','title'=>'Central Library','desc'=>'Over 23,000 books, journals, and digital resources for academic research.'],
                    ['icon'=>'fas fa-wifi','color'=>'#8b5cf6','title'=>'Wi-Fi Campus','desc'=>'Fully Wi-Fi enabled campus with modern computer labs for digital learning.'],
                    ['icon'=>'fas fa-tree','color'=>'#10b981','title'=>'30-Acre Green Campus','desc'=>'Lush green surroundings providing a peaceful learning environment.'],
                ] as $cf)
                <div class="campus-feature">
                    <div class="cf-icon" style="background:{{ $cf['color'] }}15;color:{{ $cf['color'] }}"><i class="{{ $cf['icon'] }}"></i></div>
                    <div>
                        <div class="cf-title">{{ $cf['title'] }}</div>
                        <div class="cf-desc">{{ $cf['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section style="background:var(--navy);padding:80px 20px;text-align:center">
    <div style="max-width:600px;margin:0 auto">
        <h2 style="color:#fff;font-size:32px;font-weight:800;margin-bottom:16px">Ready to Access Your Materials?</h2>
        <p style="color:rgba(255,255,255,.7);margin-bottom:32px;font-size:16px">Join thousands of students already using the portal to excel in their studies.</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
            <a href="{{ route('register') }}" class="btn btn-gold" style="padding:14px 32px;font-size:15px"><i class="fas fa-user-plus"></i> Create Account</a>
            <a href="{{ route('materials.index') }}" class="btn btn-outline" style="padding:14px 32px;font-size:15px"><i class="fas fa-eye"></i> Browse Without Login</a>
        </div>
    </div>
</section>

@endsection