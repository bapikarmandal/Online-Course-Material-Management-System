@extends('layouts.admin')

@section('title', 'Manage Materials')
@section('page-title', 'Manage Materials')

<div class="main-content">
        <div class="top-bar">
            <h1 style="margin: 0; color: #333;">@yield('page-title', 'Dashboard')</h1>
            <div>
                <span style="color: #666;">Welcome, {{ auth()->user()->name }}</span>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; color: #333;">All Materials</h2>
            <button class="btn-primary modal-trigger" data-modal="addMaterialModal">
                <i class="fas fa-plus"></i> Upload Material
            </button>
        </div>

        <table class="data-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 12px; text-align: left;">ID</th>
                <th style="padding: 12px; text-align: left;">Name</th>
                <th style="padding: 12px; text-align: left;">Institute</th>
                <th style="padding: 12px; text-align: left;">Department</th>
                <th style="padding: 12px; text-align: left;">Semester</th>
                <th style="padding: 12px; text-align: left;">Uploaded By</th>
                <th style="padding: 12px; text-align: left;">Views</th>
                <th style="padding: 12px; text-align: left;">Downloads</th>
                <th style="padding: 12px; text-align: left;">Date</th>
                <th style="padding: 12px; text-align: left;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $material)
                <tr style="border-bottom: 1px solid #dee2e6;">
                    <td style="padding: 12px;">{{ $material->id }}</td>
                    <td style="padding: 12px;">
                        <a href="{{ route('materials.show', $material) }}" style="color: #667eea; text-decoration: none;">
                            {{ $material->name }}
                        </a>
                    </td>
                    <td style="padding: 12px;">{{ $material->institute->name }}</td>
                    <td style="padding: 12px;">{{ $material->department->name }}</td>
                    <td style="padding: 12px;">{{ $material->semester }}</td>
                    <td style="padding: 12px;">{{ $material->uploader->name }}</td>
                    <td style="padding: 12px;">{{ $material->views }}</td>
                    <td style="padding: 12px;">{{ $material->downloads }}</td>
                    <td style="padding: 12px;">{{ $material->created_at->format('M d, Y') }}</td>
                    <td style="padding: 12px;">
                        <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                            <button type="button" class="btn-edit-material"
                                    data-id="{{ $material->id }}" 
                                    data-name="{{ $material->name }}"
                                    data-institute-id="{{ $material->institute_id }}"
                                    data-department-id="{{ $material->department_id }}"
                                    data-semester="{{ $material->semester }}"
                                    data-description="{{ $material->description ?? '' }}"
                                    style="background: #3498db; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.3s; display: inline-flex; align-items: center; gap: 5px;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('admin.materials.delete', $material) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this material? This action cannot be undone.');"
                                  style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" style="background: #e74c3c; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 500; transition: all 0.3s; display: inline-flex; align-items: center; gap: 5px;">
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
            {{ $materials->links() }}
        </div>
    </div>
</div>
<!-- Add Material Modal -->
<div id="addMaterialModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close close-modal">&times;</span>
        <h2 style="margin-top: 0; color: #333;">Upload New Material</h2>
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data" id="materialForm">
            @csrf
            <div class="form-group">
                <label for="modal_name">Material Name *</label>
                <input type="text" name="name" id="modal_name" required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="modal_institute_id">Institute *</label>
                <select name="institute_id" id="modal_institute_id" required>
                    <option value="">Select Institute</option>
                    @foreach(\App\Models\Institute::with('departments')->get() as $institute)
                        <option value="{{ $institute->id }}" {{ old('institute_id') == $institute->id ? 'selected' : '' }}>
                            {{ $institute->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="modal_department_id">Department *</label>
                <select name="department_id" id="modal_department_id" required>
                    <option value="">Select Department</option>
                </select>
            </div>
            <div class="form-group">
                <label for="modal_semester">Semester *</label>
                <select name="semester" id="modal_semester" required>
                    <option value="">Select Semester</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label for="modal_file">File * (PDF, DOC, DOCX, PPT, PPTX, TXT - Max 10MB)</label>
                <input type="file" name="file" id="modal_file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
            </div>
            <div class="form-group">
                <label for="modal_description">Description</label>
                <textarea name="description" id="modal_description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-danger close-modal">Cancel</button>
                <button type="submit" class="btn-primary">Upload Material</button>
            </div>
        </form>
    </div>
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

@push('styles')
<style>
    .btn-edit-material:hover {
        background: #2980b9 !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(52, 152, 219, 0.3);
    }
    .btn-danger:hover {
        background: #c0392b !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(231, 76, 60, 0.3);
    }
    .btn-edit-material:active,
    .btn-danger:active {
        transform: translateY(0);
    }
</style>
@endpush

@section('scripts')
<script>
    $(document).ready(function() {
        // Load departments based on selected institute in add modal
        $('#modal_institute_id').on('change', function() {
            const instituteId = this.value;
            const departmentSelect = $('#modal_department_id');
            
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
            $('#editMaterialForm').attr('action', '/admin/materials/' + materialId);
            
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

        // Handle form submission - show loading state
        $('#materialForm').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
            submitBtn.prop('disabled', true);
        });

        // Close modal handlers (already in layout, but ensure they work)
        $(document).on('click', '.close-modal', function() {
            $('.modal').hide();
            $('body').css('overflow', '');
        });
        
        // Close modal when clicking outside
        $(document).on('click', '.modal', function(event) {
            if ($(event.target).hasClass('modal')) {
                $(this).hide();
                $('body').css('overflow', '');
            }
        });
    });
</script>
@endsection
