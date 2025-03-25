<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Main dashboard (access only by user of its department or its role)
Route::get('/dashboard/supervisor', [DepartmentController::class, 'showSupervisor'])
    ->middleware(['auth'])
    ->middleware('role:supervisor')
    ->name('dashboard.supervisor');
Route::get('/dashboard/{slug}', [DepartmentController::class, 'show'])
    ->middleware(['auth'])
    ->middleware('role:managing director|bph')
    ->name('dashboard');

// Department view (access only by managing director of dept, bph, or supervisor)
// TODO: Refactor this code

// Breeze profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';
