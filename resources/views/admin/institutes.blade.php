@extends('layouts.admin')

@section('title', 'Manage Institutes')
@section('page-title', 'Manage Institutes & Departments')

@section('content')
<div class="card" style="margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #333;">Institutes & Departments</h2>
        <div>
            <button class="btn-primary modal-trigger" data-modal="addInstituteModal" style="margin-right: 10px;">
                <i class="fas fa-plus"></i> Add Institute
            </button>
            <button class="btn-success modal-trigger" data-modal="addDepartmentModal">
                <i class="fas fa-plus"></i> Add Department
            </button>
        </div>
    </div>

    <table class="data-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 12px; text-align: left;">ID</th>
                <th style="padding: 12px; text-align: left;">Institute Name</th>
                <th style="padding: 12px; text-align: left;">Description</th>
                <th style="padding: 12px; text-align: left;">Departments</th>
                <th style="padding: 12px; text-align: left;">Materials</th>
                <th style="padding: 12px; text-align: left;">Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($institutes as $institute)
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 12px;">{{ $institute->id }}</td>
                    <td style="padding: 12px; font-weight: 600;">{{ $institute->name }}</td>
                    <td style="padding: 12px;">{{ $institute->description ?? 'N/A' }}</td>
                    <td style="padding: 12px;">
                        <span style="background: #667eea; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                            {{ $institute->departments_count }}
                        </span>
                    </td>
                    <td style="padding: 12px;">
                        <span style="background: #27ae60; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px;">
                            {{ $institute->materials_count }}
                        </span>
                    </td>
                    <td style="padding: 12px;">{{ $institute->created_at->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="card">
    <h2 style="margin: 0 0 20px 0; color: #333;">Departments by Institute</h2>
    @foreach($institutes as $institute)
        @if($institute->departments->count() > 0)
            <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #eee;">
                <h3 style="color: #667eea; margin-bottom: 15px;">
                    <i class="fas fa-university"></i> {{ $institute->name }}
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 10px;">
                    @foreach($institute->departments as $dept)
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; border-left: 4px solid #667eea;">
                            <strong>{{ $dept->name }}</strong>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>

<!-- Add Institute Modal -->
<div id="addInstituteModal" class="modal">
    <div class="modal-content">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top: 0; color: #333;">Add New Institute</h2>
        <form action="{{ route('admin.institutes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Institute Name *</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Add Institute</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Department Modal -->
<div id="addDepartmentModal" class="modal">
    <div class="modal-content">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top: 0; color: #333;">Add New Department</h2>
        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="institute_id">Institute *</label>
                <select name="institute_id" id="institute_id" required>
                    <option value="">Select Institute</option>
                    @foreach($institutes as $institute)
                        <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="dept_name">Department Name *</label>
                <input type="text" name="name" id="dept_name" required>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Add Department</button>
            </div>
        </form>
    </div>
</div>
@endsection
