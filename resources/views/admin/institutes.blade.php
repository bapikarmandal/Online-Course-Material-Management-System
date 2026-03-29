@extends('layouts.admin')

@section('title', 'Manage Institutes')

@section('content')
<div class="top-bar">
    <h1 style="margin:0; color:#333;">Manage Institutes</h1>
    <span style="color:#666;">Welcome, {{ auth()->user()->name }}</span>
</div>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="margin:0; color:#333;">Institutes</h2>
        <button class="btn-primary modal-trigger" data-modal="addInstituteModal">
            <i class="fas fa-plus"></i> Add Institute
        </button>
    </div>

    <table class="data-table" style="width:100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Departments</th>
                <th>Materials</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($institutes as $institute)
                <tr>
                    <td>{{ $institute->id }}</td>
                    <td><strong>{{ $institute->name }}</strong></td>
                    <td>{{ Str::limit($institute->description ?? 'N/A', 60) }}</td>
                    <td>
                        <span style="background:#667eea; color:white; padding:4px 10px;
                                     border-radius:12px; font-size:12px;">
                            {{ $institute->departments_count }}
                        </span>
                    </td>
                    <td>
                        <span style="background:#27ae60; color:white; padding:4px 10px;
                                     border-radius:12px; font-size:12px;">
                            {{ $institute->materials_count }}
                        </span>
                    </td>
                    <td>{{ $institute->created_at->format('M d, Y') }}</td>
                    <td>
                        <button type="button" class="btn-edit-institute"
                                style="background:#3498db; color:white; border:none;
                                       padding:6px 12px; border-radius:4px; cursor:pointer;
                                       font-size:12px; margin-right:4px;"
                                data-id="{{ $institute->id }}"
                                data-name="{{ $institute->name }}"
                                data-description="{{ $institute->description ?? '' }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.institutes.delete', $institute->id) }}"
                              method="POST" style="display:inline;"
                              onsubmit="return confirm('Delete this institute?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:20px;">{{ $institutes->links() }}</div>
</div>

{{-- ── Add Modal ── --}}
<div id="addInstituteModal" class="modal">
    <div class="modal-content">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top:0; color:#333;">Add New Institute</h2>
        <form action="{{ route('admin.institutes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Institute Name *</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"></textarea>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Add Institute</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Edit Modal ── --}}
<div id="editInstituteModal" class="modal">
    <div class="modal-content">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top:0; color:#333;">Edit Institute</h2>
        <form id="editInstituteForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Institute Name *</label>
                <input type="text" name="name" id="edit_inst_name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="edit_inst_desc" rows="3"></textarea>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $(document).on('click', '.btn-edit-institute', function () {
        var btn = $(this);
        $('#edit_inst_name').val(btn.data('name'));
        $('#edit_inst_desc').val(btn.data('description'));
        $('#editInstituteForm').attr('action', '/admin/institutes/' + btn.data('id'));
        $('#editInstituteModal').fadeIn(200);
        $('body').css('overflow', 'hidden');
    });
});
</script>
@endpush
