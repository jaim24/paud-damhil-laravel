<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// SPMB Routes (Public)
Route::get('/spmb', [PpdbController::class, 'index'])->name('spmb.index');
Route::get('/spmb/cek-status', [PpdbController::class, 'showCheckStatus'])->name('spmb.status');
Route::post('/spmb/cek-status', [PpdbController::class, 'checkStatus'])->name('spmb.check_status');
Route::get('/spmb/form', [PpdbController::class, 'showForm'])->name('spmb.form');
Route::post('/spmb/update', [PpdbController::class, 'update'])->name('spmb.update');
Route::get('/spmb/surat-pernyataan', [PpdbController::class, 'showUploadDeclaration'])->name('spmb.declaration.form');
Route::post('/spmb/surat-pernyataan', [PpdbController::class, 'storeDeclaration'])->name('spmb.declaration.store');
Route::get('/spmb/surat-pernyataan/cetak', [PpdbController::class, 'printDeclaration'])->name('spmb.declaration.print');
Route::get('/spmb/pembayaran', [PpdbController::class, 'showUploadPayment'])->name('spmb.payment.form');
Route::post('/spmb/pembayaran', [PpdbController::class, 'storePayment'])->name('spmb.payment.store');
Route::get('/spmb/success', function() { return view('spmb.success'); })->name('spmb.success');

// SPP Routes
Route::get('/cek-spp', [SppController::class, 'index'])->name('check.spp');
Route::post('/cek-spp', [SppController::class, 'check'])->name('check.spp_process');

