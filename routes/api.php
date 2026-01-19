<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceApiController;

/*
|--------------------------------------------------------------------------
| API Routes for Flutter App - Absensi Guru PAUD Damhil
|--------------------------------------------------------------------------
*/

// Public routes (no auth)
Route::post('/login', [AttendanceApiController::class, 'login']);
Route::post('/forgot-password', [AttendanceApiController::class, 'forgotPassword']);
Route::get('/settings', [AttendanceApiController::class, 'getSettings']); // Untuk ambil koordinat sekolah

// Protected routes (requires Bearer token)
Route::middleware('auth:sanctum')->group(function () {
    // Profile
    Route::get('/profile', [AttendanceApiController::class, 'profile']);
    Route::post('/logout', [AttendanceApiController::class, 'logout']);
    
    // Absensi
    Route::post('/absensi', [AttendanceApiController::class, 'storeAttendance']);
    Route::get('/absensi/history', [AttendanceApiController::class, 'attendanceHistory']);
    Route::get('/absensi/today', [AttendanceApiController::class, 'todayStatus']);
    
    // Izin/Sakit
    Route::post('/izin', [AttendanceApiController::class, 'submitLeave']);
    Route::get('/izin/history', [AttendanceApiController::class, 'leaveHistory']);
});
