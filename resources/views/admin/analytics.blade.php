@extends('layouts.admin')
@section('title', 'Analytics')
@section('page-title', 'Analytics & Reports')

@section('content')

<div style="margin-bottom:24px">
    <h2 style="font-size:20px;font-weight:700;color:var(--gray-800);margin-bottom:8px">System Analytics</h2>
    <p style="font-size:14px;color:var(--gray-600)">Overview of downloads, materials, and user activity</p>
</div>

<!-- Stats Cards -->
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px">
    @php
        $totalDownloads = $data['downloads_by_month']->sum('count');
        $totalMaterials = $data['top_materials']->count();
        $totalUsers = $data['users_by_role']->sum('count');
        $totalDepts = $data['downloads_by_dept']->count();
    @endphp
    
    <div style="background:#fff;border-radius:12px;padding:20px;border:1.5px solid var(--gray-200);border-top:4px solid var(--blue)">
        <div style="font-size:20px;color:var(--blue);margin-bottom:8px"><i class="fas fa-download"></i></div>
        <div style="font-size:28px;font-weight:800;color:var(--gray-800);margin-bottom:4px">{{ number_format($totalDownloads) }}</div>
        <div style="font-size:12px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.5px">Total Downloads</div>
    </div>
    
    <div style="background:#fff;border-radius:12px;padding:20px;border:1.5px solid var(--gray-200);border-top:4px solid var(--green)">
        <div style="font-size:20px;color:var(--green);margin-bottom:8px"><i class="fas fa-book"></i></div>
        <div style="font-size:28px;font-weight:800;color:var(--gray-800);margin-bottom:4px">{{ number_format($data['downloads_by_dept']->sum('materials_count')) }}</div>
        <div style="font-size:12px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.5px">Total Materials</div>
    </div>
    
    <div style="background:#fff;border-radius:12px;padding:20px;border:1.5px solid var(--gray-200);border-top:4px solid var(--purple)">
        <div style="font-size:20px;color:var(--purple);margin-bottom:8px"><i class="fas fa-users"></i></div>
        <div style="font-size:28px;font-weight:800;color:var(--gray-800);margin-bottom:4px">{{ number_format($totalUsers) }}</div>
        <div style="font-size:12px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.5px">Total Users</div>
    </div>
    
    <div style="background:#fff;border-radius:12px;padding:20px;border:1.5px solid var(--gray-200);border-top:4px solid var(--gold)">
        <div style="font-size:20px;color:var(--gold);margin-bottom:8px"><i class="fas fa-building"></i></div>
        <div style="font-size:28px;font-weight:800;color:var(--gray-800);margin-bottom:4px">{{ number_format($totalDepts) }}</div>
        <div style="font-size:12px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.5px">Departments</div>
    </div>
</div>

<!-- Charts Grid -->
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px">
    
    <!-- Downloads by Month -->
    <div class="card">
        <div class="card-head">
            <span class="card-title"><i class="fas fa-chart-line" style="color:var(--blue)"></i> Downloads by Month (Current Year)</span>
        </div>
        <div style="padding:20px;overflow-x:auto">
            @if($data['downloads_by_month']->count())
            <table class="data-table" style="width:100%">
                <thead>
                    <tr><th>Month</th><th style="text-align:right">Downloads</th></tr>
                </thead>
                <tbody>
                @php $monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] @endphp
                @foreach($data['downloads_by_month'] as $d)
                <tr>
                    <td>{{ $monthNames[$d->month - 1] ?? 'N/A' }}</td>
                    <td style="text-align:right;font-weight:600">{{ number_format($d->count) }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <p style="text-align:center;color:var(--gray-400);padding:40px">No download data yet</p>
            @endif
        </div>
    </div>

    <!-- Users by Role -->
    <div class="card">
        <div class="card-head">
            <span class="card-title"><i class="fas fa-chart-pie" style="color:var(--green)"></i> Users by Role</span>
        </div>
        <div style="padding:20px;overflow-x:auto">
            @if($data['users_by_role']->count())
            <table class="data-table" style="width:100%">
                <thead>
                    <tr><th>Role</th><th style="text-align:right">Count</th><th style="text-align:right">Percentage</th></tr>
                </thead>
                <tbody>
                @foreach($data['users_by_role'] as $u)
                <tr>
                    <td>
                        <span class="badge badge-{{ $u->role }}">{{ ucfirst($u->role) }}</span>
                    </td>
                    <td style="text-align:right;font-weight:600">{{ $u->count }}</td>
                    <td style="text-align:right;font-size:12px;color:var(--gray-500)">
                        {{ number_format(($u->count / $totalUsers) * 100, 1) }}%
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <p style="text-align:center;color:var(--gray-400);padding:40px">No user data yet</p>
            @endif
        </div>
    </div>
</div>

<!-- Downloads by Department -->
<div class="card" style="margin-bottom:24px">
    <div class="card-head">
        <span class="card-title"><i class="fas fa-chart-bar" style="color:var(--purple)"></i> Materials by Department</span>
    </div>
    <div style="overflow-x:auto">
        <table class="data-table">
            <thead>
                <tr><th>Department</th><th style="text-align:right">Materials</th><th style="text-align:right">% of Total</th></tr>
            </thead>
            <tbody>
            @php $totalMats = $data['downloads_by_dept']->sum('materials_count') @endphp
            @forelse($data['downloads_by_dept'] as $d)
            <tr>
                <td style="font-weight:500">{{ $d->name }}</td>
                <td style="text-align:right;font-weight:600">{{ $d->materials_count }}</td>
                <td style="text-align:right;font-size:12px;color:var(--gray-500)">
                    {{ $totalMats > 0 ? number_format(($d->materials_count / $totalMats) * 100, 1) : 0 }}%
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center;padding:40px;color:var(--gray-400)">No department data yet</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Top Downloaded Materials -->
<div class="card">
    <div class="card-head">
        <span class="card-title"><i class="fas fa-fire" style="color:var(--red)"></i> Top 10 Downloaded Materials</span>
    </div>
    <div style="overflow-x:auto">
        <table class="data-table">
            <thead>
                <tr><th>Material Name</th><th>Department</th><th style="text-align:right">Downloads</th><th style="text-align:right">Views</th></tr>
            </thead>
            <tbody>
            @forelse($data['top_materials'] as $m)
            <tr>
                <td style="font-weight:500">{{ Str::limit($m->name, 40) }}</td>
                <td style="font-size:12px;color:var(--gray-600)">{{ $m->department->name ?? '—' }}</td>
                <td style="text-align:right"><span class="badge badge-faculty">{{ $m->downloads }}</span></td>
                <td style="text-align:right;font-size:12px;color:var(--gray-500)">{{ $m->views }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;padding:40px;color:var(--gray-400)">No material data yet</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection