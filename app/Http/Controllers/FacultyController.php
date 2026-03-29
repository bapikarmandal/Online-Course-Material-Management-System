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
     * Renamed from 'dashboard' to 'index' to match your Route definition.
     */
    public function index()
    {
        $materials = Auth::user()->materials()
            ->with(['institute', 'department'])
            ->latest()
            ->get();

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

        // Note: Ensure your route for the dashboard is named 'faculty.dashboard'
        return redirect()->route('faculty.dashboard')
            ->with('success', 'Material uploaded successfully!');
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit(Material $material)
    {
        // Check if the material belongs to the current faculty
        if ($material->uploaded_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $institutes = Institute::all();
        // Ideally fetch departments based on the institute
        $departments = Department::where('institute_id', $material->institute_id)->get();
        
        return view('faculty.materials.edit', compact('material', 'institutes', 'departments'));
    }

    /**
     * Update the specified material in storage.
     */
    public function update(Request $request, Material $material)
    {
        // Check if the material belongs to the current faculty
        if ($material->uploaded_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'institute_id' => 'required|exists:institutes,id',
            'department_id' => 'required|exists:departments,id',
            'semester' => 'required|integer|min:1|max:12',
            'file' => 'nullable|file|max:10240', // 10MB max
            'description' => 'nullable|string',
        ]);

        // Update file if provided
        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('materials', 'public');

            $validated['file_path'] = $path;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientMimeType();
            $validated['file_size'] = $file->getSize();
        }

        $material->update($validated);

        return redirect()->route('faculty.dashboard')
            ->with('success', 'Material updated successfully!');
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
        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        
        // Delete the record
        $material->delete();

        return redirect()->route('faculty.dashboard')
            ->with('success', 'Material deleted successfully!');
    }
}