@extends('layouts.admin')

@section('title', 'Manage Departments')

@section('content')
<div class="top-bar">
    <h1 style="margin:0; color:#333;">Manage Departments</h1>
    <span style="color:#666;">Welcome, {{ auth()->user()->name }}</span>
</div>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="margin:0; color:#333;">Departments</h2>
        <button class="btn-primary modal-trigger" data-modal="addDeptModal">
            <i class="fas fa-plus"></i> Add Department
        </button>
    </div>

    <table class="data-table" style="width:100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Institute</th>
                <th>Materials</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $dept)
                <tr>
                    <td>{{ $dept->id }}</td>
                    <td>{{ $dept->name }}</td>
                    <td>{{ $dept->institute->name }}</td>
                    <td>
                        <span style="background:#667eea; color:white; padding:4px 10px;
                                     border-radius:12px; font-size:12px;">
                            {{ $dept->materials_count }}
                        </span>
                    </td>
                    <td>{{ $dept->created_at->format('M d, Y') }}</td>
                    <td>
                        <button type="button" class="btn-edit-dept"
                                style="background:#3498db; color:white; border:none;
                                       padding:6px 12px; border-radius:4px; cursor:pointer;
                                       font-size:12px; margin-right:4px;"
                                data-id="{{ $dept->id }}"
                                data-name="{{ $dept->name }}"
                                data-institute-id="{{ $dept->institute_id }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.departments.destroy', $dept->id) }}"
                              method="POST" style="display:inline;"
                              onsubmit="return confirm('Delete this department?');">
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

    <div style="margin-top:20px;">{{ $departments->links() }}</div>
</div>

{{-- ── Add Modal ── --}}
<div id="addDeptModal" class="modal">
    <div class="modal-content">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top:0; color:#333;">Add New Department</h2>
        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Department Name *</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Institute *</label>
                <select name="institute_id" required>
                    <option value="">Select Institute</option>
                    @foreach($institutes as $inst)
                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Add Department</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Edit Modal ── --}}
<div id="editDeptModal" class="modal">
    <div class="modal-content">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top:0; color:#333;">Edit Department</h2>
        <form id="editDeptForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Department Name *</label>
                <input type="text" name="name" id="edit_dept_name" required>
            </div>
            <div class="form-group">
                <label>Institute *</label>
                <select name="institute_id" id="edit_dept_institute" required>
                    <option value="">Select Institute</option>
                    @foreach($institutes as $inst)
                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
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
    $(document).on('click', '.btn-edit-dept', function () {
        var btn = $(this);
        $('#edit_dept_name').val(btn.data('name'));
        $('#edit_dept_institute').val(btn.data('institute-id'));
        $('#editDeptForm').attr('action', '/admin/departments/' + btn.data('id'));
        $('#editDeptModal').fadeIn(200);
        $('body').css('overflow', 'hidden');
    });
});
</script>
@endpush
