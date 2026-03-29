@extends('layouts.admin')

@section('title', 'Manage Materials')

@section('content')
<div class="top-bar">
    <h1 style="margin:0; color:#333;">Manage Materials</h1>
    <span style="color:#666;">Welcome, {{ auth()->user()->name }}</span>
</div>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="margin:0; color:#333;">All Materials</h2>
        <button class="btn-primary modal-trigger" data-modal="addMaterialModal">
            <i class="fas fa-plus"></i> Upload Material
        </button>
    </div>

    <table class="data-table" style="width:100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Institute</th>
                <th>Department</th>
                <th>Semester</th>
                <th>Uploaded By</th>
                <th>Views</th>
                <th>Downloads</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
                <tr>
                    <td>{{ $material->id }}</td>
                    <td>
                        <a href="{{ route('materials.show', $material) }}"
                           style="color:#667eea; text-decoration:none;">
                            {{ $material->name }}
                        </a>
                    </td>
                    <td>{{ $material->institute->name }}</td>
                    <td>{{ $material->department->name }}</td>
                    <td>{{ $material->semester }}</td>
                    <td>{{ $material->uploader->name }}</td>
                    <td>{{ $material->views }}</td>
                    <td>{{ $material->downloads }}</td>
                    <td>{{ $material->created_at->format('M d, Y') }}</td>
                    <td>
                        <button type="button" class="btn-edit-material"
                                style="background:#3498db; color:white; border:none;
                                       padding:6px 12px; border-radius:4px; cursor:pointer;
                                       font-size:12px; margin-right:4px;"
                                data-id="{{ $material->id }}"
                                data-name="{{ $material->name }}"
                                data-institute-id="{{ $material->institute_id }}"
                                data-department-id="{{ $material->department_id }}"
                                data-semester="{{ $material->semester }}"
                                data-description="{{ $material->description ?? '' }}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.materials.delete', $material->id) }}"
                              method="POST" style="display:inline;"
                              onsubmit="return confirm('Delete this material permanently?');">
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

    <div style="margin-top:20px;">{{ $materials->links() }}</div>
</div>

{{-- ── Add Material Modal ── --}}
<div id="addMaterialModal" class="modal">
    <div class="modal-content">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top:0; color:#333;">Upload New Material</h2>
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Material Name *</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Institute *</label>
                <select name="institute_id" id="add_institute_id" required>
                    <option value="">Select Institute</option>
                    @foreach(\App\Models\Institute::all() as $inst)
                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Department *</label>
                <select name="department_id" id="add_department_id" required>
                    <option value="">Select Department</option>
                </select>
            </div>
            <div class="form-group">
                <label>Semester *</label>
                <select name="semester" required>
                    <option value="">Select Semester</option>
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ $i }}">Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label>File * (PDF, DOC, DOCX, PPT, PPTX, TXT — Max 10 MB)</label>
                <input type="file" name="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"></textarea>
            </div>
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Upload</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Edit Material Modal ── --}}
<div id="editMaterialModal" class="modal">
    <div class="modal-content">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top:0; color:#333;">Edit Material</h2>
        <form id="editMaterialForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Material Name *</label>
                <input type="text" name="name" id="edit_name" required>
            </div>
            <div class="form-group">
                <label>Institute *</label>
                <select name="institute_id" id="edit_institute_id" required>
                    <option value="">Select Institute</option>
                    @foreach(\App\Models\Institute::all() as $inst)
                        <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Department *</label>
                <select name="department_id" id="edit_department_id" required>
                    <option value="">Select Department</option>
                </select>
            </div>
            <div class="form-group">
                <label>Semester *</label>
                <select name="semester" id="edit_semester" required>
                    <option value="">Select Semester</option>
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ $i }}">Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label>Replace File (optional)</label>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                <small style="color:#666;">Leave empty to keep the current file.</small>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="edit_description" rows="3"></textarea>
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

    // ── Load departments helper ──────────────────────────────────────────────
    function loadDepts(instituteId, selectEl, selectedId) {
        $(selectEl).html('<option value="">Loading…</option>');
        if (!instituteId) {
            $(selectEl).html('<option value="">Select Department</option>');
            return;
        }
        $.getJSON('/api/departments', { institute_id: instituteId }, function (data) {
            var opts = '<option value="">Select Department</option>';
            $.each(data, function (i, d) {
                opts += '<option value="' + d.id + '"' +
                        (d.id == selectedId ? ' selected' : '') + '>' +
                        d.name + '</option>';
            });
            $(selectEl).html(opts);
        });
    }

    // Add modal — institute change
    $('#add_institute_id').on('change', function () {
        loadDepts(this.value, '#add_department_id', null);
    });

    // Edit modal — institute change
    $('#edit_institute_id').on('change', function () {
        loadDepts(this.value, '#edit_department_id', null);
    });

    // Edit button click
    $(document).on('click', '.btn-edit-material', function () {
        var btn    = $(this);
        var instId = btn.data('institute-id');
        var deptId = btn.data('department-id');

        $('#edit_name').val(btn.data('name'));
        $('#edit_institute_id').val(instId);
        $('#edit_semester').val(btn.data('semester'));
        $('#edit_description').val(btn.data('description'));
        $('#editMaterialForm').attr('action', '/admin/materials/' + btn.data('id'));

        // Load departments then set selected dept
        loadDepts(instId, '#edit_department_id', deptId);

        $('#editMaterialModal').fadeIn(200);
        $('body').css('overflow', 'hidden');
    });
});
</script>
@endpush
