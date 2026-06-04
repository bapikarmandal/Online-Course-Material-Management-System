@extends('layouts.app')
@section('title', 'Dashboard — ICV Polytechnic')

@push('styles')
<style>
.dashboard-wrap{max-width:1280px;margin:0 auto;padding:32px 20px}
.welcome-banner{background:linear-gradient(135deg,var(--navy) 0%,#003580 100%);border-radius:var(--radius-lg);padding:32px 40px;margin-bottom:28px;color:#fff;display:flex;justify-content:space-between;align-items:center}
.welcome-title{font-size:26px;font-weight:800;margin-bottom:6px}
.welcome-sub{font-size:14px;color:rgba(255,255,255,.7)}
.role-badge{padding:6px 16px;border-radius:20px;font-size:12px;font-weight:700;text-transform:uppercase}
.quick-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:28px}
.quick-card{background:#fff;border-radius:var(--radius-lg);border:1.5px solid var(--gray-200);padding:24px;transition:all .25s;border-top:4px solid var(--blue)}
.quick-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-lg)}
.qc-icon{width:48px;height:48px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:14px}
.qc-title{font-size:15px;font-weight:700;color:var(--gray-800);margin-bottom:6px}
.qc-desc{font-size:13px;color:var(--gray-600);margin-bottom:16px;line-height:1.5}
.qc-link{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius);font-size:13px;font-weight:600;border:1.5px solid currentColor;transition:all .2s}
.activity-card{background:#fff;border-radius:var(--radius-lg);border:1.5px solid var(--gray-200);overflow:hidden}
.activity-head{padding:18px 24px;border-bottom:1px solid var(--gray-200);font-size:15px;font-weight:700;color:var(--gray-800)}
.activity-body{padding:40px;text-align:center;color:var(--gray-400)}
.activity-icon{font-size:48px;margin-bottom:16px}
@media(max-width:768px){.quick-grid{grid-template-columns:1fr}.welcome-banner{flex-direction:column;gap:12px;text-align:center}}
</style>
@endpush

@section('content')
<div class="dashboard-wrap">
    <div class="welcome-banner">
        <div>
            <div class="welcome-title">Welcome back, {{ Auth::user()->name }}! 👋</div>
            <div class="welcome-sub">Access your study materials and stay on top of your academics.</div>
        </div>
        <div>
            <span class="role-badge" style="background:rgba(241,196,15,.15);border:1px solid var(--gold);color:var(--gold)">
                <i class="fas fa-user-graduate"></i> Student Account
            </span>
        </div>
    </div>

    <div class="quick-grid">
        <div class="quick-card" style="border-top-color:#1a56db">
            <div class="qc-icon" style="background:#dbeafe;color:#1a56db"><i class="fas fa-book-open"></i></div>
            <div class="qc-title">Study Materials</div>
            <div class="qc-desc">Browse lecture notes, assignments, and lab manuals organized by department and semester.</div>
            <a href="{{ route('materials.index') }}" class="qc-link" style="color:#1a56db">Browse Files <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="quick-card" style="border-top-color:#10b981">
            <div class="qc-icon" style="background:#d1fae5;color:#10b981"><i class="fas fa-file-alt"></i></div>
            <div class="qc-title">Previous Year Questions</div>
            <div class="qc-desc">Access previous year exam papers to help prepare for your upcoming examinations.</div>
            <a href="{{ route('materials.index', ['material_type' => 'previous_year_question']) }}" class="qc-link" style="color:#10b981">View PYQs <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="quick-card" style="border-top-color:#8b5cf6">
            <div class="qc-icon" style="background:#ede9fe;color:#8b5cf6"><i class="fas fa-list-alt"></i></div>
            <div class="qc-title">Syllabus</div>
            <div class="qc-desc">View the complete syllabus for all departments and semesters in one place.</div>
            <a href="{{ route('materials.index', ['material_type' => 'syllabus']) }}" class="qc-link" style="color:#8b5cf6">View Syllabus <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="activity-card">
        <div class="activity-head"><i class="fas fa-history" style="color:var(--gray-400)"></i> Recent Activity</div>
        <div class="activity-body">
            <div class="activity-icon">📋</div>
            <div style="font-size:16px;font-weight:600;margin-bottom:8px;color:var(--gray-600)">No recent activity yet</div>
            <div style="font-size:14px;margin-bottom:20px">Start browsing materials to see your activity here.</div>
            <a href="{{ route('materials.index') }}" class="btn btn-blue" style="padding:10px 24px">
                <i class="fas fa-search"></i> Find Materials
            </a>
        </div>
    </div>
</div>
@endsection