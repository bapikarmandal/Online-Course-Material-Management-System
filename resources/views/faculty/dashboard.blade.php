@extends('faculty.layouts.app')
@section('title', 'Faculty Dashboard')
@section('page-title', 'My Materials')

@section('content')

<!-- Stats -->
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px">
    @foreach([
        ['num'=>$stats['total'],'label'=>'Materials Uploaded','icon'=>'fas fa-book','color'=>'#4f46e5'],
        ['num'=>number_format($stats['views']),'label'=>'Total Views','icon'=>'fas fa-eye','color'=>'#10b981'],
        ['num'=>number_format($stats['downloads']),'label'=>'Total Downloads','icon'=>'fas fa-download','color'=>'#f59e0b'],
    ] as $s)
    <div style="background:#fff;border-radius:12px;padding:20px;border:1.5px solid var(--gray-200);border-top:4px solid {{ $s['color'] }}">
        <div style="font-size:20px;color:{{ $s['color'] }};margin-bottom:8px"><i class="{{ $s['icon'] }}"></i></div>
        <div style="font-size:26px;font-weight:800;color:var(--gray-800);margin-bottom:4px">{{ $s['num'] }}</div>
        <div style="font-size:12px;font-weight:600;color:var(--gray-500);text-transform:uppercase;letter-spacing:.5px">{{ $s['label'] }}</div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-head">
        <span class="card-title">Uploaded Materials</span>
        <a href="{{ route('faculty.materials.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Upload New</a>
    </div>

    @if($materials->isEmpty())
    <div style="text-align:center;padding:60px 20px;color:var(--gray-400)">
        <div style="font-size:56px;margin-bottom:16px">📁</div>
        <div style="font-size:18px;font-weight:600;margin-bottom:8px;color:var(--gray-600)">No materials uploaded yet</div>
        <div style="font-size:14px;margin-bottom:20px">Get started by uploading your first material.</div>
        <a href="{{ route('faculty.materials.create') }}" class="btn btn-primary">Upload First Material</a>
    </div>
    @else
    <div style="overflow-x:auto">
        <table class="data-table">
            <thead><tr><th>Material</th><th>Type</th><th>Department</th><th>Semester</th><th>Views</th><th>Downloads</th><th>Actions</th></tr></thead>
            <tbody>
            @foreach($materials as $m)
            <tr>
                <td>
                    <a href="{{ route('materials.show', $m) }}" style="color:var(--accent);font-weight:600">{{ Str::limit($m->name, 35) }}</a>
                    @if($m->file_name)<div style="font-size:11px;color:var(--gray-400);margin-top:2px">{{ $m->file_name }}</div>@endif
                </td>
                <td>
                    @php $tl = ['study_material'=>'Study','previous_year_question'=>'PYQ','syllabus'=>'Syllabus','assignment'=>'Assignment','other'=>'Other'] @endphp
                    <span style="font-size:11px;padding:3px 8px;border-radius:12px;background:var(--gray-100);color:var(--gray-600);font-weight:600">
                        {{ $tl[$m->material_type] ?? 'Other' }}
                    </span>
                </td>
                <td style="font-size:12px;color:var(--gray-500)">{{ $m->department->name }}</td>
                <td style="text-align:center"><span style="background:#dbeafe;color:#1e40af;padding:3px 8px;border-radius:12px;font-size:11px;font-weight:700">Sem {{ $m->semester }}</span></td>
                <td style="font-size:12px;color:var(--gray-500)">{{ number_format($m->views) }}</td>
                <td style="font-size:12px;color:var(--gray-500)">{{ number_format($m->downloads) }}</td>
                <td>
                    <div style="display:flex;gap:6px">
                        <button class="btn btn-outline" style="padding:5px 10px;font-size:11px" data-modal="edit-{{ $m->id }}"
                                onclick="openEdit({{ $m->id }}, '{{ $m->institute_id }}', '{{ $m->department_id }}', {{ $m->semester }}, '{{ $m->material_type }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="{{ route('materials.download', $m) }}" class="btn btn-outline" style="padding:5px 10px;font-size:11px" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                        <form method="POST" action="{{ route('faculty.materials.destroy', $m) }}" onsubmit="return confirm('Delete this material?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding:5px 10px;font-size:11px"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>

                    <!-- Edit Modal -->
                    <div id="edit-{{ $m->id }}" class="modal">
                        <div class="modal-box">
                            <div class="modal-head">
                                <h3>Edit Material</h3>
                                <button class="modal-close">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('faculty.materials.update', $m) }}" enctype="multipart/form-data">
                                    @csrf @method('PUT')
                                    <div class="form-group">
                                        <label class="form-label">Name *</label>
                                        <input type="text" name="name" value="{{ $m->name }}" required class="form-control">
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label">Institute *</label>
                                            <select name="institute_id" id="inst-{{ $m->id }}" class="form-control" required onchange="loadDepts(this.value, 'dept-{{ $m->id }}')">
                                                @foreach(\App\Models\Institute::all() as $inst)
                                                <option value="{{ $inst->id }}" {{ $m->institute_id == $inst->id ? 'selected' : '' }}>{{ $inst->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Department *</label>
                                            <select name="department_id" id="dept-{{ $m->id }}" class="form-control" required>
                                                @foreach(\App\Models\Department::where('institute_id', $m->institute_id)->get() as $d)
                                                <option value="{{ $d->id }}" {{ $m->department_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label class="form-label">Semester *</label>
                                            <select name="semester" class="form-control" required>
                                                @for($i=1;$i<=6;$i++)<option value="{{ $i }}" {{ $m->semester==$i?'selected':'' }}>Semester {{ $i }}</option>@endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Material Type *</label>
                                            <select name="material_type" class="form-control" required>
                                                @foreach(['study_material'=>'Study Material','previous_year_question'=>'Previous Year Question','syllabus'=>'Syllabus','assignment'=>'Assignment','other'=>'Other'] as $v=>$l)
                                                <option value="{{ $v }}" {{ $m->material_type===$v?'selected':'' }}>{{ $l }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Drive Link (optional)</label>
                                        <input type="url" name="drive_link" value="{{ $m->drive_link }}" class="form-control" placeholder="https://drive.google.com/...">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Replace File (optional)</label>
                                        <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.mkv">
                                        <small style="color:var(--gray-400);font-size:11px">Leave empty to keep current file. Max 100MB.</small>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="2">{{ $m->description }}</textarea>
                                    </div>
                                    <div style="display:flex;gap:10px;justify-content:flex-end">
                                        <button type="button" class="btn btn-outline modal-close">Cancel</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function loadDepts(instId, selectId) {
    $.getJSON('/api/departments', {institute_id: instId}, function(data) {
        let opts = '';
        data.forEach(d => opts += `<option value="${d.id}">${d.name}</option>`);
        $('#' + selectId).html(opts);
    });
}
function openEdit(id, instId, deptId, sem, type) {
    document.getElementById('edit-' + id).classList.add('open');
}
</script>
@endpush