<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkProgramsController;
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

// WorkPrograms 

Route::middleware('auth')->prefix('/dashboard/{department:slug}/workprograms')->name('dashboard.')->group(function () {
    Route::get('/', [WorkProgramsController::class, 'index'])
        ->name('workProgram.index');

    Route::get('/create', [WorkProgramsController::class, 'create'])
        ->middleware('role:managing director')
        ->name('workProgram.create');
        
    Route::get('/{workProgram}', [WorkProgramsController::class, 'detail'])
        ->name('workProgram.detail');

    Route::get('/{workProgram}/edit', [WorkProgramsController::class, 'edit'])
        ->middleware('role:managing director')
        ->name('workProgram.edit');

    Route::post('/', [WorkProgramsController::class, 'store'])
        ->middleware('role:managing director')
        ->name('workProgram.store');

    Route::put('/{workProgram}', [WorkProgramsController::class, 'update'])
        ->middleware('role:managing director')
        ->name('workProgram.update');

    Route::delete('/{workProgram}', [WorkProgramsController::class, 'destroy'])
        ->middleware('role:managing director')
        ->name('workProgram.destroy');
});

require __DIR__ . '/auth.php';
