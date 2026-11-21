<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProjectController;
use Illuminate\Support\Facades\Route;

// Public Portfolio Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
