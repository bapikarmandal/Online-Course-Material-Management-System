@extends('faculty.layouts.app')
@section('title', 'Upload Material')
@section('page-title', 'Upload New Material')

@section('content')
<div style="max-width:700px">
    <div class="card">
        <div class="card-head">
            <span class="card-title"><i class="fas fa-upload"></i> Upload Material</span>
            <a href="{{ route('faculty.dashboard') }}" class="btn btn-outline btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('faculty.materials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Material Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="form-control"
                           placeholder="e.g. Data Structures — Unit 3 Notes">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Institute *</label>
                        <select name="institute_id" id="institute_id" required class="form-control">
                            <option value="">Select Institute</option>
                            @foreach($institutes as $inst)
                            <option value="{{ $inst->id }}" {{ old('institute_id') == $inst->id ? 'selected' : '' }}>{{ $inst->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Department *</label>
                        <select name="department_id" id="department_id" required class="form-control">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Semester *</label>
                        <select name="semester" required class="form-control">
                            <option value="">Select Semester</option>
                            @for($i=1;$i<=6;$i++)
                            <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Material Type *</label>
                        <select name="material_type" required class="form-control">
                            <option value="">Select Type</option>
                            @foreach(['study_material'=>'Study Material','previous_year_question'=>'Previous Year Question','syllabus'=>'Syllabus','assignment'=>'Assignment','other'=>'Other'] as $v=>$l)
                            <option value="{{ $v }}" {{ old('material_type') === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Upload File</label>
                    <input type="file" name="file" id="file-input" class="form-control"
                           accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.mkv">
                    <div id="file-preview" style="margin-top:8px;display:none;padding:10px;background:var(--gray-50);border-radius:8px;border:1px solid var(--gray-200);font-size:13px"></div>
                    <p style="font-size:12px;color:var(--gray-400);margin-top:4px">
                        Accepted: PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, PNG, GIF, MP4, AVI, MOV, MKV — Max 100 MB
                    </p>
                </div>

                <div class="form-group">
                    <label class="form-label">Or Provide a Drive/External Link</label>
                    <input type="url" name="drive_link" value="{{ old('drive_link') }}" class="form-control"
                           placeholder="https://drive.google.com/file/...">
                    <p style="font-size:12px;color:var(--gray-400);margin-top:4px">Google Drive, OneDrive, Dropbox, YouTube links are all accepted.</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Description <small style="font-weight:400;color:var(--gray-400)">(optional)</small></label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Brief description of what this material covers…">{{ old('description') }}</textarea>
                </div>

                <div style="display:flex;gap:12px;justify-content:flex-end;padding-top:8px">
                    <a href="{{ route('faculty.dashboard') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Upload Material</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#institute_id').on('change', function() {
    $.getJSON('/api/departments', {institute_id: this.value}, function(data) {
        let opts = '<option value="">Select Department</option>';
        data.forEach(d => opts += `<option value="${d.id}">${d.name}</option>`);
        $('#department_id').html(opts);
    });
});

document.getElementById('file-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if(!file) return;
    const mb = (file.size / 1024 / 1024).toFixed(2);
    const preview = document.getElementById('file-preview');
    preview.style.display = 'block';
    preview.innerHTML = `<i class="fas fa-file" style="color:var(--accent)"></i> <strong>${file.name}</strong> — ${mb} MB
        ${parseFloat(mb) > 100 ? '<span style="color:var(--red);font-weight:600"> (File too large! Max 100MB)</span>' : ''}`;
});
</script>
@endpush