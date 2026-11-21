<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CodeEditorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\IdentityController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PageBuilderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ThemeController;
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

    // Identity & Contacts
    Route::prefix('identity')->name('identity.')->group(function () {
        Route::get('/', [IdentityController::class, 'index'])->name('index');
        Route::put('profile', [IdentityController::class, 'updateProfile'])->name('profile.update');
        Route::put('contact', [IdentityController::class, 'updateContact'])->name('contact.update');
        Route::post('social', [IdentityController::class, 'storeSocialLink'])->name('social.store');
        Route::put('social/{socialLink}', [IdentityController::class, 'updateSocialLink'])->name('social.update');
        Route::delete('social/{socialLink}', [IdentityController::class, 'destroySocialLink'])->name('social.destroy');
    });

    // Media Library
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::post('upload', [MediaController::class, 'upload'])->name('upload');
        Route::delete('{media}', [MediaController::class, 'destroy'])->name('destroy');
    });

    // Projects & Case Studies
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('create', [ProjectController::class, 'create'])->name('create');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('{project}/edit', [ProjectController::class, 'edit'])->name('edit');
        Route::put('{project}', [ProjectController::class, 'update'])->name('update');
        Route::delete('{project}', [ProjectController::class, 'destroy'])->name('destroy');
        Route::post('{project}/featured', [ProjectController::class, 'toggleFeatured'])->name('featured');
    });

    // Skills & Categories
    Route::prefix('skills')->name('skills.')->group(function () {
        Route::get('/', [SkillController::class, 'index'])->name('index');
        Route::post('categories', [SkillController::class, 'storeCategory'])->name('category.store');
        Route::delete('categories/{category}', [SkillController::class, 'destroyCategory'])->name('category.destroy');
        Route::post('/', [SkillController::class, 'store'])->name('store');
        Route::put('{skill}', [SkillController::class, 'update'])->name('update');
        Route::delete('{skill}', [SkillController::class, 'destroy'])->name('destroy');
    });

    // Experience & Education
    Route::prefix('experience')->name('experience.')->group(function () {
        Route::get('/', [ExperienceController::class, 'index'])->name('index');
        Route::post('/', [ExperienceController::class, 'store'])->name('store');
        Route::put('{experience}', [ExperienceController::class, 'update'])->name('update');
        Route::delete('{experience}', [ExperienceController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('education')->name('education.')->group(function () {
        Route::post('/', [EducationController::class, 'store'])->name('store');
        Route::put('{education}', [EducationController::class, 'update'])->name('update');
        Route::delete('{education}', [EducationController::class, 'destroy'])->name('destroy');
    });

    // Services
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::put('{service}', [ServiceController::class, 'update'])->name('update');
        Route::delete('{service}', [ServiceController::class, 'destroy'])->name('destroy');
    });

    // Homepage Sections
    Route::prefix('sections')->name('sections.')->group(function () {
        Route::get('/', [SectionController::class, 'index'])->name('index');
        Route::put('{section}', [SectionController::class, 'update'])->name('update');
        Route::post('{section}/toggle', [SectionController::class, 'toggle'])->name('toggle');
    });

    // Theme Engine
    Route::prefix('themes')->name('themes.')->group(function () {
        Route::get('/', [ThemeController::class, 'index'])->name('index');
        Route::get('{theme}/preview', [ThemeController::class, 'preview'])->name('preview');
        Route::post('{theme}/publish', [ThemeController::class, 'publish'])->name('publish');
        Route::post('rollback/{revision}', [ThemeController::class, 'rollback'])->name('rollback');
    });

    // Trusted Code Editor
    Route::prefix('code-editor')->name('code-editor.')->group(function () {
        Route::get('/', [CodeEditorController::class, 'index'])->name('index');
        Route::get('open', [CodeEditorController::class, 'open'])->name('open');
        Route::post('save', [CodeEditorController::class, 'save'])->name('save');
        Route::post('restore', [CodeEditorController::class, 'restore'])->name('restore');
    });

    // Pages & Visual Page Builder
    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('index');
        Route::get('create', [PageController::class, 'create'])->name('create');
        Route::post('/', [PageController::class, 'store'])->name('store');
        Route::get('{page}/edit', [PageController::class, 'edit'])->name('edit');
        Route::put('{page}', [PageController::class, 'update'])->name('update');
        Route::delete('{page}', [PageController::class, 'destroy'])->name('destroy');

        Route::get('{page}/builder', [PageBuilderController::class, 'builder'])->name('builder');
        Route::get('{page}/builder/preview', [PageBuilderController::class, 'preview'])->name('builder.preview');
        Route::post('{page}/builder/draft', [PageBuilderController::class, 'saveDraft'])->name('builder.save-draft');
        Route::post('{page}/builder/publish', [PageBuilderController::class, 'publish'])->name('builder.publish');
        Route::get('{page}/builder/revisions', [PageBuilderController::class, 'revisions'])->name('builder.revisions');
        Route::post('{page}/builder/restore/{revision}', [PageBuilderController::class, 'restoreRevision'])->name('builder.restore');
    });
});
