@extends('layouts.admin')
@section('title', 'Manage Departments')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">Departments</div>
        <button class="btn btn-gold" data-modal="addDeptModal"><i class="fas fa-plus"></i> Add Department</button>
    </div>
    <table class="data-table">
        <thead>
            <tr><th>#</th><th>Name</th><th>Institute</th><th>Materials</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($departments as $dept)
            <tr>
                <td style="color:#9a9890; font-family:'DM Mono',monospace; font-size:12px;">{{ $dept->id }}</td>
                <td style="font-weight:600;">{{ $dept->name }}</td>
                <td style="font-size:13px; color:#6b6960;">{{ $dept->institute->name ?? '—' }}</td>
                <td><span class="badge badge-student">{{ $dept->materials_count }}</span></td>
                <td style="font-size:12px; color:#9a9890;">{{ $dept->created_at->format('d M Y') }}</td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <button class="btn btn-edit btn-sm btn-open-edit-dept"
                            data-id="{{ $dept->id }}" data-name="{{ $dept->name }}" data-institute-id="{{ $dept->institute_id }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.departments.destroy', $dept->id) }}" method="POST" onsubmit="return confirm('Delete?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:20px;">{{ $departments->links() }}</div>
</div>

{{-- Add --}}
<div id="addDeptModal" class="modal">
    <div class="modal-box">
        <div class="modal-head"><span class="title">Add Department</span><button class="modal-close">&times;</button></div>
        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group"><label>Department Name *</label><input type="text" name="name" class="form-control" required></div>
                <div class="form-group">
                    <label>Institute *</label>
                    <select name="institute_id" class="form-control" required>
                        <option value="">Select...</option>
                        @foreach($institutes as $inst)
                            <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="2"></textarea></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-close-modal>Cancel</button>
                <button type="submit" class="btn btn-gold">Add Department</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit --}}
<div id="editDeptModal" class="modal">
    <div class="modal-box">
        <div class="modal-head"><span class="title">Edit Department</span><button class="modal-close">&times;</button></div>
        <form id="editDeptForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group"><label>Name *</label><input type="text" name="name" id="edit_dept_name" class="form-control" required></div>
                <div class="form-group">
                    <label>Institute *</label>
                    <select name="institute_id" id="edit_dept_inst" class="form-control" required>
                        <option value="">Select...</option>
                        @foreach($institutes as $inst)
                            <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-close-modal>Cancel</button>
                <button type="submit" class="btn btn-gold">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.btn-open-edit-dept', function() {
    var b = $(this);
    $('#edit_dept_name').val(b.data('name'));
    $('#edit_dept_inst').val(b.data('institute-id'));
    $('#editDeptForm').attr('action', '/admin/departments/' + b.data('id'));
    $('#editDeptModal').addClass('show');
});
</script>
@endpush