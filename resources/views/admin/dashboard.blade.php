@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    @foreach([
        ['num'=>$stats['total_materials'],'label'=>'Total Materials','icon'=>'fas fa-book','color'=>'#1a56db'],
        ['num'=>$stats['total_users'],'label'=>'Total Users','icon'=>'fas fa-users','color'=>'#7c3aed'],
        ['num'=>$stats['faculty_count'],'label'=>'Faculty Members','icon'=>'fas fa-chalkboard-teacher','color'=>'#10b981'],
        ['num'=>$stats['student_count'],'label'=>'Students','icon'=>'fas fa-user-graduate','color'=>'#f59e0b'],
        ['num'=>$stats['total_institutes'],'label'=>'Institutes','icon'=>'fas fa-university','color'=>'#e74c3c'],
        ['num'=>$stats['total_downloads'],'label'=>'Total Downloads','icon'=>'fas fa-download','color'=>'#14b8a6'],
    ] as $s)
    <div class="stat-card" style="border-top-color:{{ $s['color'] }}">
        <div class="stat-icon" style="color:{{ $s['color'] }}"><i class="{{ $s['icon'] }}"></i></div>
        <div class="stat-num">{{ number_format($s['num']) }}</div>
        <div class="stat-label">{{ $s['label'] }}</div>
    </div>
    @endforeach
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
    <div class="card">
        <div class="card-head">
            <span class="card-title"><i class="fas fa-clock" style="color:var(--gray-400)"></i> Recent Uploads</span>
            <a href="{{ route('admin.materials') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead><tr><th>Name</th><th>Dept</th><th>By</th><th>Date</th></tr></thead>
                <tbody>
                @forelse($stats['recent_materials'] as $m)
                <tr>
                    <td><a href="{{ route('materials.show', $m) }}" style="color:var(--blue);font-weight:500">{{ Str::limit($m->name,30) }}</a></td>
                    <td style="font-size:12px;color:var(--gray-500)">{{ $m->department->name }}</td>
                    <td style="font-size:12px">{{ $m->uploader->name }}</td>
                    <td style="font-size:12px;color:var(--gray-400)">{{ $m->created_at->format('d M') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:var(--gray-400);padding:24px">No materials yet</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <span class="card-title"><i class="fas fa-fire" style="color:var(--red)"></i> Top Downloads</span>
        </div>
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead><tr><th>Material</th><th>Downloads</th><th>Views</th></tr></thead>
                <tbody>
                @forelse($stats['top_materials'] as $m)
                <tr>
                    <td style="font-size:13px;font-weight:500">{{ Str::limit($m->name,28) }}</td>
                    <td><span class="badge badge-active">{{ $m->downloads }}</span></td>
                    <td style="font-size:12px;color:var(--gray-400)">{{ $m->views }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:var(--gray-400);padding:24px">No data yet</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-head">
        <span class="card-title"><i class="fas fa-users" style="color:var(--gray-400)"></i> Recent Users</span>
        <a href="{{ route('admin.users') }}" class="btn btn-outline btn-sm">Manage Users</a>
    </div>
    <div style="overflow-x:auto">
        <table class="data-table">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead>
            <tbody>
            @foreach($stats['recent_users'] as $u)
            <tr>
                <td style="font-weight:500">{{ $u->name }}</td>
                <td style="color:var(--gray-500);font-size:13px">{{ $u->email }}</td>
                <td><span class="badge badge-{{ $u->role }}">{{ ucfirst($u->role) }}</span></td>
                <td style="font-size:12px;color:var(--gray-400)">{{ $u->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection