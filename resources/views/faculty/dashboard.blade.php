@extends('faculty.layouts.app')

@section('title', 'Faculty Dashboard')

@section('content')
<div class="top-bar">
    <h1 style="margin:0; color:#333;">My Materials</h1>
    <span style="color:#666;">Welcome, {{ auth()->user()->name }}</span>
</div>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="margin:0; color:#333;">Uploaded Materials</h2>
        <a href="{{ route('faculty.materials.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Upload New
        </a>
    </div>

    @if($materials->isEmpty())
        <div style="text-align:center; padding:40px; color:#666;">
            <i class="fas fa-file-alt" style="font-size:48px; margin-bottom:20px; color:#ccc;"></i>
            <h3>No materials uploaded yet</h3>
            <p>Get started by uploading your first material.</p>
            <a href="{{ route('faculty.materials.create') }}" class="btn-primary"
               style="margin-top:20px; display:inline-block;">
                <i class="fas fa-upload"></i> Upload Material
            </a>
        </div>
    @else
        <table class="data-table" style="width:100%;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Institute</th>
                    <th>Department</th>
                    <th>Semester</th>
                    <th>Uploaded On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                    <tr>
                        <td>
                            <a href="{{ route('materials.show', $material) }}"
                               style="color:#4f46e5; text-decoration:none; font-weight:500;">
                                {{ $material->name }}
                            </a>
                            <div style="font-size:12px; color:#666; margin-top:4px;">
                                {{ $material->file_name }}
                            </div>
                        </td>
                        <td>{{ $material->institute->name }}</td>
                        <td>{{ $material->department->name }}</td>
                        <td>
                            <span style="background:#10b981; color:white; padding:4px 8px;
                                         border-radius:4px; font-size:12px;">
                                Sem {{ $material->semester }}
                            </span>
                        </td>
                        <td>{{ $material->created_at->format('M d, Y') }}</td>
                        <td>
                            <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                                <a href="{{ route('materials.show', $material) }}"
                                   style="color:#4f46e5; font-size:13px; text-decoration:none;">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button type="button" class="btn-edit btn-edit-material"
                                        data-id="{{ $material->id }}"
                                        data-name="{{ $material->name }}"
                                        data-institute-id="{{ $material->institute_id }}"
                                        data-department-id="{{ $material->department_id }}"
                                        data-semester="{{ $material->semester }}"
                                        data-description="{{ $material->description ?? '' }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="{{ route('materials.download', $material) }}"
                                   style="color:#10b981; font-size:13px; text-decoration:none;">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <form action="{{ route('faculty.materials.destroy', $material) }}"
                                      method="POST" style="margin:0;"
                                      onsubmit="return confirm('Delete this material?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- ── Edit Modal ── --}}
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
                <small style="color:#666;">Leave empty to keep current file. Max 10 MB.</small>
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

    $('#edit_institute_id').on('change', function () {
        loadDepts(this.value, '#edit_department_id', null);
    });

    $(document).on('click', '.btn-edit-material', function () {
        var btn    = $(this);
        var instId = btn.data('institute-id');
        var deptId = btn.data('department-id');

        $('#edit_name').val(btn.data('name'));
        $('#edit_institute_id').val(instId);
        $('#edit_semester').val(btn.data('semester'));
        $('#edit_description').val(btn.data('description'));
        $('#editMaterialForm').attr('action', '/faculty/materials/' + btn.data('id'));

        loadDepts(instId, '#edit_department_id', deptId);

        $('#editMaterialModal').fadeIn(200);
        $('body').css('overflow', 'hidden');
    });
});
</script>
@endpush
