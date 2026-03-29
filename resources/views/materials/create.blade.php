@extends('faculty.layouts.app')

@section('title', 'Upload Material')

@section('content')
<div class="top-bar">
    <h1 style="margin:0; color:#333;">Upload New Material</h1>
    <a href="{{ route('faculty.dashboard') }}" class="btn-primary">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="card" style="max-width:700px;">
    <form action="{{ route('faculty.materials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Material Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   placeholder="e.g. Data Structures Notes — Unit 3">
            @error('name')<p style="color:#e74c3c; font-size:13px; margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div class="form-group">
                <label>Institute *</label>
                <select name="institute_id" id="institute_id" required>
                    <option value="">Select Institute</option>
                    @foreach($institutes as $inst)
                        <option value="{{ $inst->id }}"
                            {{ old('institute_id') == $inst->id ? 'selected' : '' }}>
                            {{ $inst->name }}
                        </option>
                    @endforeach
                </select>
                @error('institute_id')<p style="color:#e74c3c; font-size:13px; margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div class="form-group">
                <label>Department *</label>
                <select name="department_id" id="department_id" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}"
                            {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')<p style="color:#e74c3c; font-size:13px; margin-top:4px;">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="form-group" style="max-width:200px;">
            <label>Semester *</label>
            <select name="semester" required>
                <option value="">Select</option>
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>
                        Semester {{ $i }}
                    </option>
                @endfor
            </select>
            @error('semester')<p style="color:#e74c3c; font-size:13px; margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>File * <small style="color:#666;">(PDF, DOC, DOCX, PPT, PPTX, TXT — Max 10 MB)</small></label>
            <input type="file" name="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.txt">
            @error('file')<p style="color:#e74c3c; font-size:13px; margin-top:4px;">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label>Description <small style="color:#666;">(optional)</small></label>
            <textarea name="description" rows="3"
                      placeholder="Brief description of the material…">{{ old('description') }}</textarea>
        </div>

        <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:10px;">
            <a href="{{ route('faculty.dashboard') }}" class="btn-danger" style="text-decoration:none;">
                Cancel
            </a>
            <button type="submit" class="btn-primary">
                <i class="fas fa-upload"></i> Upload Material
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#institute_id').on('change', function () {
        var instId = this.value;
        var $dept  = $('#department_id');
        $dept.html('<option value="">Loading…</option>');
        if (!instId) { $dept.html('<option value="">Select Department</option>'); return; }
        $.getJSON('/api/departments', { institute_id: instId }, function (data) {
            var opts = '<option value="">Select Department</option>';
            $.each(data, function (i, d) {
                opts += '<option value="' + d.id + '">' + d.name + '</option>';
            });
            $dept.html(opts);
        });
    });
});
</script>
@endpush
