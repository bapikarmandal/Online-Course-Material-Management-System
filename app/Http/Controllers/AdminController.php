<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Material;
use App\Models\Institute;
use App\Models\Department;

class AdminController extends Controller
{
    // 1. Show the Admin Dashboard
    public function index()
    {
        $stats = [
            'total_users'       => User::count(),
            'total_materials'   => Material::count(),
            'total_institutes'  => Institute::count(),
            'total_departments' => Department::count(),
            'recent_materials'  => Material::with('user')->latest()->take(5)->get()
        ];
        
        return view('admin.dashboard')->with('stats', $stats);
    }

    // 2. Manage Users (Fixed Pagination)
    public function users()
    {
        // Changed all() to paginate(10)
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }
    
    // 3. Delete a User
    public function deleteUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User deleted successfully.');
    }

    // 4. Manage Materials (Fixed Pagination)
    public function materials()
    {
        // Changed get() to paginate(10)
        $materials = Material::with('user')->latest()->paginate(10);
        return view('admin.materials', compact('materials'));
    }

    public function deleteMaterial($id)
    {
        Material::destroy($id);
        return back()->with('success', 'Material deleted successfully.');
    }

    // 5. Manage Institutes (Fixed Pagination)
    public function institutes()
    {
        // Changed all() to paginate(10)
        $institutes = Institute::latest()->paginate(10);
        return view('admin.institutes', compact('institutes'));
    }

    public function storeInstitute(Request $request)
    {
        Institute::create($request->all());
        return back()->with('success', 'Institute added.');
    }

    public function deleteInstitute($id)
    {
        Institute::destroy($id);
        return back()->with('success', 'Institute deleted.');
    }

    // 6. Manage Departments (Fixed Pagination)
    public function departments()
    {
        // Changed get() to paginate(10)
        $departments = Department::with('institute')->paginate(10);
        $institutes = Institute::all(); // Needed for dropdown, keep as all()
        return view('admin.departments', compact('departments', 'institutes'));
    }

    public function storeDepartment(Request $request)
    {
        Department::create($request->all());
        return back()->with('success', 'Department added.');
    }

    public function deleteDepartment($id)
    {
        Department::destroy($id);
        return back()->with('success', 'Department deleted.');
    }
}