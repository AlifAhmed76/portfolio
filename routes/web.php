<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProjectController;
use App\Http\Controllers\Frontend\SeoController;
use Illuminate\Support\Facades\Route;

// Public Portfolio Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [ContactController::class, 'submit'])->middleware('throttle:3,10')->name('contact.submit.home');
Route::post('contact', [ContactController::class, 'submit'])->middleware('throttle:3,10')->name('contact.submit');

Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Discovery & SEO
Route::get('sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('robots.txt', [SeoController::class, 'robots'])->name('seo.robots');

// Dynamic Custom Pages (Page Builder)
Route::get('{slug}', [PageController::class, 'show'])->name('pages.show');
