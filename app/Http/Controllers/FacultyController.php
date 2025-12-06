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
    /**
     * Display the faculty dashboard.
     */
    public function dashboard()
    {
        $materials = Auth::user()->materials()
            ->with(['institute', 'department'])
            ->latest()
            ->paginate(10);

        return view('faculty.dashboard', compact('materials'));
    }

    /**
     * Show the form for creating a new material.
     */
    public function create()
    {
        $institutes = Institute::all();
        $departments = Department::all();
        
        return view('faculty.materials.create', compact('institutes', 'departments'));
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'institute_id' => 'required|exists:institutes,id',
            'department_id' => 'required|exists:departments,id',
            'semester' => 'required|integer|min:1|max:12',
            'file' => 'required|file|max:10240', // 10MB max
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $path = $file->store('materials', 'public');

        Material::create([
            'name' => $validated['name'],
            'institute_id' => $validated['institute_id'],
            'department_id' => $validated['department_id'],
            'semester' => $validated['semester'],
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'description' => $validated['description'] ?? null,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('faculty.dashboard')
            ->with('success', 'Material uploaded successfully!');
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy(Material $material)
    {
        // Check if the material belongs to the current faculty
        if ($material->uploaded_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the file from storage
        Storage::disk('public')->delete($material->file_path);
        
        // Delete the record
        $material->delete();

        return redirect()->route('faculty.dashboard')
            ->with('success', 'Material deleted successfully!');
    }
}
