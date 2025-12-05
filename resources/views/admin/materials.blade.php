@extends('layouts.admin')

@section('title', 'Manage Materials')
@section('page-title', 'Manage Materials')

@section('content')
<div class="main-content">
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
                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this material?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="font-size: 12px;">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
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

@section('scripts')
<script>
    // Load departments based on selected institute in modal
    document.getElementById('modal_institute_id').addEventListener('change', function() {
        const instituteId = this.value;
        const departmentSelect = document.getElementById('modal_department_id');
        
        departmentSelect.innerHTML = '<option value="">Select Department</option>';
        
        if (instituteId) {
            fetch(`/api/departments?institute_id=${instituteId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(dept => {
                        const option = document.createElement('option');
                        option.value = dept.id;
                        option.textContent = dept.name;
                        departmentSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading departments:', error);
                });
        }
    });

    // Handle form submission - show loading state
    document.getElementById('materialForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
        submitBtn.disabled = true;
    });
</script>
@endsection
