<?php

namespace App\Http\Controllers\API\Attendance;

use App\Models\Student;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function searchForAttendance(Request $request)
    {
        try {
            $search = $request->get('search', '');
            $limit = $request->get('limit', 20);

            if (strlen($search) < 2) {
                return response()->json([
                    'status' => 'success',
                    'data' => []
                ]);
            }

            $currentAcademicYear = AcademicYear::where('is_active', true)->first();
            
            $students = Student::whereHas('student_histories', function($query) use ($currentAcademicYear) {
                                 $query->where('academic_year_id', $currentAcademicYear->id)
                                       ->where('status', 'active');
                             })
                             ->where(function($query) use ($search) {
                                 $query->where('name', 'LIKE', "%{$search}%")
                                       ->orWhere('nis', 'LIKE', "%{$search}%");
                             })
                             ->with(['student_histories' => function($query) use ($currentAcademicYear) {
                                 $query->where('academic_year_id', $currentAcademicYear->id)
                                       ->where('status', 'active')
                                       ->with('groups');
                             }])
                             ->limit($limit)
                             ->get()
                             ->map(function($student) {
                                 $currentHistory = $student->student_histories->first();
                                 return [
                                     'id' => $student->id,
                                     'name' => $student->name,
                                     'nis' => $student->nis,
                                     'photo' => $student->photo,
                                     'class' => $currentHistory->group->name ?? '-'
                                 ];
                             });

            return response()->json([
                'status' => 'success',
                'data' => $students
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mencari siswa: ' . $e->getMessage()
            ], 500);
        }
    }
}
