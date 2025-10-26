<?php

namespace App\Http\Controllers\API\Attendance;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\StudentHistory;
use App\Models\AttendanceSchedule;
use App\Http\Controllers\Controller;
use App\Models\AttendanceScheduleOverride;

class DashboardController extends Controller
{
    public function getTodayStatistics(Request $request)
    {
        try {
            $today = Carbon::today();
            $currentAcademicYear = AcademicYear::where('is_active', true)->first();
            
            if (!$currentAcademicYear) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tahun akademik aktif tidak ditemukan'
                ], 400);
            }

            // Total siswa aktif semester ini
            $totalActiveStudents = StudentHistory::where('academic_year_id', $currentAcademicYear->id)
                ->where('status', 'active')
                ->count();

            // Statistik presensi hari ini
            $todayAttendances = Attendance::whereDate('check_in_time', $today)
                ->with('student_histories')
                ->get();
            
            // Hitung yang terlambat berdasarkan schedule
            // $lateCount = $this->calculateLateAttendances($todayAttendances);
            
            $statistics = [
                'total_active_students' => $totalActiveStudents,
                'total_present_in' => $todayAttendances->whereNotNull('check_in_time')->count(),
                'total_present_out' => $todayAttendances->whereNotNull('check_out_time')->count(),
                'total_late' => $todayAttendances->where('status', 'late')->count(),
                'total_sick_excused' => $todayAttendances->whereIn('status', ['sick', 'excused'])->count(),
                'total_missing' => $todayAttendances->where('status', 'missing')->count(),
                'total_absent' => $totalActiveStudents - $todayAttendances->whereIn('status', ['present', 'late', 'sick', 'excused'])->count(),
                'attendance_percentage' => $totalActiveStudents > 0 ? 
                    round(($todayAttendances->whereIn('status', ['present', 'late'])->count() / $totalActiveStudents) * 100, 2) : 0
            ];

            return response()->json([
                'status' => 'success',
                'data' => $statistics
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil statistik: ' . $e->getMessage()
            ], 500);
        }
    }

    // private function calculateLateAttendances($attendances)
    // {
    //     $lateCount = 0;
    //     $today = Carbon::today();
    //     $dayName = strtolower($today->format('l')); // monday, tuesday, etc.

    //     // Cek schedule untuk hari ini
    //     $schedule = AttendanceSchedule::where('day', $dayName)->first();
    //     if (!$schedule) {
    //         return 0;
    //     }

    //     // Cek override schedule
    //     $override = AttendanceScheduleOverride::where('date', $today)->first();
    //     $checkInEnd = $override ? $override->check_in_end : $schedule->check_in_end;

    //     foreach ($attendances as $attendance) {
    //         if ($attendance->check_in_time) {
    //             $checkInTime = Carbon::parse($attendance->check_in_time)->format('H:i:s');
    //             if ($checkInTime > $checkInEnd) {
    //                 $lateCount++;
    //             }
    //         }
    //     }

    //     return $lateCount;
    // }
}
