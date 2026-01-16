<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// SPMB Routes (formerly PPDB)
Route::get('/spmb', [PpdbController::class, 'index'])->name('spmb.index');
Route::post('/spmb', [PpdbController::class, 'store'])->name('spmb.store');
Route::get('/spmb/cek-status', [PpdbController::class, 'showCheckStatus'])->name('spmb.status');
Route::post('/spmb/cek-status', [PpdbController::class, 'checkStatus'])->name('spmb.check_status');

// SPP Routes
Route::get('/cek-spp', [SppController::class, 'index'])->name('check.spp');
Route::post('/cek-spp', [SppController::class, 'check'])->name('check.spp_process');

// Auth Routes
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('login.perform');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// Halaman Guru (Public)
Route::get('/guru', [App\Http\Controllers\TeacherPublicController::class, 'index'])->name('teachers.public');

// Routes untuk Admin (Dilindungi Middleware Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Resource Routes
    Route::resource('teachers', \App\Http\Controllers\TeacherController::class);
    Route::resource('students', \App\Http\Controllers\StudentController::class);
    Route::resource('classes', \App\Http\Controllers\SchoolClassController::class);
    Route::resource('galleries', \App\Http\Controllers\GalleryController::class);
    Route::resource('news', \App\Http\Controllers\NewsController::class);
    
    // SPMB Admin Routes
    Route::prefix('admin/spmb')->name('spmb.admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ApplicantController::class, 'index'])->name('index');
        Route::get('/{applicant}', [\App\Http\Controllers\ApplicantController::class, 'show'])->name('show');
        Route::patch('/{applicant}/status', [\App\Http\Controllers\ApplicantController::class, 'updateStatus'])->name('update_status');
        Route::delete('/{applicant}', [\App\Http\Controllers\ApplicantController::class, 'destroy'])->name('destroy');
    });
    
    // SPP Admin Routes
    Route::prefix('admin/spp')->name('spp.admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SppAdminController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\SppAdminController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\SppAdminController::class, 'store'])->name('store');
        Route::get('/bulk-create', [\App\Http\Controllers\SppAdminController::class, 'bulkCreate'])->name('bulk_create');
        Route::post('/bulk-store', [\App\Http\Controllers\SppAdminController::class, 'bulkStore'])->name('bulk_store');
        Route::get('/{sppInvoice}/edit', [\App\Http\Controllers\SppAdminController::class, 'edit'])->name('edit');
        Route::put('/{sppInvoice}', [\App\Http\Controllers\SppAdminController::class, 'update'])->name('update');
        Route::delete('/{sppInvoice}', [\App\Http\Controllers\SppAdminController::class, 'destroy'])->name('destroy');
        Route::patch('/{sppInvoice}/mark-paid', [\App\Http\Controllers\SppAdminController::class, 'markPaid'])->name('mark_paid');
    });
    
    // Settings Routes
    Route::get('/admin/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::put('/admin/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
});
