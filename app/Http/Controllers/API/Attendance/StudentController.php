<?php

namespace App\Http\Controllers\API\Attendance;

use App\Models\Group;
use App\Models\Student;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\StudentHistory;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function getForAddAttendance(Request $request) 
    {
        try {
            $studentHistories = StudentHistory::with('students', 'groups')
                                ->where('status', 'active')
                                ->get()
                                ->map(function ($item) {
                                    return [
                                        'id' => $item->id, 
                                        'label' => "{$item->students->nis} - {$item->students->name} - {$item->groups->name}",
                                    ];
                                });

            return response()->json([
                'status' => 'success',
                'data' => $studentHistories,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data siswa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getForExportAttendance(Request $request)
    {
        try {
            $academicYearId = $request->get('academic_year_id');
            $groupId = $request->get('group_id');

            if (!$academicYearId || !$groupId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tahun ajaran atau kelas tidak valid.',
                ], 404);
            }

            $studentHistories = StudentHistory::with('students', 'groups')
                                ->where('academic_year_id', $academicYearId)
                                ->where('group_id', $groupId)
                                ->get()
                                ->map(function ($item) {
                                    return [
                                        'value' => $item->id, 
                                        'label' => "{$item->students->name} - {$item->students->nis}",
                                    ];
                                });

            return response()->json([
                'status' => 'success',
                'data' => $studentHistories,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data siswa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $search = $request->get('search');
            $academicYearId = $request->get('academic_year_id');
            $groupId = $request->get('group_id');
            $status = $request->get('status');
            $perPage = $request->integer('per_page', 10);
            $sortField = $request->get('sort_field');
            $sortDirection = $request->get('sort_direction', 'asc');

            // $currentAcademicYear = $academicYearId
            //         ? AcademicYear::find($academicYearId)
            //         : AcademicYear::where('is_active', true)->first();

            // $currentGroup = $groupId
            //         ? Group::find($groupId)
            //         : Group::first();

            // if (!$currentAcademicYear || !$currentGroup) {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Tahun ajar atau kelas tidak ditemukan.',
            //     ], 404);
            // }

            $query = StudentHistory::query()
                ->with(['students', 'groups', 'academic_years']);
                // ->where('academic_year_id', $currentAcademicYear->id)
                // ->where('group_id', $currentGroup->id);

            if ($status !== null && $status !== '') {
                $query->where('status', $status);
            }

            if ($academicYearId !== null && $academicYearId !== '') {
                $query->where('academic_year_id', $academicYearId);
            }

            if ($groupId !== null && $groupId !== '') {
                $query->where('group_id', $groupId);
            }

            if ($search) {
                $query->whereHas('students', function ($sq) use ($search) {
                    $sq->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('nis', 'LIKE', "%{$search}%")
                        ->orWhere('card_uid', 'LIKE', "%{$search}%");
                });
            }

            $validSortFields = [
                'name' => 'students.name',
                'nis' => 'students.nis',
                'group' => 'groups.name',
                'academic_year' => 'academic_years.name',
                'semester' => 'academic_years.semester',
                'status' => 'student_histories.status',
            ];
            
            // Join tables for sorting
            $query->join('students', 'student_histories.student_id', '=', 'students.id')
                ->join('groups', 'student_histories.group_id', '=', 'groups.id')
                ->join('academic_years', 'student_histories.academic_year_id', '=', 'academic_years.id')
                ->select('student_histories.*');
            
            // Apply sorting
            if (array_key_exists($sortField, $validSortFields)) {
                $query->orderBy($validSortFields[$sortField], $sortDirection);
            } else {
                // Default sort by student name
                if (!$academicYearId || !$groupId) {
                    $query->orderBy('groups.name', $sortDirection);
                } else {
                    $query->orderBy('students.name', $sortDirection);
                }
            }

            $students = $query->paginate($perPage);

            $students->getCollection()->transform(function($student) {
                $lastHistory = StudentHistory::where('student_id', $student->student_id)
                    ->with(['groups', 'academic_years'])
                    ->orderBy('created_at', 'desc')
                    ->first();

                return [
                    'student_history_id' => $student->id,
                    'student_id' => $student->student_id,
                    'group_id' => $student->group_id,
                    'academic_year_id' => $student->academic_year_id,
                    'status' => $student->status,
                    'student' => [
                        'id' => $student->students->id,
                        'nis' => $student->students->nis,
                        'nisn' => $student->students->nisn ?? null,
                        'nik' => $student->students->nik ?? null,
                        'nokk' => $student->students->nokk ?? null,
                        'name' => $student->students->name,
                        'photo' => $student->students->photo ?? null,
                        'phone' => $student->students->phone ?? null,
                        'email' => $student->students->email ?? null,
                        'username' => $student->students->username,
                        // 'password' => $student->students->password,
                        'card_uid' => $student->students->card_uid ?? null,
                        'previous_school' => $student->students->previous_school ?? null,
                        'gender' => $student->students->gender,
                        'birth_place' => $student->students->birth_place,
                        'birth_date' => $student->students->birth_date,
                        'religion' => $student->students->religion ?? null,

                        'address' => $student->students->address ?? null,
                        'address_village' => $student->students->address_village ?? null,
                        'address_subdistrict' => $student->students->address_subdistrict ?? null,
                        'address_regency' => $student->students->address_regency ?? null,
                        'address_province' => $student->students->address_province ?? null,

                        'father_name' => $student->students->father_name ?? null,
                        'father_phone' => $student->students->father_phone ?? null,
                        'father_job' => $student->students->father_job ?? null,

                        'mother_name' => $student->students->mother_name ?? null,
                        'mother_phone' => $student->students->mother_phone ?? null,
                        'mother_job' => $student->students->mother_job ?? null,

                        'guardian_name' => $student->students->guardian_name ?? null,
                        'guardian_phone' => $student->students->guardian_phone ?? null,
                        'guardian_job' => $student->students->guardian_job ?? null,

                        'created_at' => $student->students->created_at ?? null,
                        'updated_at' => $student->students->updated_at ?? null,
                    ],
                    'group' => [
                        'id' => $student->groups->id,
                        'name' => $student->groups->name,
                    ],
                    'academic_year' => [
                        'id' => $student->academic_years->id,
                        'name' => $student->academic_years->name,
                        'semester' => $student->academic_years->semester,
                        'is_active' => $student->academic_years->is_active ?? false,
                    ],
                    'last_status' => $lastHistory ? [
                        'status' => $lastHistory->status,
                        'academic_year' => [
                            'id' => $lastHistory->academic_years->id,
                            'name' => $lastHistory->academic_years->name,
                            'semester' => $lastHistory->academic_years->semester ?? null,
                            'is_active' => $lastHistory->academic_years->is_active ?? false,
                        ],
                        'group' => [
                            'id' => $lastHistory->groups->id,
                            'name' => $lastHistory->groups->name,
                        ],
                    ] : null,
                    'created_at' => $student->created_at,
                    'updated_at' => $student->updated_at,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $students,
                'filters' => [
                    'academic_year_id' => $academicYearId,
                    'group_id' => $groupId,
                    // 'academic_year_id' => $currentAcademicYear->id,
                    // 'group_id' => $currentGroup->id,
                    'search' => $search,
                    'status' => $status,
                    'sort_field' => $sortField,
                    'sort_direction' => $sortDirection,
                    'per_page' => $perPage,
                ],
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data siswa: ' . $e->getMessage(),
            ], 500);
        }
    }
}
