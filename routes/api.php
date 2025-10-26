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


Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware(['auth:sanctum'])->prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});


Route::middleware(['auth:sanctum'])->prefix('attendance')->group(function () {
    // Dashboard Statistics
    Route::get('/statistics', [DashboardController::class, 'getTodayStatistics']);
    
    // Attendance List with filters
    Route::get('/today', [AttendanceController::class, 'getTodayAttendances']);
    
    // Manual Attendance
    // Route::post('/manual', [AttendanceController::class, 'manualAttendance']);
    Route::post('/manual/sick-excused', [AttendanceController::class, 'manualSickExcused']);
    
    // RFID Attendance
    Route::post('/rfid', [AttendanceController::class, 'rfidAttendance']);
    
    // NIS-based Attendance
    Route::post('/nis', [AttendanceController::class, 'nisBased']);
    
    // Student search for attendance
    Route::get('/students/search', [StudentController::class, 'searchForAttendance']);
    
    // Current attendance info (untuk display saat RFID tap)
    Route::get('/current-student/{cardUid}', [AttendanceController::class, 'getCurrentStudentInfo']);

    // Generate status endpoints (Manual trigger)
    Route::post('/generate-status', [AttendanceController::class, 'generateStatus']);

    // Index - Get all with filters, pagination, sorting
    Route::get('/', [AttendanceController::class, 'index']);
    
    // Show single
    Route::get('/detail/{id}', [AttendanceController::class, 'show']);
    
    // Update single
    Route::put('/{id}', [AttendanceController::class, 'update']);
    Route::patch('/{id}', [AttendanceController::class, 'update']);
    
    // Delete single
    Route::delete('/{id}', [AttendanceController::class, 'destroy']);
    
    // Approve single
    Route::post('/{id}/approve', [AttendanceController::class, 'approve']);

    // Bulk Approve
    Route::post('/bulk-approve', [AttendanceController::class, 'bulkApprove']);

    // Bulk Delete
    Route::post('/bulk-delete', [AttendanceController::class, 'bulkDelete']);
    
    // Bulk Update Status
    Route::post('/bulk-update-status', [AttendanceController::class, 'bulkUpdateStatus']);

    // Get filter options (for dropdowns)
    Route::get('/filter', [AttendanceController::class, 'getFilterOptions']);
    
    // Get summary statistics
    Route::get('/summary', [AttendanceController::class, 'getSummary']);
    
    // Export to Excel/CSV
    Route::get('/export', [AttendanceController::class, 'export']);
});







// Route::get('/health', function () {
//     return response()->json([
//         'status' => 'ok',
//         'timestamp' => now(),
//     ]);
// });
// // Route::get('/user', function (Request $request) {
// //     return $request->user();
// // })->middleware('auth:sanctum');

// // Public routes (no authentication)
// // Route::prefix('v1/auth')->group(function () {
// //     Route::post('login', [AuthController::class, 'login']);
// // });

// // auth
// Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
//     // Auth routes
//     Route::prefix('auth')->group(function () {
//         Route::post('logout', [AuthController::class, 'logout']);
//         Route::get('profile', [AuthController::class, 'profile']);
//         // Route::put('profile', [AuthController::class, 'updateProfile']);
//         Route::post('change-password', [AuthController::class, 'changePassword']);
//     });

//     // User Management routes (untuk admin)
//     // Route::apiResource('users', UserController::class);
//     // Route::post('users/{id}/reset-password', [UserController::class, 'resetPassword']);
    
// });
// // auth

// // Alternative routes tanpa authentication untuk testing
// // Route::prefix('v1/public')->group(function () {
// //     Route::apiResource('users', UserController::class);
// //     Route::post('users/{id}/reset-password', [UserController::class, 'resetPassword']);
// // });

// // student-histories
// Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
//     // Student History routes
//     Route::get('student-histories', [StudentHistoryController::class, 'index']);
//     Route::get('student-histories/{studentHistory}', [StudentHistoryController::class, 'show']);
//     Route::get('student-histories/filter/active', [StudentHistoryController::class, 'active']);
//     Route::get('student-histories/count/active', [StudentHistoryController::class, 'countActive']);
// });

// Route::prefix('v1/public')->group(function () {
//     Route::get('student-histories', [StudentHistoryController::class, 'index']);
//     Route::get('student-histories/{studentHistory}', [StudentHistoryController::class, 'show']);
//     Route::get('student-histories/filter/active', [StudentHistoryController::class, 'active']);
//     Route::get('student-histories/count/active', [StudentHistoryController::class, 'countActive']);
// });
// // student-histories



// // attendances
// Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
//     // Attendance CRUD routes
//     Route::apiResource('attendances', AttendanceController::class);
    
//     // Additional attendance routes
//     Route::post('attendances/bulk', [AttendanceController::class, 'bulkCreate']);
//     Route::patch('attendances/{id}/approve', [AttendanceController::class, 'approve']);
//     Route::patch('attendances/{id}/reject', [AttendanceController::class, 'reject']);
    
//     // Check-in/out routes for kiosk/mobile applications
//     // Route::post('check-in', [AttendanceController::class, 'checkIn']);
//     // Route::post('check-out', [AttendanceController::class, 'checkOut']);
    
// });

// Route::prefix('v1/public')->group(function () {
//     Route::apiResource('attendances', AttendanceController::class);
//     Route::post('attendances/bulk', [AttendanceController::class, 'bulkCreate']);
//     // Route::post('check-in', [AttendanceController::class, 'checkIn']);
//     // Route::post('check-out', [AttendanceController::class, 'checkOut']);
// });
// // attendances