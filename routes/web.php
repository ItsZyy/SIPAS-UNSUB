<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin,operator'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/categories', [App\Http\Controllers\CategoryController::class, 'index'])
        ->middleware('role:admin,operator')
        ->name('categories.index');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/categories/create', [App\Http\Controllers\CategoryController::class, 'create'])
            ->name('categories.create');
        Route::post('/admin/categories', [App\Http\Controllers\CategoryController::class, 'store'])
            ->name('categories.store');
        Route::get('/admin/categories/{category}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])
            ->name('categories.edit');
        Route::put('/admin/categories/{category}', [App\Http\Controllers\CategoryController::class, 'update'])
            ->name('categories.update');
        Route::delete('/admin/categories/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])
            ->name('categories.destroy');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/archives', [App\Http\Controllers\ArchiveController::class, 'index'])
        ->middleware('role:admin,operator')
        ->name('archives.index');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/archives/create', [App\Http\Controllers\ArchiveController::class, 'create'])
            ->name('archives.create');
        Route::post('/admin/archives', [App\Http\Controllers\ArchiveController::class, 'store'])
            ->name('archives.store');
        Route::get('/admin/archives/{archive}/edit', [App\Http\Controllers\ArchiveController::class, 'edit'])
            ->name('archives.edit');
        Route::put('/admin/archives/{archive}', [App\Http\Controllers\ArchiveController::class, 'update'])
            ->name('archives.update');
        Route::delete('/admin/archives/{archive}', [App\Http\Controllers\ArchiveController::class, 'destroy'])
            ->name('archives.destroy');
    });

    Route::get('/admin/archives/{archive}', [App\Http\Controllers\ArchiveController::class, 'show'])
        ->middleware('role:admin,operator')
        ->name('archives.show');
});

require __DIR__.'/auth.php';
