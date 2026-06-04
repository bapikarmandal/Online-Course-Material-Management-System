@extends('layouts.admin')
@section('title', 'Manage Institutes')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">Institutes</div>
        <button class="btn btn-gold" data-modal="addInstModal"><i class="fas fa-plus"></i> Add Institute</button>
    </div>
    <table class="data-table">
        <thead>
            <tr><th>#</th><th>Name</th><th>Description</th><th>Depts</th><th>Materials</th><th>Date</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($institutes as $inst)
            <tr>
                <td style="color:#9a9890; font-family:'DM Mono',monospace; font-size:12px;">{{ $inst->id }}</td>
                <td style="font-weight:600;">{{ $inst->name }}</td>
                <td style="font-size:12px; color:#6b6960;">{{ Str::limit($inst->description ?? '—', 60) }}</td>
                <td><span class="badge badge-faculty">{{ $inst->departments_count }}</span></td>
                <td><span class="badge badge-student">{{ $inst->materials_count }}</span></td>
                <td style="font-size:12px; color:#9a9890;">{{ $inst->created_at->format('d M Y') }}</td>
                <td>
                    <div style="display:flex; gap:6px;">
                        <button class="btn btn-edit btn-sm btn-open-edit-inst"
                            data-id="{{ $inst->id }}" data-name="{{ $inst->name }}" data-description="{{ $inst->description ?? '' }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.institutes.delete', $inst->id) }}" method="POST" onsubmit="return confirm('Delete institute?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:20px;">{{ $institutes->links() }}</div>
</div>

{{-- Add --}}
<div id="addInstModal" class="modal">
    <div class="modal-box">
        <div class="modal-head"><span class="title">Add Institute</span><button class="modal-close">&times;</button></div>
        <form action="{{ route('admin.institutes.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group"><label>Name *</label><input type="text" name="name" class="form-control" required></div>
                <div class="form-group"><label>Description</label><textarea name="description" class="form-control" rows="3"></textarea></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-close-modal>Cancel</button>
                <button type="submit" class="btn btn-gold">Add Institute</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit --}}
<div id="editInstModal" class="modal">
    <div class="modal-box">
        <div class="modal-head"><span class="title">Edit Institute</span><button class="modal-close">&times;</button></div>
        <form id="editInstForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group"><label>Name *</label><input type="text" name="name" id="edit_inst_name" class="form-control" required></div>
                <div class="form-group"><label>Description</label><textarea name="description" id="edit_inst_desc" class="form-control" rows="3"></textarea></div>
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
$(document).on('click', '.btn-open-edit-inst', function() {
    var b = $(this);
    $('#edit_inst_name').val(b.data('name'));
    $('#edit_inst_desc').val(b.data('description'));
    $('#editInstForm').attr('action', '/admin/institutes/' + b.data('id'));
    $('#editInstModal').addClass('show');
});
</script>
@endpush