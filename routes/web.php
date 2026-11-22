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
Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Contact Inquiry Submission (with rate limiting)
Route::post('contact', [ContactController::class, 'submit'])->middleware('throttle:3,10')->name('contact.submit');

// Technical Insights & Blog
Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// SEO Feeds
Route::get('sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('robots.txt', [SeoController::class, 'robots'])->name('robots');

// Dynamic CMS Visual Pages
Route::get('{slug}', [PageController::class, 'show'])->name('pages.show');
