<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\MaterialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Landing Page
Route::get('/', function () {
    return view('college_landing');
})->name('landing');

// 2. Authentication Routes
Auth::routes();

// 3. Student / General Dashboard
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// 4. Admin Routes
Route::middleware(['auth', 'user-role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // Materials
    Route::get('/materials', [AdminController::class, 'materials'])->name('admin.materials');
    Route::put('/materials/{id}', [AdminController::class, 'updateMaterial'])->name('admin.materials.update');
    Route::delete('/materials/{id}', [AdminController::class, 'deleteMaterial'])->name('admin.materials.delete');

    // Institutes
    Route::get('/institutes', [AdminController::class, 'institutes'])->name('admin.institutes');
    Route::post('/institutes', [AdminController::class, 'storeInstitute'])->name('admin.institutes.store');
    Route::put('/institutes/{id}', [AdminController::class, 'updateInstitute'])->name('admin.institutes.update');
    Route::delete('/institutes/{id}', [AdminController::class, 'deleteInstitute'])->name('admin.institutes.delete');

    // Departments
    Route::get('/departments', [AdminController::class, 'departments'])->name('admin.departments');
    Route::post('/departments', [AdminController::class, 'storeDepartment'])->name('admin.departments.store');
    Route::put('/departments/{id}', [AdminController::class, 'updateDepartment'])->name('admin.departments.update');
    Route::delete('/departments/{id}', [AdminController::class, 'deleteDepartment'])->name('admin.departments.destroy');
});

// 5. Faculty Routes
Route::middleware(['auth', 'user-role:faculty'])->prefix('faculty')->group(function () {
    Route::get('/dashboard', [FacultyController::class, 'index'])->name('faculty.dashboard');
    Route::get('/materials/create', [FacultyController::class, 'create'])->name('faculty.materials.create');
    Route::post('/materials', [FacultyController::class, 'store'])->name('faculty.materials.store');
    Route::get('/materials/{material}/edit', [FacultyController::class, 'edit'])->name('faculty.materials.edit');
    Route::put('/materials/{material}', [FacultyController::class, 'update'])->name('faculty.materials.update');
    Route::delete('/materials/{material}', [FacultyController::class, 'destroy'])->name('faculty.materials.destroy');
});

// 6. Public Material Routes
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
Route::get('/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.download');

Route::middleware('auth')->group(function () {
    Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
    Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
    Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
});

// 7. API for department dropdown (AJAX)
Route::get('/api/departments', function (\Illuminate\Http\Request $request) {
    if ($request->filled('institute_id')) {
        return \App\Models\Department::where('institute_id', $request->institute_id)->get();
    }
    return response()->json([]);
});
