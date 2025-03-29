<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Main dashboard (access only by user of its department or its role)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/supervisor', [DashboardController::class, 'showSupervisor'])
        ->middleware('role:supervisor')
        ->name('dashboard.supervisor');
    Route::get('/dashboard/{department:slug}', [DashboardController::class, 'show'])
        ->middleware('role:managing director|bph')
        ->name('dashboard');
});

// Department view (access only by managing director of dept, bph, or supervisor)
// TODO: Refactor this code

// Breeze profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';
