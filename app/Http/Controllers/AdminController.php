<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Institute;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_materials' => Material::count(),
            'total_users' => User::count(),
            'total_institutes' => Institute::count(),
            'total_departments' => Department::count(),
            'recent_materials' => Material::with(['institute', 'department', 'uploader'])->latest()->take(10)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function materials()
    {
        $materials = Material::with(['institute', 'department', 'uploader'])
            ->latest()
            ->paginate(25);
        return view('admin.materials', compact('materials'));
    }

    public function users()
    {
        $users = User::latest()->paginate(25);
        return view('admin.users', compact('users'));
    }

    public function institutes()
    {
        $institutes = Institute::with('departments')
            ->withCount('departments')
            ->withCount('materials')
            ->latest()
            ->paginate(25);
        return view('admin.institutes', compact('institutes'));
    }

    public function storeInstitute(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        Institute::create($validated);

        return redirect()->back()->with('success', 'Institute created successfully!');
    }

    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'institute_id' => ['required', 'exists:institutes,id'],
            'description' => ['nullable', 'string'],
        ]);

        Department::create($validated);

        return redirect()->back()->with('success', 'Department created successfully!');
    }

    public function updateDepartment(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'institute_id' => ['required', 'exists:institutes,id'],
            'description' => ['nullable', 'string'],
        ]);

        $department->update($validated);

        return redirect()->back()->with('success', 'Department updated successfully!');
    }

    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'Cannot delete admin user!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    public function departments()
    {
        $departments = Department::with(['institute', 'materials'])
            ->withCount('materials')
            ->latest()
            ->get();
        
        $institutes = Institute::all();
        
        return view('admin.departments', compact('departments', 'institutes'));
    }

    public function deleteDepartment(Department $department)
    {
        if ($department->materials()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete department that has associated materials!');
        }

        $department->delete();
        return redirect()->back()->with('success', 'Department deleted successfully!');
    }

    public function updateUser(Request $request, User $user)
    {
        if ($user->isAdmin() && $user->id !== auth()->id()) {
            return redirect()->back()->with('error', 'Cannot edit other admin users!');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,faculty,student'],
        ]);

        // Prevent changing own role from admin
        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return redirect()->back()->with('error', 'Cannot change your own role from admin!');
        }

        $user->update($validated);
        return redirect()->back()->with('success', 'User updated successfully!');
    }

    public function updateInstitute(Request $request, Institute $institute)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $institute->update($validated);
        return redirect()->back()->with('success', 'Institute updated successfully!');
    }

    public function deleteInstitute(Institute $institute)
    {
        if ($institute->departments()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete institute that has associated departments!');
        }

        if ($institute->materials()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete institute that has associated materials!');
        }

        $institute->delete();
        return redirect()->back()->with('success', 'Institute deleted successfully!');
    }

    public function updateMaterial(Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'institute_id' => ['required', 'exists:institutes,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'semester' => ['required', 'integer', 'min:1', 'max:12'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,ppt,pptx,txt'],
        ]);

        // Update file if provided
        if ($request->hasFile('file')) {
            // Delete old file
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($material->file_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $filePath = $file->store('materials', 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_type'] = $file->getClientMimeType();
            $validated['file_size'] = $file->getSize();
        }

        $material->update($validated);
        return redirect()->back()->with('success', 'Material updated successfully!');
    }

    public function deleteMaterial(Material $material)
    {
        // Delete the file from storage
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($material->file_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
        return redirect()->back()->with('success', 'Material deleted successfully!');
    }
}
