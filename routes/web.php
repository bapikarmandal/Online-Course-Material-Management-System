<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\Auth\LoginController;

// Landing page
Route::get('/', function () {
    return view('college_landing');
})->name('landing');

// Auth
Auth::routes(['verify' => false]);

// Redirect after login based on role
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Admin
Route::middleware(['auth', 'user-role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::patch('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::patch('/users/{id}/toggle', [AdminController::class, 'toggleUserStatus'])->name('users.toggle');
    Route::get('/materials', [AdminController::class, 'materials'])->name('materials');
    Route::put('/materials/{id}', [AdminController::class, 'updateMaterial'])->name('materials.update');
    Route::delete('/materials/{id}', [AdminController::class, 'deleteMaterial'])->name('materials.delete');
    Route::get('/institutes', [AdminController::class, 'institutes'])->name('institutes');
    Route::post('/institutes', [AdminController::class, 'storeInstitute'])->name('institutes.store');
    Route::put('/institutes/{id}', [AdminController::class, 'updateInstitute'])->name('institutes.update');
    Route::delete('/institutes/{id}', [AdminController::class, 'deleteInstitute'])->name('institutes.delete');
    Route::get('/departments', [AdminController::class, 'departments'])->name('departments');
    Route::post('/departments', [AdminController::class, 'storeDepartment'])->name('departments.store');
    Route::put('/departments/{id}', [AdminController::class, 'updateDepartment'])->name('departments.update');
    Route::delete('/departments/{id}', [AdminController::class, 'deleteDepartment'])->name('departments.destroy');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
});

// Faculty
Route::middleware(['auth', 'user-role:faculty'])->prefix('faculty')->name('faculty.')->group(function () {
    Route::get('/dashboard', [FacultyController::class, 'index'])->name('dashboard');
    Route::get('/materials/create', [FacultyController::class, 'create'])->name('materials.create');
    Route::post('/materials', [FacultyController::class, 'store'])->name('materials.store');
    Route::get('/materials/{material}/edit', [FacultyController::class, 'edit'])->name('materials.edit');
    Route::put('/materials/{material}', [FacultyController::class, 'update'])->name('materials.update');
    Route::delete('/materials/{material}', [FacultyController::class, 'destroy'])->name('materials.destroy');
});

// Public material routes

Route::middleware('auth')->group(function () {
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
    Route::get('/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.download');
});

// API
Route::get('/api/departments', function (\Illuminate\Http\Request $request) {
    if ($request->filled('institute_id')) {
        return \App\Models\Department::where('institute_id', $request->institute_id)->get();
    }
    return response()->json([]);
});