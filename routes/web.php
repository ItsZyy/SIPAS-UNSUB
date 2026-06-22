<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('splash');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin,operator'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
    Route::patch('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
    Route::get('/settings/security', [SettingsController::class, 'security'])->name('settings.security');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
    Route::get('/settings/theme', [SettingsController::class, 'theme'])->name('settings.theme');
    Route::put('/settings/theme', [SettingsController::class, 'updateTheme'])->name('settings.update-theme');
    Route::post('/settings/toggle-theme', [SettingsController::class, 'toggleTheme'])->name('settings.toggle-theme');

    Route::post('/settings/keep-alive', [SettingsController::class, 'keepAlive'])->name('settings.keep-alive');
    Route::post('/auto-logout', [SettingsController::class, 'autoLogout'])->name('auto-logout');

    Route::middleware('role:admin')->group(function () {
        Route::get('/settings/system', [SettingsController::class, 'system'])->name('settings.system');
        Route::put('/settings/system', [SettingsController::class, 'updateSystemSettings'])->name('settings.update-system');
    });
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

    Route::get('/admin/archives/{archive}/download', [App\Http\Controllers\ArchiveController::class, 'download'])
        ->middleware('role:admin,operator')
        ->name('archives.download');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])
        ->middleware('role:admin,operator')
        ->name('about');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/activity-logs', [App\Http\Controllers\ActivityLogController::class, 'index'])
        ->name('activity-logs.index');
    Route::delete('/admin/activity-logs/selected/destroy', [App\Http\Controllers\ActivityLogController::class, 'destroySelected'])
        ->name('activity-logs.destroy-selected');
    Route::delete('/admin/activity-logs/all/destroy', [App\Http\Controllers\ActivityLogController::class, 'destroyAll'])
        ->name('activity-logs.destroy-all');
    Route::delete('/admin/activity-logs/{activityLog}', [App\Http\Controllers\ActivityLogController::class, 'destroy'])
        ->name('activity-logs.destroy');

    Route::get('/admin/system-logs', [App\Http\Controllers\ActivityLogController::class, 'systemIndex'])
        ->name('system-logs.index');
    Route::delete('/admin/system-logs/selected/destroy', [App\Http\Controllers\ActivityLogController::class, 'systemDestroySelected'])
        ->name('system-logs.destroy-selected');
    Route::delete('/admin/system-logs/all/destroy', [App\Http\Controllers\ActivityLogController::class, 'systemDestroyAll'])
        ->name('system-logs.destroy-all');
    Route::delete('/admin/system-logs/{activityLog}', [App\Http\Controllers\ActivityLogController::class, 'systemDestroy'])
        ->name('system-logs.destroy');

    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])
        ->name('users.index');
    Route::get('/admin/users/create', [App\Http\Controllers\UserController::class, 'create'])
        ->name('users.create');
    Route::post('/admin/users', [App\Http\Controllers\UserController::class, 'store'])
        ->name('users.store');
    Route::get('/admin/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])
        ->name('users.edit');
    Route::put('/admin/users/{user}', [App\Http\Controllers\UserController::class, 'update'])
        ->name('users.update');
    Route::get('/admin/users/{user}/reset-password', [App\Http\Controllers\UserController::class, 'editPassword'])
        ->name('users.reset-password');
    Route::put('/admin/users/{user}/reset-password', [App\Http\Controllers\UserController::class, 'updatePassword'])
        ->name('users.update-password');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])
        ->name('users.destroy');
});

require __DIR__.'/auth.php';
