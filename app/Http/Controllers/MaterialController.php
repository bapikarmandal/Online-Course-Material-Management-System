<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Institute;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::with(['institute', 'department', 'uploader']);

        if ($request->filled('institute_id')) {
            $query->where('institute_id', $request->institute_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $materials = $query->latest()->paginate(12);
        $institutes = Institute::with('departments')->get();

        return view('materials.index', compact('materials', 'institutes'));
    }

    public function show(Material $material)
    {
        $material->incrementViews();
        $material->load(['institute', 'department', 'uploader']);
        return view('materials.show', compact('material'));
    }

    public function download(Material $material)
    {
        $material->incrementDownloads();
        
        if (!Storage::disk('public')->exists($material->file_path)) {
            abort(404, 'File not found');
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
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'institute_id' => ['required', 'exists:institutes,id'],
                'department_id' => ['required', 'exists:departments,id'],
                'semester' => ['required', 'integer', 'min:1', 'max:12'],
                'file' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,ppt,pptx,txt'],
                'description' => ['nullable', 'string'],
            ]);

            $file = $request->file('file');
            $filePath = $file->store('materials', 'public');

            Material::create([
                'name' => $validated['name'],
                'institute_id' => $validated['institute_id'],
                'department_id' => $validated['department_id'],
                'semester' => $validated['semester'],
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'uploaded_by' => auth()->id(),
                'description' => $validated['description'] ?? null,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Material uploaded successfully!']);
            }

            return redirect()->route('materials.index')->with('success', 'Material uploaded successfully!');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to upload material: ' . $e->getMessage()]);
        }
    }

    public function destroy(Material $material)
    {
        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->back()->with('success', 'Material deleted successfully!');
    }

    public function getDepartments(Request $request)
    {
        $departments = Department::where('institute_id', $request->institute_id)->get();
        return response()->json($departments);
    }
}
