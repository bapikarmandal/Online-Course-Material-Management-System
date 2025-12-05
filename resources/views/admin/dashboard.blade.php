@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="stats-card">
        <i class="fas fa-book fa-2x mb-2"></i>
        <p>Total Materials</p>
        <h3>{{ $stats['total_materials'] }}</h3>
    </div>
    <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
        <i class="fas fa-users fa-2x mb-2"></i>
        <p>Total Users</p>
        <h3>{{ $stats['total_users'] }}</h3>
    </div>
    <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
        <i class="fas fa-university fa-2x mb-2"></i>
        <p>Institutes</p>
        <h3>{{ $stats['total_institutes'] }}</h3>
    </div>
    <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
        <i class="fas fa-building fa-2x mb-2"></i>
        <p>Departments</p>
        <h3>{{ $stats['total_departments'] }}</h3>
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #333;">Recent Materials</h2>
        <a href="{{ route('admin.materials') }}" class="btn-primary">View All</a>
    </div>
    
    @if($stats['recent_materials']->count() > 0)
        <table class="data-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px; text-align: left;">Name</th>
                    <th style="padding: 12px; text-align: left;">Institute</th>
                    <th style="padding: 12px; text-align: left;">Department</th>
                    <th style="padding: 12px; text-align: left;">Semester</th>
                    <th style="padding: 12px; text-align: left;">Uploaded By</th>
                    <th style="padding: 12px; text-align: left;">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats['recent_materials'] as $material)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px;">
                            <a href="{{ route('materials.show', $material) }}" style="color: #667eea; text-decoration: none;">
                                {{ $material->name }}
                            </a>
                        </td>
                        <td style="padding: 12px;">{{ $material->institute->name }}</td>
                        <td style="padding: 12px;">{{ $material->department->name }}</td>
                        <td style="padding: 12px;">{{ $material->semester }}</td>
                        <td style="padding: 12px;">{{ $material->uploader->name }}</td>
                        <td style="padding: 12px;">{{ $material->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #666; padding: 40px;">No materials uploaded yet.</p>
    @endif
</div>
@endsection
