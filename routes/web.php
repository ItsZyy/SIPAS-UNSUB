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

require __DIR__.'/auth.php';
