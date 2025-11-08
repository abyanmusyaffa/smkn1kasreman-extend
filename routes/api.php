<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Attendance\StudentController;
use App\Http\Controllers\API\Attendance\DashboardController;
use App\Http\Controllers\API\Attendance\AttendanceController;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'service' => 'attendance-api'
    ]);
});


Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
});


Route::middleware(['auth:sanctum'])->prefix('attendance')->group(function () {
    Route::get('/today', [AttendanceController::class, 'getTodayAttendances']);
    Route::get('/', [AttendanceController::class, 'index']);
    
    Route::post('/rfid', [AttendanceController::class, 'rfidAttendance']);
    Route::post('/nis', [AttendanceController::class, 'nisBased']);
    Route::post('/generate-status', [AttendanceController::class, 'generateStatus']);
    
    Route::get('/filter', [AttendanceController::class, 'getFilterOptions']);
    
    // Route::get('/statistics', [DashboardController::class, 'getTodayStatistics']);

    // Route::get('/current-student/{cardUid}', [AttendanceController::class, 'getCurrentStudentInfo']);

    // Manual Attendance
    // Route::post('/manual', [AttendanceController::class, 'manualAttendance']);
    // Route::post('/manual/sick-excused', [AttendanceController::class, 'manualSickExcused']);
    
    
    // // Student search for attendance
    // Route::get('/students/search', [StudentController::class, 'searchForAttendance']);

    
    // // Show single
    // Route::get('/detail/{id}', [AttendanceController::class, 'show']);
    
    // // Update single
    // Route::put('/{id}', [AttendanceController::class, 'update']);
    // Route::patch('/{id}', [AttendanceController::class, 'update']);
    
    // // Delete single
    // Route::delete('/{id}', [AttendanceController::class, 'destroy']);
    
    // // Approve single
    // Route::post('/{id}/approve', [AttendanceController::class, 'approve']);

    // // Bulk Approve
    // Route::post('/bulk-approve', [AttendanceController::class, 'bulkApprove']);

    // // Bulk Delete
    // Route::post('/bulk-delete', [AttendanceController::class, 'bulkDelete']);
    
    // // Bulk Update Status
    // Route::post('/bulk-update-status', [AttendanceController::class, 'bulkUpdateStatus']);

    // // Get summary statistics
    // // Route::get('/summary', [AttendanceController::class, 'getSummary']);
    
    // // Export to Excel/CSV
    // Route::get('/export', [AttendanceController::class, 'export']);
});