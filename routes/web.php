<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AuthController; // If you have a custom AuthController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Landing Page (The College Website View)
Route::get('/', function () {
    return view('college_landing');
})->name('landing');

// 2. Authentication Routes (Laravel Default)
Auth::routes();

// 3. Student / General Dashboard (The 'home' route)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 4. Admin Routes
Route::middleware(['auth', 'user-role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    
    // Admin Material Management
    Route::get('/admin/materials', [AdminController::class, 'materials'])->name('admin.materials');
    Route::delete('/admin/materials/{id}', [AdminController::class, 'deleteMaterial'])->name('admin.materials.delete');
    
    // Admin Institutes & Departments
    Route::get('/admin/institutes', [AdminController::class, 'institutes'])->name('admin.institutes');
    Route::post('/admin/institutes', [AdminController::class, 'storeInstitute'])->name('admin.institutes.store');
    Route::put('/admin/institutes/{id}', [AdminController::class, 'updateInstitute']);
    Route::delete('/admin/institutes/{id}', [AdminController::class, 'deleteInstitute'])->name('admin.institutes.delete');

    Route::get('/admin/departments', [AdminController::class, 'departments'])->name('admin.departments');
    Route::post('/admin/departments', [AdminController::class, 'storeDepartment'])->name('admin.departments.store');
    Route::put('/admin/departments/{id}', [AdminController::class, 'updateDepartment']);
    Route::delete('/admin/departments/{id}', [AdminController::class, 'deleteDepartment'])->name('admin.departments.destroy');
});

// 5. Faculty Routes
Route::middleware(['auth', 'user-role:faculty'])->group(function () {
    Route::get('/faculty/dashboard', [FacultyController::class, 'index'])->name('faculty.dashboard');
    Route::get('/faculty/materials/create', [FacultyController::class, 'create'])->name('faculty.materials.create');
    Route::post('/faculty/materials', [FacultyController::class, 'store'])->name('faculty.materials.store');
    Route::delete('/faculty/materials/{id}', [FacultyController::class, 'destroy'])->name('faculty.materials.destroy');
});

// 6. Public Material Routes (For E-Learning)
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create')->middleware('auth'); // Only logged in can upload
Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store')->middleware('auth');
Route::get('/materials/{id}', [MaterialController::class, 'show'])->name('materials.show');
Route::get('/materials/download/{id}', [MaterialController::class, 'download'])->name('materials.download');
Route::delete('/materials/{id}', [MaterialController::class, 'destroy'])->name('materials.destroy')->middleware('auth');

// 7. API Routes for Dropdowns (AJAX)
Route::get('/api/departments', function(Illuminate\Http\Request $request) {
    $institute_id = $request->institute_id;
    if ($institute_id) {
        return \App\Models\Department::where('institute_id', $institute_id)->get();
    }
    return [];
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
