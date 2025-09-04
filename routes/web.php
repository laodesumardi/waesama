<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicServiceRequestController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/berita', [WelcomeController::class, 'news'])->name('news.index');
Route::get('/berita/{id}', [WelcomeController::class, 'newsShow'])->name('news.show');
Route::get('/galeri', [WelcomeController::class, 'gallery'])->name('gallery.index');
Route::post('/service-request', [PublicServiceRequestController::class, 'store'])->name('public.service-request.store');

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage linked successfully.';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notification routes
    Route::get('notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('notifications/{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('notifications/send', [\App\Http\Controllers\NotificationController::class, 'sendNotification'])->name('notifications.send');
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
    Route::post('citizens-bulk-action', [CitizenController::class, 'bulkAction'])->name('citizens.bulk-action');
    Route::post('citizens-bulk-export', [CitizenController::class, 'bulkExport'])->name('citizens.bulk-export');
    // Service Requests
    Route::resource('service-requests', \App\Http\Controllers\ServiceRequestController::class);
    Route::get('service-requests-export', [\App\Http\Controllers\ServiceRequestController::class, 'export'])->name('service-requests.export');
    Route::post('service-requests/{serviceRequest}/process', [\App\Http\Controllers\ServiceRequestController::class, 'process'])->name('service-requests.process');
    Route::post('service-requests/{serviceRequest}/approve', [\App\Http\Controllers\ServiceRequestController::class, 'approve'])->name('service-requests.approve');
    Route::post('service-requests/{serviceRequest}/reject', [\App\Http\Controllers\ServiceRequestController::class, 'reject'])->name('service-requests.reject');
    Route::post('service-requests/{serviceRequest}/complete', [\App\Http\Controllers\ServiceRequestController::class, 'complete'])->name('service-requests.complete');

    // Bulk Actions for Service Requests
    Route::post('service-requests-bulk-approve', [\App\Http\Controllers\ServiceRequestController::class, 'bulkApprove'])->name('service-requests.bulk-approve');
    Route::post('service-requests-bulk-process', [\App\Http\Controllers\ServiceRequestController::class, 'bulkProcess'])->name('service-requests.bulk-process');
    Route::post('service-requests-bulk-reject', [\App\Http\Controllers\ServiceRequestController::class, 'bulkReject'])->name('service-requests.bulk-reject');
    Route::post('service-requests-bulk-delete', [\App\Http\Controllers\ServiceRequestController::class, 'bulkDelete'])->name('service-requests.bulk-delete');

    Route::post('service-requests/{serviceRequest}/update-status', [\App\Http\Controllers\ServiceRequestController::class, 'updateStatus'])->name('service-requests.update-status');


    // Documents Management
    Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class);
    Route::get('documents/{document}/download', [\App\Http\Controllers\Admin\DocumentController::class, 'download'])->name('documents.download');
    Route::get('documents/{document}/preview', [\App\Http\Controllers\Admin\DocumentController::class, 'preview'])->name('documents.preview');

    // Route::get('document-templates/{documentTemplate}/fields', [\App\Http\Controllers\DocumentTemplateController::class, 'getFields'])->name('document-templates.fields');
    // Route::post('document-templates/bulk-action', [\App\Http\Controllers\DocumentTemplateController::class, 'bulkAction'])->name('document-templates.bulk-action');
});

// Warga Routes
Route::prefix('warga')->name('warga.')->middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Warga\WargaController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [\App\Http\Controllers\Warga\WargaController::class, 'profil'])->name('profil');
    Route::post('/profil', [\App\Http\Controllers\Warga\WargaController::class, 'updateProfil'])->name('profil.update');
    Route::post('/profil/password', [\App\Http\Controllers\Warga\WargaController::class, 'updatePassword'])->name('profil.password');

    // Surat Routes
    Route::get('/surat', [\App\Http\Controllers\Warga\WargaSuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/list', [\App\Http\Controllers\Warga\WargaSuratController::class, 'list'])->name('surat.list');
    Route::get('/surat/create', [\App\Http\Controllers\Warga\WargaSuratController::class, 'create'])->name('surat.create');
    Route::post('/surat', [\App\Http\Controllers\Warga\WargaSuratController::class, 'store'])->name('surat.store');
    Route::get('/surat/{surat}', [\App\Http\Controllers\Warga\WargaSuratController::class, 'show'])->name('surat.show');
    Route::get('/surat/{surat}/download', [\App\Http\Controllers\Warga\WargaSuratController::class, 'download'])->name('surat.download');

    // Antrian Routes
    Route::get('/antrian', [\App\Http\Controllers\Warga\WargaAntrianController::class, 'index'])->name('antrian.index');
    Route::get('/antrian/create', [\App\Http\Controllers\Warga\WargaAntrianController::class, 'create'])->name('antrian.create');
    Route::post('/antrian', [\App\Http\Controllers\Warga\WargaAntrianController::class, 'store'])->name('antrian.store');
    Route::get('/antrian/{antrian}', [\App\Http\Controllers\Warga\WargaAntrianController::class, 'show'])->name('antrian.show');
    Route::post('/antrian/{antrian}/cancel', [\App\Http\Controllers\Warga\WargaAntrianController::class, 'cancel'])->name('antrian.cancel');

    // Pengaduan Routes
    Route::get('/pengaduan', [\App\Http\Controllers\Warga\WargaPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/create', [\App\Http\Controllers\Warga\WargaPengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [\App\Http\Controllers\Warga\WargaPengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{pengaduan}', [\App\Http\Controllers\Warga\WargaPengaduanController::class, 'show'])->name('pengaduan.show');

    // Berita Routes
    Route::get('/berita', [\App\Http\Controllers\Warga\WargaController::class, 'berita'])->name('berita.index');

    // Bookmark Routes
    Route::get('/bookmarks', [\App\Http\Controllers\Warga\BookmarkController::class, 'index'])->name('bookmarks.index');
});

require __DIR__ . '/auth.php';
