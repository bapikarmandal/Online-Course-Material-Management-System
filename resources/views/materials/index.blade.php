@extends('layouts.app')
@section('title', 'Study Materials — ICV Polytechnic')

@push('styles')
<style>
.page-hero{background:var(--navy);padding:48px 20px;text-align:center}
.page-hero h1{color:#fff;font-size:36px;font-weight:800;margin-bottom:8px}
.page-hero p{color:rgba(255,255,255,.7);font-size:16px}

.filter-section{background:#fff;border-bottom:1px solid var(--gray-200);box-shadow:var(--shadow-sm);position:sticky;top:60px;z-index:90}
.filter-inner{max-width:1280px;margin:0 auto;padding:20px}
.filter-form{display:grid;grid-template-columns:1fr 1fr 120px 180px auto;gap:12px;align-items:end}
.filter-label{font-size:12px;font-weight:600;color:var(--gray-600);margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px}
.filter-select,.filter-input{width:100%;padding:10px 12px;border:1.5px solid var(--gray-200);border-radius:var(--radius);font-size:13px;outline:none;transition:border-color .2s}
.filter-select:focus,.filter-input:focus{border-color:var(--navy)}
.filter-btn{padding:10px 20px;background:var(--navy);color:#fff;border:none;border-radius:var(--radius);font-size:13px;font-weight:600;cursor:pointer;white-space:nowrap}
.filter-btn:hover{background:#001630}
.clear-btn{padding:10px;background:transparent;color:var(--gray-600);border:1.5px solid var(--gray-200);border-radius:var(--radius);font-size:13px;cursor:pointer}

.results-info{max-width:1280px;margin:0 auto;padding:16px 20px;display:flex;justify-content:space-between;align-items:center}
.results-count{font-size:14px;color:var(--gray-600)}
.results-count span{font-weight:700;color:var(--gray-800)}

.materials-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;max-width:1280px;margin:0 auto;padding:0 20px 40px}

.mat-card{background:#fff;border-radius:var(--radius-lg);border:1.5px solid var(--gray-200);overflow:hidden;transition:all .25s;display:flex;flex-direction:column}
.mat-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-lg);border-color:var(--blue)}
.mat-card-top{padding:20px;flex:1}
.mat-type-badge{display:inline-flex;align-items:center;gap:6px;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px}
.mat-name{font-size:16px;font-weight:700;color:var(--gray-800);margin-bottom:10px;line-height:1.3}
.mat-meta{display:flex;flex-direction:column;gap:5px;margin-bottom:12px}
.mat-meta-item{font-size:12px;color:var(--gray-600);display:flex;align-items:center;gap:6px}
.mat-meta-item i{width:14px;color:var(--gray-400)}
.mat-desc{font-size:13px;color:var(--gray-600);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.mat-card-foot{padding:14px 20px;border-top:1px solid var(--gray-100);display:flex;justify-content:space-between;align-items:center;background:var(--gray-50)}
.mat-stats{display:flex;gap:16px}
.mat-stat{font-size:12px;color:var(--gray-500);display:flex;align-items:center;gap:4px}
.mat-actions{display:flex;gap:8px}
.mat-btn{padding:7px 14px;border-radius:6px;font-size:12px;font-weight:600;border:none;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:4px}
.mat-btn-view{background:var(--blue);color:#fff}
.mat-btn-view:hover{background:#1643a3}
.mat-btn-dl{background:var(--green);color:#fff}
.mat-btn-dl:hover{background:#219150}

.empty-state{text-align:center;padding:80px 20px;max-width:400px;margin:0 auto}
.empty-icon{font-size:64px;margin-bottom:20px;opacity:.3}
.empty-title{font-size:20px;font-weight:700;color:var(--gray-700);margin-bottom:8px}
.empty-sub{font-size:14px;color:var(--gray-500)}

/* Type badge colors */
.badge-study{background:#dbeafe;color:#1e40af}
.badge-pyq{background:#fce7f3;color:#9d174d}
.badge-syllabus{background:#d1fae5;color:#065f46}
.badge-assignment{background:#fef3c7;color:#92400e}
.badge-other{background:#f1f5f9;color:#475569}

@media(max-width:900px){
    .filter-form{grid-template-columns:1fr 1fr;gap:10px}
    .filter-btn{grid-column:span 2}
}
@media(max-width:600px){
    .filter-form{grid-template-columns:1fr}
    .filter-btn{grid-column:1}
}
</style>
@endpush

@section('content')

<div class="page-hero">
    <h1><i class="fas fa-book-open" style="color:var(--gold)"></i> Study Materials</h1>
    <p>Browse and download study materials, previous year questions, syllabi and more</p>
</div>

<!-- Filters -->
<div class="filter-section">
    <div class="filter-inner">
        <form method="GET" action="{{ route('materials.index') }}" id="filterForm" class="filter-form">
            <div>
                <div class="filter-label">Search</div>
                <input type="text" name="search" value="{{ request('search') }}" class="filter-input" placeholder="Search by name...">
            </div>
            <div>
                <div class="filter-label">Department</div>
                <select name="department_id" id="dept-filter" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Departments</option>
                    @foreach($institutes as $inst)
                        @foreach($inst->departments as $dept)
                            <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div>
                <div class="filter-label">Semester</div>
                <select name="semester" class="filter-select" onchange="this.form.submit()">
                    <option value="">All</option>
                    @for($i=1;$i<=6;$i++)
                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Sem {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <div class="filter-label">Material Type</div>
                <select name="material_type" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    @foreach($materialTypes as $val => $label)
                        <option value="{{ $val }}" {{ request('material_type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex;gap:8px">
                <button type="submit" class="filter-btn"><i class="fas fa-search"></i> Search</button>
                <a href="{{ route('materials.index') }}" class="clear-btn" title="Clear filters"><i class="fas fa-times"></i></a>
            </div>
        </form>
    </div>
</div>

<!-- Results info -->
<div class="results-info">
    <div class="results-count">
        Showing <span>{{ $materials->firstItem() ?? 0 }}–{{ $materials->lastItem() ?? 0 }}</span> of
        <span>{{ $materials->total() }}</span> materials
    </div>
    @auth
        @if(auth()->user()->isFaculty() || auth()->user()->isAdmin())
            <a href="{{ route('faculty.materials.create') }}" class="btn btn-blue" style="font-size:13px;padding:8px 16px">
                <i class="fas fa-upload"></i> Upload Material
            </a>
        @endif
    @endauth
</div>

<!-- Grid -->
@if($materials->count())
<div class="materials-grid">
    @foreach($materials as $m)
    @php
        $badgeClass = match($m->material_type) {
            'study_material'         => 'badge-study',
            'previous_year_question' => 'badge-pyq',
            'syllabus'               => 'badge-syllabus',
            'assignment'             => 'badge-assignment',
            default                  => 'badge-other',
        };
        $badgeLabel = $materialTypes[$m->material_type] ?? 'Other';
        $badgeIcon = match($m->material_type) {
            'study_material'         => 'fas fa-book',
            'previous_year_question' => 'fas fa-file-alt',
            'syllabus'               => 'fas fa-list-alt',
            'assignment'             => 'fas fa-tasks',
            default                  => 'fas fa-file',
        };
    @endphp
    <div class="mat-card">
        <div class="mat-card-top">
            <div class="mat-type-badge {{ $badgeClass }}">
                <i class="{{ $badgeIcon }}"></i> {{ $badgeLabel }}
            </div>
            <div class="mat-name">{{ $m->name }}</div>
            <div class="mat-meta">
                <div class="mat-meta-item"><i class="fas fa-university"></i>{{ $m->institute->name }}</div>
                <div class="mat-meta-item"><i class="fas fa-building"></i>{{ $m->department->name }}</div>
                <div class="mat-meta-item"><i class="fas fa-calendar"></i>Semester {{ $m->semester }}</div>
                <div class="mat-meta-item"><i class="fas fa-user"></i>{{ $m->uploader->name }}</div>
            </div>
            @if($m->description)
            <div class="mat-desc">{{ $m->description }}</div>
            @endif
        </div>
        <div class="mat-card-foot">
            <div class="mat-stats">
                <span class="mat-stat"><i class="fas fa-eye"></i>{{ $m->views }}</span>
                <span class="mat-stat"><i class="fas fa-download"></i>{{ $m->downloads }}</span>
            </div>
            <div class="mat-actions">
                <a href="{{ route('materials.show', $m) }}" class="mat-btn mat-btn-view">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="{{ route('materials.download', $m) }}" class="mat-btn mat-btn-dl">
                    <i class="fas fa-download"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div style="max-width:1280px;margin:0 auto;padding:0 20px 40px;display:flex;justify-content:center">
    {{ $materials->withQueryString()->links() }}
</div>

@else
<div class="empty-state">
    <div class="empty-icon">📚</div>
    <div class="empty-title">No materials found</div>
    <div class="empty-sub">Try adjusting your filters or search terms. Check back later for new uploads.</div>
    <a href="{{ route('materials.index') }}" class="btn btn-blue" style="margin-top:20px;padding:10px 24px">Clear All Filters</a>
</div>
@endif

@endsection