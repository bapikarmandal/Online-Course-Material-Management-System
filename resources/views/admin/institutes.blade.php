@extends('layouts.admin')

@section('title', 'Manage Institutes')
@section('page-title', 'Manage Institutes')

@section('content')
<div class="card" style="margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #333;">Institutes</h2>
        <button class="btn-primary modal-trigger" data-modal="addInstituteModal">
            <i class="fas fa-plus"></i> Add Institute
        </button>
    </div>

    <table class="data-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 12px; text-align: left;">ID</th>
                <th style="padding: 12px; text-align: left;">Institute Name</th>
                <th style="padding: 12px; text-align: left;">Description</th>
                <th style="padding: 12px; text-align: left;">Departments</th>
                <th style="padding: 12px; text-align: left;">Created</th>
                <th style="padding: 12px; text-align: left;">Actions</th>
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
    
    <!-- Pagination -->
    <div class="pagination" style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $institutes->links() }}
    </div>
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

@endsection
