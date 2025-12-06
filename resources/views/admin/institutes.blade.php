@extends('layouts.admin')

@section('title', 'Manage Institutes')
@section('page-title', 'Manage Institutes')

@section('content')
<div class="main-content">
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
            <th style="padding: 12px; text-align: left;">Materials</th>
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
                <td style="padding: 12px;">
                    <div style="display: flex; gap: 5px; align-items: center;">
                        <button type="button" class="btn-edit-institute"
                                data-id="{{ $institute->id }}" 
                                data-name="{{ $institute->name }}"
                                data-description="{{ $institute->description ?? '' }}"
                                style="background: #3498db; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px; margin-right: 5px;">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.institutes.delete', $institute) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this institute? This will fail if it has departments or materials.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="font-size: 12px;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination" style="margin-top: 20px; display: flex; justify-content: center;">
    {{ $institutes->links() }}
    </div>
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

<!-- Edit Institute Modal -->
<div id="editInstituteModal" class="modal">
    <div class="modal-content">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top: 0; color: #333;">Edit Institute</h2>
        <form id="editInstituteForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_institute_name">Institute Name *</label>
                <input type="text" name="name" id="edit_institute_name" required>
            </div>
            <div class="form-group">
                <label for="edit_institute_description">Description</label>
                <textarea name="description" id="edit_institute_description" rows="3"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Update Institute</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle edit button clicks
        document.querySelectorAll('.btn-edit-institute').forEach(button => {
            button.addEventListener('click', function() {
                const instituteId = this.getAttribute('data-id');
                const instituteName = this.getAttribute('data-name');
                const instituteDescription = this.getAttribute('data-description');
                
                document.getElementById('edit_institute_name').value = instituteName;
                document.getElementById('edit_institute_description').value = instituteDescription || '';
                document.getElementById('editInstituteForm').action = '/admin/institutes/' + instituteId;
                
                document.getElementById('editInstituteModal').style.display = 'block';
            });
        });
        
        // Close modal
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.style.display = 'none';
                });
            });
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });
    });
</script>
@endsection
