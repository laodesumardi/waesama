<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/berita', [WelcomeController::class, 'news'])->name('news.index');
Route::get('/berita/{id}', [WelcomeController::class, 'newsShow'])->name('news.show');
Route::get('/galeri', [WelcomeController::class, 'gallery'])->name('gallery.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,pegawai'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'userCreate'])->name('users.create');
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'userDestroy'])->name('users.destroy');
    
    // Activity Logs
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity-logs');
    
    // News Management
    Route::resource('news', NewsController::class);
    
    // Gallery Management
    Route::resource('galleries', GalleryController::class);
});

// Service Requests and Documents Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,pegawai'])->group(function () {
    // Citizens Management
    Route::resource('citizens', CitizenController::class);
    Route::get('citizens-export', [CitizenController::class, 'export'])->name('citizens.export');
    Route::post('citizens-import', [CitizenController::class, 'import'])->name('citizens.import');
    Route::get('citizens-template', [CitizenController::class, 'downloadTemplate'])->name('citizens.template');
    // Service Requests
    Route::resource('service-requests', \App\Http\Controllers\ServiceRequestController::class);
    Route::post('service-requests/{serviceRequest}/process', [\App\Http\Controllers\ServiceRequestController::class, 'process'])->name('service-requests.process');
    Route::post('service-requests/{serviceRequest}/approve', [\App\Http\Controllers\ServiceRequestController::class, 'approve'])->name('service-requests.approve');
    Route::post('service-requests/{serviceRequest}/reject', [\App\Http\Controllers\ServiceRequestController::class, 'reject'])->name('service-requests.reject');
    Route::post('service-requests/{serviceRequest}/complete', [\App\Http\Controllers\ServiceRequestController::class, 'complete'])->name('service-requests.complete');
    
    // Documents
    Route::resource('documents', \App\Http\Controllers\DocumentController::class);
    Route::get('documents/{document}/download', [\App\Http\Controllers\DocumentController::class, 'download'])->name('documents.download');
    Route::get('documents/{document}/preview', [\App\Http\Controllers\DocumentController::class, 'preview'])->name('documents.preview');
    Route::post('documents/{document}/deactivate', [\App\Http\Controllers\DocumentController::class, 'deactivate'])->name('documents.deactivate');
    Route::post('documents/{document}/activate', [\App\Http\Controllers\DocumentController::class, 'activate'])->name('documents.activate');
});

require __DIR__.'/auth.php';
