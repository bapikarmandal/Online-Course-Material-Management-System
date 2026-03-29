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
        $materials = Auth::user()
                         ->materials()
                         ->with(['institute', 'department'])
                         ->latest()
                         ->get();

        return view('faculty.dashboard', compact('materials'));
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
            'semester'      => 'required|integer|min:1|max:12',
            'file'          => 'required|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,txt',
            'description'   => 'nullable|string',
        ]);

        $file = $request->file('file');
        $path = $file->store('materials', 'public');

        Material::create([
            'name'          => $validated['name'],
            'institute_id'  => $validated['institute_id'],
            'department_id' => $validated['department_id'],
            'semester'      => $validated['semester'],
            'file_path'     => $path,
            'file_name'     => $file->getClientOriginalName(),
            'file_type'     => $file->getClientMimeType(),
            'file_size'     => $file->getSize(),
            'description'   => $validated['description'] ?? null,
            'uploaded_by'   => Auth::id(),
        ]);

        return redirect()->route('faculty.dashboard')
                         ->with('success', 'Material uploaded successfully!');
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
            'semester'      => 'required|integer|min:1|max:12',
            'file'          => 'nullable|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,txt',
            'description'   => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            if (Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $validated['file_path'] = $file->store('materials', 'public');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientMimeType();
            $validated['file_size'] = $file->getSize();
        }

        $material->update($validated);

        return redirect()->route('faculty.dashboard')
                         ->with('success', 'Material updated successfully!');
    }

    public function destroy(Material $material)
    {
        $this->authorise($material);

        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('faculty.dashboard')
                         ->with('success', 'Material deleted successfully!');
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function authorise(Material $material): void
    {
        if ($material->uploaded_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
