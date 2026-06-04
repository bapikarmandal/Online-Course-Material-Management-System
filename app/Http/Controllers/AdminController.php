<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Material;
use App\Models\Institute;
use App\Models\Department;
use App\Models\DownloadLog;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'       => User::count(),
            'total_materials'   => Material::count(),
            'total_institutes'  => Institute::count(),
            'total_departments' => Department::count(),
            'total_downloads'   => DownloadLog::count(),
            'recent_materials'  => Material::with(['uploader', 'institute', 'department'])
                                           ->latest()->take(5)->get(),
            'top_materials'     => Material::orderByDesc('downloads')->take(5)->get(),
            'recent_users'      => User::latest()->take(5)->get(),
            'faculty_count'     => User::where('role', 'faculty')->count(),
            'student_count'     => User::where('role', 'student')->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }
        $request->validate(['role' => 'required|in:student,faculty,admin']);
        $user->update(['role' => $request->role]);
        return back()->with('success', "User role updated to {$request->role}.");
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User account {$status}.");
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete an admin account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function materials()
    {
        $materials = Material::with(['uploader', 'institute', 'department'])
                             ->latest()->paginate(15);
        return view('admin.materials', compact('materials'));
    }

    public function updateMaterial(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'institute_id'  => 'required|exists:institutes,id',
            'department_id' => 'required|exists:departments,id',
            'semester'      => 'required|integer|min:1|max:6',
            'material_type' => 'required|in:study_material,previous_year_question,syllabus,assignment,other',
            'description'   => 'nullable|string',
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
        return back()->with('success', 'Material updated successfully.');
    }

    public function deleteMaterial($id)
    {
        $material = Material::findOrFail($id);
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        return back()->with('success', 'Material deleted successfully.');
    }

    public function institutes()
    {
        $institutes = Institute::withCount(['departments', 'materials'])->latest()->paginate(10);
        return view('admin.institutes', compact('institutes'));
    }

    public function storeInstitute(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:institutes,name', 'description' => 'nullable|string']);
        Institute::create($request->only('name', 'description'));
        return back()->with('success', 'Institute added successfully.');
    }

    public function updateInstitute(Request $request, $id)
    {
        $institute = Institute::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:institutes,name,' . $id, 'description' => 'nullable|string']);
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

    public function departments()
    {
        $departments = Department::with('institute')->withCount('materials')->paginate(15);
        $institutes  = Institute::all();
        return view('admin.departments', compact('departments', 'institutes'));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'institute_id' => 'required|exists:institutes,id', 'description' => 'nullable|string']);
        Department::create($request->only('name', 'institute_id', 'description'));
        return back()->with('success', 'Department added successfully.');
    }

    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255', 'institute_id' => 'required|exists:institutes,id', 'description' => 'nullable|string']);
        $department->update($request->only('name', 'institute_id', 'description'));
        return back()->with('success', 'Department updated successfully.');
    }

    public function deleteDepartment($id)
    {
        Department::findOrFail($id)->delete();
        return back()->with('success', 'Department deleted successfully.');
    }

    public function analytics()
    {
        $data = [
            'downloads_by_dept'   => Department::withCount('materials')->get(),
            'top_materials'       => Material::with('department')->orderByDesc('downloads')->take(10)->get(),
            'downloads_by_month'  => DownloadLog::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                                         ->whereYear('created_at', date('Y'))
                                         ->groupBy('month')->get(),
            'users_by_role'       => User::selectRaw('role, COUNT(*) as count')->groupBy('role')->get(),
        ];
        return view('admin.analytics', compact('data'));
    }
}