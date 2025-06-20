<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkProgramsController;
use App\Http\Controllers\WorkProgramsCommentController;
use App\Http\Controllers\ModViewController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkProgramCommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Notification dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/notifications', [DashboardController::class, 'showNotifications'])
        ->name('dashboard.notifications.index');
    Route::patch('/dashboard/notifications/{id}/read', [DashboardController::class, 'readNotification'])
        ->name('dashboard.notifications.markAsRead');
});

// Main dashboard (access only by user of its department or its role)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/supervisor', [DashboardController::class, 'showSupervisor'])
        ->middleware('role:supervisor')
        ->name('dashboard.supervisor');
    Route::get('/dashboard/{department:slug}', [DashboardController::class, 'show'])
        ->middleware('role:managing director|bph|pjs')
        ->name('dashboard');
});

// Work Programs
Route::middleware('auth')->prefix('/dashboard/{department:slug}/workprograms')->name('dashboard.')->group(function () {
    Route::get('/', [WorkProgramsController::class, 'index'])
        ->middleware('role:managing director|bph|pjs')
        ->name('workProgram.index');

    Route::get('/create', [WorkProgramsController::class, 'create'])
        ->middleware('role:managing director|bph|pjs')
        ->name('workProgram.create');

    Route::get('/{workProgram}', [WorkProgramsController::class, 'detail'])
        ->middleware('role:managing director|bph|pjs')
        ->name('workProgram.detail');

    Route::get('/{workProgram}/edit', [WorkProgramsController::class, 'edit'])
        ->middleware('role:managing director|bph|pjs')
        ->name('workProgram.edit');

    Route::post('/', [WorkProgramsController::class, 'store'])
        ->middleware('role:managing director|bph||pjs')
        ->name('workProgram.store');

    Route::put('/{workProgram}', [WorkProgramsController::class, 'update'])
        ->middleware('role:managing director|bph|pjs')
        ->name('workProgram.update');

    Route::delete('/{workProgram}', [WorkProgramsController::class, 'destroy'])
        ->middleware('role:managing director|bph|pjs')
        ->name('workProgram.destroy');
});

//Comment Routes
Route::middleware('auth')->group(function () {
    Route::prefix('/dashboard/{workProgram}/comments')
        ->middleware('role:managing director|bph|supervisor|pjs')
        ->name('dashboard.workProgram.')
        ->group(function () {
            Route::post('/', [WorkProgramCommentController::class, 'store'])->name('comment.store');
            Route::delete('/{comment}', [WorkProgramCommentController::class, 'destroy'])->name('comment.destroy');
        });
});

// Serving Private pdfs
Route::get('/pdf/{filename}', [PDFController::class, 'showPrivatePdf'])
    ->name('pdf.show'); // auth middleware is in the controller itself

// Supervisor ModView (access only by bph or supervisor)
Route::middleware('auth')
    ->prefix('/dashboard/mod-view')
    ->name('dashboard.modview.')
    ->group(function () {
        Route::get('/departments', [ModViewController::class, 'index'])
            ->middleware('role:bph|supervisor')
            ->name('department.index');

        Route::get('/{department:slug}', [ModViewController::class, 'showDepartment'])
            ->middleware('role:bph|supervisor')
            ->name('department.show');

        Route::get('/{department:slug}/workprograms/{workProgram}', [ModViewController::class, 'showWorkProgram'])
            ->middleware('role:bph|supervisor')
            ->name('workprogram.show');
    });

//Clear Session
Route::get('/session/clear/{key}', function ($key) {
    session()->forget($key);
    return response()->noContent();
})->name('session.clear');

// Breeze profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__ . '/auth.php';
