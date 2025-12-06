@extends('faculty.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'My Materials')

@section('content')
<div class="top-bar">
    <h1 style="margin: 0; color: #333;">@yield('page-title', 'Dashboard')</h1>
    <div>
        <span style="color: #666;">Welcome, {{ auth()->user()->name }}</span>
    </div>
</div>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #333;">My Uploaded Materials</h2>
        <a href="{{ route('faculty.materials.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Upload New Material
        </a>
    </div>

    @if($materials->isEmpty())
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="fas fa-file-alt" style="font-size: 48px; margin-bottom: 20px; color: #ccc;"></i>
            <h3 style="margin: 10px 0;">No materials uploaded yet</h3>
            <p style="margin: 10px 0;">Get started by uploading your first material.</p>
            <a href="{{ route('faculty.materials.create') }}" class="btn-primary" style="margin-top: 20px; display: inline-block;">
                <i class="fas fa-upload"></i> Upload Material
            </a>
        </div>
    @else
        <table class="data-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px; text-align: left;">Name</th>
                    <th style="padding: 12px; text-align: left;">Institute</th>
                    <th style="padding: 12px; text-align: left;">Department</th>
                    <th style="padding: 12px; text-align: left;">Semester</th>
                    <th style="padding: 12px; text-align: left;">Uploaded On</th>
                    <th style="padding: 12px; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px;">
                            <a href="{{ route('materials.show', $material) }}" style="color: #4f46e5; text-decoration: none; font-weight: 500;">
                                {{ $material->name }}
                            </a>
                            <div style="font-size: 12px; color: #666; margin-top: 4px;">{{ $material->file_name }}</div>
                        </td>
                        <td style="padding: 12px;">{{ $material->institute->name }}</td>
                        <td style="padding: 12px;">{{ $material->department->name }}</td>
                        <td style="padding: 12px;">
                            <span style="background: #10b981; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;">
                                Semester {{ $material->semester }}
                            </span>
                        </td>
                        <td style="padding: 12px;">{{ $material->created_at->format('M d, Y') }}</td>
                        <td style="padding: 12px;">
                            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                <a href="{{ route('materials.show', $material) }}" style="color: #4f46e5; text-decoration: none; font-size: 13px;">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <button type="button" class="btn-edit-material btn-edit"
                                        data-id="{{ $material->id }}" 
                                        data-name="{{ $material->name }}"
                                        data-institute-id="{{ $material->institute_id }}"
                                        data-department-id="{{ $material->department_id }}"
                                        data-semester="{{ $material->semester }}"
                                        data-description="{{ $material->description ?? '' }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="{{ route('materials.download', $material) }}" style="color: #10b981; text-decoration: none; font-size: 13px;">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <form action="{{ route('faculty.materials.destroy', $material) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this material?');"
                                      style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger" style="font-size: 13px;">
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

<!-- Edit Material Modal -->
<div id="editMaterialModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top: 0; color: #333;">Edit Material</h2>
        <form id="editMaterialForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="edit_material_name">Material Name *</label>
                <input type="text" name="name" id="edit_material_name" required>
            </div>
            <div class="form-group">
                <label for="edit_material_institute_id">Institute *</label>
                <select name="institute_id" id="edit_material_institute_id" required>
                    <option value="">Select Institute</option>
                    @foreach(\App\Models\Institute::with('departments')->get() as $institute)
                        <option value="{{ $institute->id }}">{{ $institute->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="edit_material_department_id">Department *</label>
                <select name="department_id" id="edit_material_department_id" required>
                    <option value="">Select Department</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edit_material_semester">Semester *</label>
                <select name="semester" id="edit_material_semester" required>
                    <option value="">Select Semester</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label for="edit_material_file">File (Optional - Leave empty to keep current file)</label>
                <input type="file" name="file" id="edit_material_file" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
                <small style="color: #666;">PDF, DOC, DOCX, PPT, PPTX, TXT - Max 10MB</small>
            </div>
            <div class="form-group">
                <label for="edit_material_description">Description</label>
                <textarea name="description" id="edit_material_description" rows="3"></textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Update Material</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Load departments based on selected institute in edit modal
        $('#edit_material_institute_id').on('change', function() {
            const instituteId = this.value;
            const departmentSelect = $('#edit_material_department_id');
            
            departmentSelect.html('<option value="">Select Department</option>');
            
            if (instituteId) {
                fetch(`/api/departments?institute_id=${instituteId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(dept => {
                            departmentSelect.append(`<option value="${dept.id}">${dept.name}</option>`);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading departments:', error);
                    });
            }
        });

        // Handle edit button clicks using event delegation (works with DataTables)
        $(document).on('click', '.btn-edit-material', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $button = $(this);
            const materialId = $button.data('id');
            const materialName = $button.data('name');
            const instituteId = $button.data('institute-id');
            const departmentId = $button.data('department-id');
            const semester = $button.data('semester');
            const description = $button.data('description') || '';
            
            $('#edit_material_name').val(materialName);
            $('#edit_material_institute_id').val(instituteId);
            $('#edit_material_semester').val(semester);
            $('#edit_material_description').val(description);
            $('#editMaterialForm').attr('action', '/faculty/materials/' + materialId);
            
            // Load departments for the selected institute
            const departmentSelect = $('#edit_material_department_id');
            departmentSelect.html('<option value="">Select Department</option>');
            
            if (instituteId) {
                fetch(`/api/departments?institute_id=${instituteId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(dept => {
                            const selected = (dept.id == departmentId) ? 'selected' : '';
                            departmentSelect.append(`<option value="${dept.id}" ${selected}>${dept.name}</option>`);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading departments:', error);
                    });
            }
            
            $('#editMaterialModal').css({
                'display': 'block',
                'z-index': '9999'
            });
            $('body').css('overflow', 'hidden');
        });
    });
</script>
@endsection
