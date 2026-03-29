<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Material;
use App\Models\Institute;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ─── Dashboard ────────────────────────────────────────────────────────────

    public function index()
    {
        $stats = [
            'total_users'       => User::count(),
            'total_materials'   => Material::count(),
            'total_institutes'  => Institute::count(),
            'total_departments' => Department::count(),
            'recent_materials'  => Material::with(['user', 'institute', 'department', 'uploader'])
                                           ->latest()
                                           ->take(5)
                                           ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // ─── Users ────────────────────────────────────────────────────────────────

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself or other admins
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete an admin account.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    // ─── Materials ────────────────────────────────────────────────────────────

    public function materials()
    {
        $materials = Material::with(['uploader', 'institute', 'department'])
                             ->latest()
                             ->paginate(10);
        return view('admin.materials', compact('materials'));
    }

    public function updateMaterial(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'institute_id'  => 'required|exists:institutes,id',
            'department_id' => 'required|exists:departments,id',
            'semester'      => 'required|integer|min:1|max:12',
            'description'   => 'nullable|string',
            'file'          => 'nullable|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,txt',
        ]);

        if ($request->hasFile('file')) {
            // Remove old file
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
        return back()->with('success', 'Material updated successfully.');
    }

    public function deleteMaterial($id)
    {
        $material = Material::findOrFail($id);

        if (Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
        return back()->with('success', 'Material deleted successfully.');
    }

    // ─── Institutes ───────────────────────────────────────────────────────────

    public function institutes()
    {
        $institutes = Institute::withCount(['departments', 'materials'])
                               ->latest()
                               ->paginate(10);
        return view('admin.institutes', compact('institutes'));
    }

    public function storeInstitute(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:institutes,name',
            'description' => 'nullable|string',
        ]);

        Institute::create($request->only('name', 'description'));
        return back()->with('success', 'Institute added successfully.');
    }

    public function updateInstitute(Request $request, $id)
    {
        $institute = Institute::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255|unique:institutes,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $institute->update($request->only('name', 'description'));
        return back()->with('success', 'Institute updated successfully.');
    }

    public function deleteInstitute($id)
    {
        $institute = Institute::findOrFail($id);

        if ($institute->departments()->count() > 0) {
            return back()->with('error', 'Cannot delete institute with existing departments.');
        }

        $institute->delete();
        return back()->with('success', 'Institute deleted successfully.');
    }

    // ─── Departments ──────────────────────────────────────────────────────────

    public function departments()
    {
        $departments = Department::with('institute')
                                 ->withCount('materials')
                                 ->paginate(10);
        $institutes  = Institute::all();
        return view('admin.departments', compact('departments', 'institutes'));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'institute_id' => 'required|exists:institutes,id',
            'description'  => 'nullable|string',
        ]);

        Department::create($request->only('name', 'institute_id', 'description'));
        return back()->with('success', 'Department added successfully.');
    }

    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'institute_id' => 'required|exists:institutes,id',
            'description'  => 'nullable|string',
        ]);

        $department->update($request->only('name', 'institute_id', 'description'));
        return back()->with('success', 'Department updated successfully.');
    }

    public function deleteDepartment($id)
    {
        Department::findOrFail($id)->delete();
        return back()->with('success', 'Department deleted successfully.');
    }
}
