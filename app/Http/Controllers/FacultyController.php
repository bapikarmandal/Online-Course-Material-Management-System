<?php
namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Institute;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FacultyController extends Controller
{
    public function index()
    {
        $materials = Auth::user()->materials()
                         ->with(['institute', 'department'])
                         ->latest()->get();
        $stats = [
            'total'     => $materials->count(),
            'views'     => $materials->sum('views'),
            'downloads' => $materials->sum('downloads'),
        ];
        return view('faculty.dashboard', compact('materials', 'stats'));
    }

    public function create()
    {
        $institutes  = Institute::all();
        $departments = Department::all();
        return view('faculty.materials.create', compact('institutes', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'institute_id'  => 'required|exists:institutes,id',
            'department_id' => 'required|exists:departments,id',
            'semester'      => 'required|integer|min:1|max:6',
            'material_type' => 'required|in:study_material,previous_year_question,syllabus,assignment,other',
            'description'   => 'nullable|string|max:1000',
            'drive_link'    => 'nullable|url',
            'file'          => 'nullable|file|max:102400|mimes:pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png,gif,mp4,avi,mov,mkv',
        ]);

        if (!$request->hasFile('file') && !$request->filled('drive_link')) {
            return back()->withErrors(['file' => 'Please upload a file or provide a drive link.'])->withInput();
        }

        $data = array_merge($validated, ['uploaded_by' => Auth::id()]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $file->store('materials', 'public');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_type'] = $file->getClientMimeType();
            $data['file_size'] = $file->getSize();
        }

        Material::create($data);
        return redirect()->route('faculty.dashboard')->with('success', 'Material uploaded successfully!');
    }

    public function edit(Material $material)
    {
        $this->authorise($material);
        $institutes  = Institute::all();
        $departments = Department::where('institute_id', $material->institute_id)->get();
        return view('faculty.materials.edit', compact('material', 'institutes', 'departments'));
    }

    public function update(Request $request, Material $material)
    {
        $this->authorise($material);
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'institute_id'  => 'required|exists:institutes,id',
            'department_id' => 'required|exists:departments,id',
            'semester'      => 'required|integer|min:1|max:6',
            'material_type' => 'required|in:study_material,previous_year_question,syllabus,assignment,other',
            'description'   => 'nullable|string|max:1000',
            'drive_link'    => 'nullable|url',
            'file'          => 'nullable|file|max:102400|mimes:pdf,doc,docx,ppt,pptx,txt,jpg,jpeg,png,gif,mp4,avi,mov,mkv',
        ]);
        if ($request->hasFile('file')) {
            if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }
            $file = $request->file('file');
            $validated['file_path'] = $file->store('materials', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientMimeType();
            $validated['file_size'] = $file->getSize();
        }
        $material->update($validated);
        return redirect()->route('faculty.dashboard')->with('success', 'Material updated successfully!');
    }

    public function destroy(Material $material)
    {
        $this->authorise($material);
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        return redirect()->route('faculty.dashboard')->with('success', 'Material deleted successfully!');
    }

    private function authorise(Material $material): void
    {
        if ($material->uploaded_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}