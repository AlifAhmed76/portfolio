<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Admin routes
Route::middleware('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Content management routes will be registered in Phase 2
    // Appearance management routes will be registered in Phase 3 & 5
    // Pages & Builder routes will be registered in Phase 4
    // Inbox & SEO routes will be registered in Phase 7
    // Operations & Backups routes will be registered in Phase 8
});
