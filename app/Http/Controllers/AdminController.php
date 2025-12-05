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
        $materials = Material::with(['institute', 'department', 'uploader'])->latest()->get();
        return view('admin.materials', compact('materials'));
    }

    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function institutes()
    {
        $institutes = Institute::with('departments')->withCount('departments')->withCount('materials')->latest()->get();
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
        ]);

        Department::create($validated);

        return redirect()->back()->with('success', 'Department created successfully!');
    }

    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->back()->with('error', 'Cannot delete admin user!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
