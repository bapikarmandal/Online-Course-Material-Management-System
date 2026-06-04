<?php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Institute;
use App\Models\Material;
use App\Models\DownloadLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::with(['institute', 'department', 'uploader'])
                         ->where('is_active', true);

        if ($request->filled('institute_id'))  $query->where('institute_id', $request->institute_id);
        if ($request->filled('department_id')) $query->where('department_id', $request->department_id);
        if ($request->filled('semester'))      $query->where('semester', $request->semester);
        if ($request->filled('material_type')) $query->where('material_type', $request->material_type);
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $materials    = $query->latest()->paginate(12)->withQueryString();
        $institutes   = Institute::with('departments')->get();
        $materialTypes = [
            'study_material'        => 'Study Material',
            'previous_year_question'=> 'Previous Year Question',
            'syllabus'              => 'Syllabus',
            'assignment'            => 'Assignment',
            'other'                 => 'Other',
        ];
        return view('materials.index', compact('materials', 'institutes', 'materialTypes'));
    }

    public function show(Material $material)
    {
        abort_if(!$material->is_active, 404);
        $material->incrementViews();
        $material->load(['institute', 'department', 'uploader']);
        return view('materials.show', compact('material'));
    }

    public function download(Material $material)
    {
        abort_if(!$material->is_active, 404);

        // Log the download
        DownloadLog::create([
            'user_id'     => auth()->id(),
            'material_id' => $material->id,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);

        $material->incrementDownloads();

        if ($material->drive_link && !$material->file_path) {
            return redirect($material->drive_link);
        }

        if (!Storage::disk('public')->exists($material->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    public function create()
    {
        $institutes = Institute::with('departments')->get();
        return view('materials.create', compact('institutes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'institute_id'  => ['required', 'exists:institutes,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'semester'      => ['required', 'integer', 'min:1', 'max:6'],
            'material_type' => ['required', 'in:study_material,previous_year_question,syllabus,assignment,other'],
            'file'          => ['nullable', 'file', 'max:102400', 'mimes:pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png,gif,mp4,avi,mov,mkv'],
            'drive_link'    => ['nullable', 'url'],
            'description'   => ['nullable', 'string'],
        ]);

        $data = array_merge($validated, ['uploaded_by' => auth()->id()]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('materials', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_type'] = $file->getClientMimeType();
            $data['file_size'] = $file->getSize();
        }

        Material::create($data);
        return redirect()->route('materials.index')->with('success', 'Material uploaded successfully!');
    }

    public function destroy(Material $material)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $material->uploaded_by !== $user->id) {
            abort(403);
        }
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        return redirect()->back()->with('success', 'Material deleted successfully!');
    }

    public function getDepartments(Request $request)
    {
        return response()->json(
            Department::where('institute_id', $request->institute_id)->get()
        );
    }
}