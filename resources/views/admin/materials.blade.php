@extends('layouts.admin')
@section('title', 'Manage Materials')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">All Materials</div>
        <button class="btn btn-gold" data-modal="addMaterialModal">
            <i class="fas fa-plus"></i> Upload Material
        </button>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Institute</th>
                <th>Department</th>
                <th>Sem</th>
                <th>Uploader</th>
                <th>Views</th>
                <th>Downloads</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $m)
                <tr>
                    <td style="color:#9a9890; font-family:'DM Mono',monospace; font-size:12px;">{{ $m->id }}</td>
                    <td>
                        <a href="{{ route('materials.show', $m) }}" style="color:#0a1628; font-weight:600; text-decoration:none; font-size:13px;">
                            {{ Str::limit($m->name, 30) }}
                        </a>
                    </td>
                    <td style="font-size:12px; color:#6b6960;">{{ Str::limit($m->institute->name ?? '—', 20) }}</td>
                    <td style="font-size:12px; color:#6b6960;">{{ $m->department->name ?? '—' }}</td>
                    <td><span class="badge badge-faculty">{{ $m->semester }}</span></td>
                    <td style="font-size:12px;">{{ $m->uploader->name ?? '—' }}</td>
                    <td style="font-family:'DM Mono',monospace; font-size:12px;">{{ $m->views }}</td>
                    <td style="font-family:'DM Mono',monospace; font-size:12px;">{{ $m->downloads }}</td>
                    <td style="color:#9a9890; font-size:12px;">{{ $m->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button class="btn btn-edit btn-sm btn-open-edit"
                                data-id="{{ $m->id }}"
                                data-name="{{ $m->name }}"
                                data-institute-id="{{ $m->institute_id }}"
                                data-department-id="{{ $m->department_id }}"
                                data-semester="{{ $m->semester }}"
                                data-description="{{ $m->description ?? '' }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.materials.delete', $m->id) }}" method="POST" onsubmit="return confirm('Delete?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top:20px;">{{ $materials->links() }}</div>
</div>

{{-- Add Modal --}}
<div id="addMaterialModal" class="modal">
    <div class="modal-box">
        <div class="modal-head">
            <span class="title">Upload Material</span>
            <button class="modal-close">&times;</button>
        </div>
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Material Name *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Institute *</label>
                        <select name="institute_id" class="form-control" id="add_institute" required>
                            <option value="">Select...</option>
                            @foreach(\App\Models\Institute::all() as $inst)
                                <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Department *</label>
                        <select name="department_id" class="form-control" id="add_dept" required>
                            <option value="">Select Institute first</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="max-width:160px;">
                    <label>Semester *</label>
                    <select name="semester" class="form-control" required>
                        <option value="">—</option>
                        @for($i=1;$i<=12;$i++) <option value="{{ $i }}">Semester {{ $i }}</option> @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>File * <small style="color:#9a9890;">(PDF, DOC, DOCX, PPT, PPTX, TXT — Max 10MB)</small></label>
                    <input type="file" name="file" class="form-control" required accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-close-modal>Cancel</button>
                <button type="submit" class="btn btn-gold">Upload</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editMaterialModal" class="modal">
    <div class="modal-box">
        <div class="modal-head">
            <span class="title">Edit Material</span>
            <button class="modal-close">&times;</button>
        </div>
        <form id="editMaterialForm" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Material Name *</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Institute *</label>
                        <select name="institute_id" id="edit_inst" class="form-control" required>
                            <option value="">Select...</option>
                            @foreach(\App\Models\Institute::all() as $inst)
                                <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Department *</label>
                        <select name="department_id" id="edit_dept" class="form-control" required>
                            <option value="">Select...</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="max-width:160px;">
                    <label>Semester *</label>
                    <select name="semester" id="edit_sem" class="form-control" required>
                        <option value="">—</option>
                        @for($i=1;$i<=12;$i++) <option value="{{ $i }}">Semester {{ $i }}</option> @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Replace File <small style="color:#9a9890;">(optional)</small></label>
                    <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="edit_desc" class="form-control" rows="3"></textarea>
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
function loadDepts(instId, selectEl, selectedId) {
    $(selectEl).html('<option value="">Loading...</option>');
    if (!instId) { $(selectEl).html('<option value="">Select Institute first</option>'); return; }
    $.getJSON('/api/departments', { institute_id: instId }, function(data) {
        var opts = '<option value="">Select...</option>';
        $.each(data, function(i, d) {
            opts += '<option value="' + d.id + '"' + (d.id == selectedId ? ' selected' : '') + '>' + d.name + '</option>';
        });
        $(selectEl).html(opts);
    });
}
$('#add_institute').on('change', function() { loadDepts(this.value, '#add_dept', null); });
$('#edit_inst').on('change', function() { loadDepts(this.value, '#edit_dept', null); });

$(document).on('click', '.btn-open-edit', function() {
    var b = $(this);
    $('#edit_name').val(b.data('name'));
    $('#edit_inst').val(b.data('institute-id'));
    $('#edit_sem').val(b.data('semester'));
    $('#edit_desc').val(b.data('description'));
    $('#editMaterialForm').attr('action', '/admin/materials/' + b.data('id'));
    loadDepts(b.data('institute-id'), '#edit_dept', b.data('department-id'));
    $('#editMaterialModal').addClass('show');
});
</script>
@endpush