// Language Route
Route::get('lang/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('lang.switch');

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
    
    // SPMB Admin Routes (Pendaftar)
    Route::prefix('admin/spmb')->name('spmb.admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ApplicantController::class, 'index'])->name('index');
        Route::get('/{applicant}', [\App\Http\Controllers\ApplicantController::class, 'show'])->name('show');
        Route::patch('/{applicant}/status', [\App\Http\Controllers\ApplicantController::class, 'updateStatus'])->name('update_status');
        Route::post('/{applicant}/upload-declaration', [\App\Http\Controllers\ApplicantController::class, 'uploadDeclaration'])->name('upload_declaration');
        Route::get('/{applicant}/print-declaration', [\App\Http\Controllers\ApplicantController::class, 'printDeclaration'])->name('print_declaration');
        Route::post('/{applicant}/mark-paid', [\App\Http\Controllers\ApplicantController::class, 'markPaid'])->name('mark_paid');
        Route::post('/{applicant}/accept', [\App\Http\Controllers\ApplicantController::class, 'accept'])->name('accept');
        Route::post('/{applicant}/reject', [\App\Http\Controllers\ApplicantController::class, 'reject'])->name('reject');
        Route::delete('/{applicant}', [\App\Http\Controllers\ApplicantController::class, 'destroy'])->name('destroy');
    });
    
    
    // SPP Admin Routes
    Route::prefix('admin/spp')->name('spp.admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SppAdminController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\SppAdminController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\SppAdminController::class, 'store'])->name('store');
        Route::get('/bulk-create', [\App\Http\Controllers\SppAdminController::class, 'bulkCreate'])->name('bulk_create');
        Route::post('/bulk-store', [\App\Http\Controllers\SppAdminController::class, 'bulkStore'])->name('bulk_store');
        Route::get('/student/{nisn}', [\App\Http\Controllers\SppAdminController::class, 'show'])->name('show');
        Route::post('/student/{nisn}/mark-all-paid', [\App\Http\Controllers\SppAdminController::class, 'markAllPaid'])->name('mark_all_paid');
        Route::get('/{sppInvoice}/edit', [\App\Http\Controllers\SppAdminController::class, 'edit'])->name('edit');
        Route::put('/{sppInvoice}', [\App\Http\Controllers\SppAdminController::class, 'update'])->name('update');
        Route::delete('/{sppInvoice}', [\App\Http\Controllers\SppAdminController::class, 'destroy'])->name('destroy');
        Route::patch('/{sppInvoice}/mark-paid', [\App\Http\Controllers\SppAdminController::class, 'markPaid'])->name('mark_paid');
    });
    
    // Settings Routes
    Route::get('/admin/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::put('/admin/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    
    // Profile Routes
    Route::get('/admin/profile/password', [\App\Http\Controllers\ProfileController::class, 'showChangePassword'])->name('profile.password');
    Route::put('/admin/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Waitlist Admin Routes
    Route::prefix('admin/waitlist')->name('waitlist.admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\WaitlistController::class, 'adminIndex'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\WaitlistController::class, 'show'])->name('show');
        Route::post('/{id}/schedule', [\App\Http\Controllers\WaitlistController::class, 'scheduleObservation'])->name('schedule');
        Route::post('/{id}/passed', [\App\Http\Controllers\WaitlistController::class, 'markPassed'])->name('passed');
        Route::post('/{id}/failed', [\App\Http\Controllers\WaitlistController::class, 'markFailed'])->name('failed');
        Route::post('/{id}/transfer', [\App\Http\Controllers\WaitlistController::class, 'transfer'])->name('transfer');
        Route::post('/batch-schedule', [\App\Http\Controllers\WaitlistController::class, 'batchSchedule'])->name('batch_schedule');
        Route::delete('/{id}', [\App\Http\Controllers\WaitlistController::class, 'cancel'])->name('cancel');
        Route::get('/{id}/whatsapp', [\App\Http\Controllers\WaitlistController::class, 'getWhatsappLink'])->name('whatsapp');
    });
    
    // Requirements Admin Routes (Persyaratan Pendaftaran)
    Route::prefix('admin/requirements')->name('requirements.')->group(function () {
        Route::get('/', [\App\Http\Controllers\RequirementController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\RequirementController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\RequirementController::class, 'store'])->name('store');
        Route::get('/{requirement}/edit', [\App\Http\Controllers\RequirementController::class, 'edit'])->name('edit');
        Route::put('/{requirement}', [\App\Http\Controllers\RequirementController::class, 'update'])->name('update');
        Route::delete('/{requirement}', [\App\Http\Controllers\RequirementController::class, 'destroy'])->name('destroy');
        Route::patch('/{requirement}/toggle', [\App\Http\Controllers\RequirementController::class, 'toggleActive'])->name('toggle');
    });

    // Attendance Admin Routes (Absensi Guru)
    Route::prefix('admin/attendances')->name('attendances.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AttendanceController::class, 'index'])->name('index');
        Route::get('/monthly', [\App\Http\Controllers\AttendanceController::class, 'monthly'])->name('monthly');
        Route::get('/teacher/{teacher}', [\App\Http\Controllers\AttendanceController::class, 'show'])->name('show');
        Route::post('/', [\App\Http\Controllers\AttendanceController::class, 'store'])->name('store');
        Route::get('/export', [\App\Http\Controllers\AttendanceController::class, 'export'])->name('export');
        Route::get('/export-pdf', [\App\Http\Controllers\AttendanceController::class, 'exportPdf'])->name('export_pdf');
        
        // Leave Requests
        Route::get('/leave-requests', [\App\Http\Controllers\AttendanceController::class, 'leaveRequests'])->name('leave_requests');
        Route::post('/leave-requests/{leaveRequest}/approve', [\App\Http\Controllers\AttendanceController::class, 'approveLeave'])->name('approve_leave');
        Route::post('/leave-requests/{leaveRequest}/reject', [\App\Http\Controllers\AttendanceController::class, 'rejectLeave'])->name('reject_leave');
    });

    // Password Resets
    Route::prefix('admin/password-resets')->name('admin.password-resets.')->group(function () {
        Route::get('/', [\App\Http\Controllers\PasswordResetController::class, 'index'])->name('index');
        Route::post('/{teacher}/reset', [\App\Http\Controllers\PasswordResetController::class, 'reset'])->name('reset');
    });
});

// Waitlist Public Routes
Route::get('/spmb/daftar-tunggu', [\App\Http\Controllers\WaitlistController::class, 'index'])->name('waitlist.index');
Route::post('/spmb/daftar-tunggu', [\App\Http\Controllers\WaitlistController::class, 'store'])->name('waitlist.store');
Route::get('/spmb/daftar-tunggu/berhasil', [\App\Http\Controllers\WaitlistController::class, 'success'])->name('waitlist.success');

