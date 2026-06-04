@extends('layouts.app')
@section('title', $material->name . ' — ICV Polytechnic')

@push('styles')
<style>
.mat-page{max-width:900px;margin:40px auto;padding:0 20px}
.mat-header{background:var(--navy);border-radius:var(--radius-lg);padding:32px;margin-bottom:24px;color:#fff}
.mat-type-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:20px;font-size:12px;font-weight:700;text-transform:uppercase;margin-bottom:12px}
.mat-title{font-size:28px;font-weight:800;margin-bottom:12px;line-height:1.2}
.mat-header-meta{display:flex;flex-wrap:wrap;gap:16px}
.mat-header-meta span{font-size:13px;color:rgba(255,255,255,.7);display:flex;align-items:center;gap:6px}
.mat-body{display:grid;grid-template-columns:1fr 280px;gap:24px}
.mat-main-card{background:#fff;border-radius:var(--radius-lg);border:1.5px solid var(--gray-200);padding:28px}
.mat-sidebar{display:flex;flex-direction:column;gap:16px}
.sidebar-card{background:#fff;border-radius:var(--radius-lg);border:1.5px solid var(--gray-200);padding:20px}
.sidebar-title{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--gray-500);margin-bottom:14px}
.info-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--gray-100);font-size:14px}
.info-row:last-child{border-bottom:none}
.info-label{color:var(--gray-600)}
.info-value{font-weight:600;color:var(--gray-800)}
.dl-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:14px;background:var(--green);color:#fff;border:none;border-radius:var(--radius);font-size:15px;font-weight:700;cursor:pointer;transition:all .2s;text-decoration:none;margin-bottom:10px}
.dl-btn:hover{background:#219150;transform:translateY(-1px);box-shadow:0 4px 12px rgba(39,174,96,.3)}
.back-btn{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:10px;background:transparent;color:var(--gray-600);border:1.5px solid var(--gray-200);border-radius:var(--radius);font-size:14px;font-weight:500;cursor:pointer;transition:all .2s;text-decoration:none}
.back-btn:hover{border-color:var(--gray-400);color:var(--gray-800)}
@media(max-width:768px){.mat-body{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<div class="mat-page">
    <!-- Header -->
    <div class="mat-header">
        @php
            $badgeClass = match($material->material_type) {
                'study_material'         => 'background:#3b82f6;color:#fff',
                'previous_year_question' => 'background:#ec4899;color:#fff',
                'syllabus'               => 'background:#10b981;color:#fff',
                'assignment'             => 'background:#f59e0b;color:#fff',
                default                  => 'background:#6b7280;color:#fff',
            };
            $typeLabel = match($material->material_type) {
                'study_material'         => 'Study Material',
                'previous_year_question' => 'Previous Year Question',
                'syllabus'               => 'Syllabus',
                'assignment'             => 'Assignment',
                default                  => 'Other',
            };
        @endphp
        <div class="mat-type-badge" style="{{ $badgeClass }}">
            <i class="fas fa-tag"></i> {{ $typeLabel }}
        </div>
        <div class="mat-title">{{ $material->name }}</div>
        <div class="mat-header-meta">
            <span><i class="fas fa-university"></i> {{ $material->institute->name }}</span>
            <span><i class="fas fa-building"></i> {{ $material->department->name }}</span>
            <span><i class="fas fa-calendar"></i> Semester {{ $material->semester }}</span>
            <span><i class="fas fa-clock"></i> {{ $material->created_at->format('d M Y') }}</span>
        </div>
    </div>

    <div class="mat-body">
        <!-- Main -->
        <div class="mat-main-card">
            @if($material->description)
            <h3 style="font-size:16px;font-weight:700;margin-bottom:12px;color:var(--gray-800)">Description</h3>
            <p style="font-size:14px;color:var(--gray-600);line-height:1.7;margin-bottom:24px">{{ $material->description }}</p>
            <hr style="border:none;border-top:1px solid var(--gray-200);margin-bottom:24px">
            @endif

            <h3 style="font-size:16px;font-weight:700;margin-bottom:16px;color:var(--gray-800)">File Information</h3>
            <div>
                @if($material->file_name)
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-file"></i> File name</span>
                    <span class="info-value" style="max-width:260px;text-align:right;word-break:break-all">{{ $material->file_name }}</span>
                </div>
                @endif
                @if($material->file_size)
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-weight"></i> File size</span>
                    <span class="info-value">{{ $material->file_size_formatted }}</span>
                </div>
                @endif
                @if($material->file_type)
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-file-code"></i> File type</span>
                    <span class="info-value">{{ strtoupper(pathinfo($material->file_name, PATHINFO_EXTENSION)) }}</span>
                </div>
                @endif
                @if($material->drive_link)
                <div class="info-row">
                    <span class="info-label"><i class="fab fa-google-drive"></i> Drive link</span>
                    <a href="{{ $material->drive_link }}" target="_blank" class="info-value" style="color:var(--blue)">Open in Drive</a>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-user"></i> Uploaded by</span>
                    <span class="info-value">{{ $material->uploader->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-eye"></i> Views</span>
                    <span class="info-value">{{ number_format($material->views) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-download"></i> Downloads</span>
                    <span class="info-value">{{ number_format($material->downloads) }}</span>
                </div>
            </div>

            @auth
                @if(auth()->user()->isAdmin() || $material->uploaded_by === auth()->id())
                <hr style="border:none;border-top:1px solid var(--gray-200);margin:20px 0">
                <div style="display:flex;gap:12px">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.materials') : route('faculty.dashboard') }}"
                       style="padding:8px 16px;background:var(--blue);color:#fff;border-radius:var(--radius);font-size:13px;font-weight:600;display:inline-flex;align-items:center;gap:6px">
                        <i class="fas fa-edit"></i> Edit Material
                    </a>
                    <form action="{{ route('materials.destroy', $material) }}" method="POST"
                          onsubmit="return confirm('Delete this material permanently?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="padding:8px 16px;background:var(--red);color:#fff;border:none;border-radius:var(--radius);font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
                @endif
            @endauth
        </div>

        <!-- Sidebar -->
        <div class="mat-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-title">Download</div>
                <a href="{{ route('materials.download', $material) }}" class="dl-btn">
                    <i class="fas fa-download"></i> Download Now
                </a>
                @if($material->drive_link)
                <a href="{{ $material->drive_link }}" target="_blank" class="dl-btn" style="background:#4285f4">
                    <i class="fab fa-google-drive"></i> Open in Drive
                </a>
                @endif
                <a href="{{ route('materials.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Materials
                </a>
            </div>
            <div class="sidebar-card">
                <div class="sidebar-title">Details</div>
                <div class="info-row"><span class="info-label">Department</span><span class="info-value" style="font-size:13px">{{ $material->department->name }}</span></div>
                <div class="info-row"><span class="info-label">Semester</span><span class="info-value">{{ $material->semester }}</span></div>
                <div class="info-row"><span class="info-label">Type</span><span class="info-value" style="font-size:12px">{{ $typeLabel }}</span></div>
                <div class="info-row"><span class="info-label">Added</span><span class="info-value" style="font-size:12px">{{ $material->created_at->format('d M Y') }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection