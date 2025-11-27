<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Attendance\ExportController;
use App\Http\Controllers\API\Attendance\StudentController;
use App\Http\Controllers\API\Attendance\ScheduleController;
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
    Route::get('/', [AttendanceController::class, 'index']);
    Route::get('/today', [AttendanceController::class, 'getTodayAttendances']);
    Route::get('/group', [AttendanceController::class, 'getGroupAttendances']);
    Route::get('/student/{id}', [AttendanceController::class, 'getAttendancesByStudent']);
    Route::get('/students', [StudentController::class, 'getForAddAttendance']);
    Route::get('/filter', [AttendanceController::class, 'getFilterOptions']);
    Route::get('/bulk/students', [AttendanceController::class, 'getStudentsForBulkAttendance']);
    
    Route::post('/rfid', [AttendanceController::class, 'rfidAttendance']);
    Route::post('/nis', [AttendanceController::class, 'nisBased']);
    Route::post('/', [AttendanceController::class, 'store']);
    Route::post('/generate-status', [AttendanceController::class, 'generateStatus']);
    Route::post('/bulk', [AttendanceController::class, 'bulkCreateAttendance']);
    
    Route::put('/{id}', [AttendanceController::class, 'update']);
    Route::delete('/{id}', [AttendanceController::class, 'destroy']);


    Route::get('/schedule', [ScheduleController::class, 'index']);
    Route::put('/schedule/{id}', [ScheduleController::class, 'update']);
    Route::post('/schedule', [ScheduleController::class, 'store']);
    Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy']);

    Route::get('/schedule-override', [ScheduleController::class, 'getScheduleOverrides']);
    Route::put('/schedule-override/{id}', [ScheduleController::class, 'updateScheduleOverride']);
    Route::post('/schedule-override', [ScheduleController::class, 'storeScheduleOverride']);
    Route::delete('/schedule-override/{id}', [ScheduleController::class, 'destroyScheduleOverride']);

    Route::get('/student-history', [StudentController::class, 'index']);
    

    Route::post('/export/by-date', [ExportController::class, 'exportByDate']);
    Route::post('/export/by-student', [ExportController::class, 'exportByStudent']);
    Route::post('/export/by-group', [ExportController::class, 'exportByGroup']);
    Route::get('/export/students', [StudentController::class, 'getForExportAttendance']);




    // Route::get('/current-student/{cardUid}', [AttendanceController::class, 'getCurrentStudentInfo']);

    // Manual Attendance
    // Route::post('/manual', [AttendanceController::class, 'manualAttendance']);
    // Route::post('/manual/sick-excused', [AttendanceController::class, 'manualSickExcused']);
    
    
    // // Student search for attendance

    
    // // Show single
    
    // // Update single
    // Route::patch('/{id}', [AttendanceController::class, 'update']);
    
    // // Delete single
    
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