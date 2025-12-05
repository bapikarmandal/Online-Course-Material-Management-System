<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Material routes
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
    Route::get('/materials/{material}/download', [MaterialController::class, 'download'])->name('materials.download');
    
    // Upload routes (Faculty and Admin only)
    Route::middleware('role:faculty,admin')->group(function () {
        Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
        Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
        Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
    });
    
    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/materials', [AdminController::class, 'materials'])->name('materials');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/institutes', [AdminController::class, 'institutes'])->name('institutes');
        Route::post('/institutes', [AdminController::class, 'storeInstitute'])->name('institutes.store');
        Route::post('/departments', [AdminController::class, 'storeDepartment'])->name('departments.store');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    });
});

// API routes for dynamic dropdowns
Route::get('/api/departments', [MaterialController::class, 'getDepartments'])->name('api.departments');
