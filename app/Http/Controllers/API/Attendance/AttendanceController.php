<?php

namespace App\Http\Controllers\API\Attendance;

use Carbon\Carbon;
use App\Models\Group;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\StudentHistory;
use App\Events\AttendanceRecorded;
use App\Models\AttendanceSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\AttendanceScheduleOverride;
use App\Services\WhatsAppService;

class AttendanceController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    protected function transformAttendance($attendance)
    {
        $studentHistory = $attendance->student_histories;
        $student = $studentHistory->students ?? null;
        $group = $studentHistory->groups ?? null;
    
        return [
            'id' => $attendance->id,
            'student' => $student ? [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'card_uid' => $student->card_uid,
                'photo' => $student->photo,
                'class' => $group->name ?? '-',
            ] : null,
            'date' => $attendance->check_in_time ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateString() : null,
            'check_in_time' => $attendance->check_in_time
                ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateTimeString()
                : null,
            'check_out_time' => $attendance->check_out_time
                ? Carbon::parse($attendance->check_out_time)->timezone('Asia/Jakarta')->toDateTimeString()
                : null,
            'status' => $attendance->status,
            'reason' => $attendance->reason,
            'file' => $attendance->file,
            'is_approved' => (bool) $attendance->is_approved,
            'note' => $attendance->note,
            'created_at' => $attendance->created_at,
            'updated_at' => $attendance->updated_at,
        ];
    }
    
    public function index(Request $request)
    {
        try {
            $search = $request->get('search', '');
            $sortField = $request->get('sort_field', 'name');
            $sortDirection = $request->get('sort_direction', 'asc');
            $perPage = $request->integer('per_page', 10);
            $date = $request->get('date');
            $statusFilter = $request->get('status');
            $groupId = $request->get('group_id');
            $academicYearId = $request->get('academic_year_id');
            $isApproved = $request->get('is_approved');

            $currentAcademicYear = $academicYearId
                ? AcademicYear::find($academicYearId)
                : AcademicYear::where('is_active', true)->first();

            $query = Attendance::with(['student_histories.students', 'student_histories.groups']);

            $query->when($currentAcademicYear, fn($q) => 
                $q->whereHas('student_histories', fn($sq) => 
                    $sq->where('academic_year_id', $currentAcademicYear->id)));

            $query->when($groupId, fn($q) => 
                $q->whereHas('student_histories', fn($sq) => $sq->where('group_id', $groupId)));

            $query->when($statusFilter, fn($q) =>
                is_array($statusFilter)
                    ? $q->whereIn('attendances.status', $statusFilter)
                    : $q->where('attendances.status', $statusFilter)
            );
            // $query->when($statusFilter, fn($q) => 
            //     is_array($statusFilter) ? $q->whereIn('status', $statusFilter) : $q->where('status', $statusFilter));

            $query->when($date, fn($q) => $q->whereDate('check_in_time', '=', Carbon::parse($date)->startOfDay()));

            $query->when($search, function ($q) use ($search) {
                $q->whereHas('student_histories.students', function ($sq) use ($search) {
                    $sq->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('nis', 'LIKE', "%{$search}%");
                });
            });

            $allowedSortFields = ['check_in_time', 'check_out_time', 'status'];
            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
            } elseif ($sortField === 'name') {
                $query->join('student_histories', 'student_histories.id', '=', 'attendances.student_history_id')
                    ->join('students', 'students.id', '=', 'student_histories.student_id')
                    ->orderBy('students.name', $sortDirection)
                    ->select('attendances.*');
            } elseif ($sortField === 'group') {
                $query->join('student_histories', 'student_histories.id', '=', 'attendances.student_history_id')
                    ->join('groups', 'groups.id', '=', 'student_histories.group_id')
                    ->orderBy('groups.name', $sortDirection)
                    ->select('attendances.*');
            } else {
                $query->orderBy('check_in_time', 'desc');
            }

            $attendances = $query->paginate($perPage);

            $attendances->getCollection()->transform(fn($a) => $this->transformAttendance($a));

            // $meta = [
            //     'total_present' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
            //         ->where('status', 'present')->count(),
            //     'total_late' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
            //         ->where('status', 'late')->count(),
            //     'total_missing' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
            //         ->where('status', 'missing')->count(),
            //     'total_sick' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
            //         ->where('status', 'sick')->count(),
            //     'total_excused' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
            //         ->where('status', 'excused')->count(),
            // ];

            return response()->json([
                'status' => 'success',
                'data' => $attendances,
                // 'meta' => $meta,
                'filters' => compact(
                    'academicYearId', 'groupId', 'statusFilter', 'date',
                    'search', 'sortField', 'sortDirection', 'perPage'
                ),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data presensi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getGroupAttendances(Request $request)
    {
        try {
            $academicYearId = $request->get('academic_year_id');
            $groupId = $request->get('group_id');
            $search = $request->get('search', '');
            $sortField = $request->get('sort_field', 'name');
            $sortDirection = $request->get('sort_direction', 'asc');
            $perPage = $request->integer('per_page', 10);

            $currentAcademicYear = $academicYearId
                ? AcademicYear::find($academicYearId)
                : AcademicYear::where('is_active', true)->first();

            $currentGroup = $groupId
                ? Group::find($groupId)
                : Group::first();

            if (!$currentAcademicYear || !$currentGroup) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tahun ajaran atau kelas tidak ditemukan.',
                ], 404);
            }

            $query = StudentHistory::query()
                ->with(['students', 'groups', 'academic_years'])
                ->where('academic_year_id', $currentAcademicYear->id)
                ->where('group_id', $currentGroup->id)
                ->when($search, function ($q) use ($search) {
                    $q->whereHas('students', function ($sq) use ($search) {
                        $sq->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('nis', 'LIKE', "%{$search}%");
                    });
                });

            // Sorting by name
            if ($sortField === 'name') {
                $query->join('students', 'students.id', '=', 'student_histories.student_id')
                    ->orderBy('students.name', $sortDirection)
                    ->select('student_histories.*');
            }

            $histories = $query->paginate($perPage);

            $studentHistoryIds = $histories->pluck('id');

            $attendances = Attendance::whereIn('student_history_id', $studentHistoryIds)
                ->get()
                ->groupBy('student_history_id');

            $data = $histories->getCollection()->map(function ($studentHistory) use ($attendances) {
                $records = $attendances->get($studentHistory->id, collect());
                $total = $records->count() ?: 1;

                $statusCounts = [
                    'present' => $records->where('status', 'present')->count(),
                    'late' => $records->where('status', 'late')->count(),
                    'missing' => $records->where('status', 'missing')->count(),
                    'sick' => $records->where('status', 'sick')->count(),
                    'excused' => $records->where('status', 'excused')->count(),
                ];

                // $presentCount = $statusCounts['present'] + $statusCounts['late'];
                // $attendancePercentage = $total > 0 ? round(($presentCount / $total) * 100, 2) : 0;

                return [
                    'student_history_id' => $studentHistory->id,
                    // 'student_id' => $studentHistory->students->id ?? null,
                    'name' => $studentHistory->students->name ?? '-',
                    'nis' => $studentHistory->students->nis ?? '-',
                    // 'photo' => $studentHistory->students->photo ?? null,
                    // 'group' => [
                    //     'id' => $studentHistory->groups->id ?? null,
                    //     'name' => $studentHistory->groups->name ?? '-',
                    // ],
                    // 'academic_year' => [
                    //     'id' => $studentHistory->academic_years->id ?? null,
                    //     'name' => $studentHistory->academic_years->name ?? '-',
                    //     'is_active' => $studentHistory->academic_years->is_active ?? false,
                    // ],
                    'status_counts' => $statusCounts,
                    // 'attendance_percentage' => $attendancePercentage,
                    // 'total_attendances' => $total,
                ];
            });

            $histories->setCollection($data);

            // Daftar kolom yang bisa disortir
            $allowedSortFields = [
                'name',
                'attendance_percentage',
                'present',
                'late',
                'missing',
                'sick',
                'excused',
            ];

            // Sorting untuk field selain 'name' (karena name sudah di-handle di query)
            if (in_array($sortField, $allowedSortFields) && $sortField !== 'name') {
                $collection = $histories->getCollection();

                // Tentukan apakah urutan descending
                $isDesc = strtolower($sortDirection) === 'desc';

                // Custom sorting logic
                $sorted = $collection->sortBy(function ($item) use ($sortField) {
                    // Jika yang di-sort adalah status tertentu
                    if (isset($item['status_counts'][$sortField])) {
                        return $item['status_counts'][$sortField];
                    }

                    // Kalau yang di-sort adalah field biasa
                    return $item[$sortField] ?? null;
                }, SORT_REGULAR, $isDesc)->values();

                $histories->setCollection($sorted);
            }

            return response()->json([
                'status' => 'success',
                'data' => $histories,
                // 'group_info' => [
                //     'id' => $currentGroup->id,
                //     'name' => $currentGroup->name,
                //     'academic_year' => [
                //         'id' => $currentAcademicYear->id,
                //         'name' => $currentAcademicYear->name,
                //         'is_active' => $currentAcademicYear->is_active,
                //     ],
                // ],
                'filters' => [
                    'academicYearId' => $currentAcademicYear->id, 
                    'groupId' => $currentGroup->id, 
                    'search' => $search, 
                    'sortField' => $sortField, 
                    'sortDirection' => $sortDirection, 
                    'perPage' => $perPage,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Get Group Attendances Error', [
                'academic_year_id' => $academicYearId ?? null,
                'group_id' => $groupId ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data presensi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getTodayAttendances(Request $request)
    {
        try {
            $date = $request->get('date', Carbon::now('Asia/Jakarta')->toDateString());
            $search = $request->get('search');
            $sortField = $request->get('sort_field', 'check_in_time');
            $sortDirection = $request->get('sort_direction', 'asc');
            $page = $request->integer('page');
            $perPage = $request->integer('per_page');

            $currentAcademicYear = AcademicYear::where('is_active', true)->firstOrFail();

            $query = Attendance::with(['student_histories.students', 'student_histories.groups'])
                ->whereDate('check_in_time', $date)
                ->whereHas('student_histories', function ($q) use ($currentAcademicYear) {
                    $q->where('academic_year_id', $currentAcademicYear->id)
                    ->where('status', 'active');
                });

            if ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('status', 'LIKE', "%{$search}%")
                        ->orWhereHas('student_histories.students', function($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%")
                              ->orWhere('nis', 'LIKE', "%{$search}%")
                              ->orWhere('card_uid', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('student_histories.groups', function($q) use ($search) {
                            $q->where('name', 'LIKE', "%{$search}%");
                        });
                });
            }

            $allowedSortFields = ['check_in_time', 'check_out_time', 'status'];
            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
            } elseif ($sortField === 'name') {
                $query->join('student_histories', 'student_histories.id', '=', 'attendances.student_history_id')
                    ->join('students', 'students.id', '=', 'student_histories.student_id')
                    ->orderBy('students.name', $sortDirection)
                    ->select('attendances.*');
            } elseif ($sortField === 'group') {
                $query->join('student_histories', 'student_histories.id', '=', 'attendances.student_history_id')
                    ->join('groups', 'groups.id', '=', 'student_histories.group_id')
                    ->orderBy('groups.name', $sortDirection)
                    ->select('attendances.*');
            } else {
                $query->orderBy('updated_at', 'desc');
            }

            $attendances = $query->paginate($perPage);

            $attendances->getCollection()->transform(fn($a) => $this->transformAttendance($a));

            $meta = [
                'total_active_students' => StudentHistory::where('academic_year_id', $currentAcademicYear->id)->where('status', 'active')->count(),
                'total_present_in' => Attendance::whereDate('check_in_time', $date)->whereNotNull('check_in_time')->count(),
                'total_present_out' => Attendance::whereDate('check_in_time', $date)->whereNotNull('check_out_time')->count(),
                'total_late' => Attendance::whereDate('check_in_time', $date)->where('status', 'late')->count(),
                'total_sick_excused' => Attendance::whereDate('check_in_time', $date)->whereIn('status', ['sick', 'excused'])->count(),
            ];

            return response()->json([
                'status' => 'success',
                'data' => $attendances,
                'meta' => $meta,
                'filters' => compact('date', 'search', 'sortField', 'sortDirection', 'perPage', 'page')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data presensi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getAttendancesByStudent(Request $request, $id)
    {
        try {
            $sortField = $request->get('sort_field', 'check_in_time');
            $sortDirection = $request->get('sort_direction', 'desc');
            $perPage = $request->integer('per_page', 10);
            $date = $request->get('date');
            $statusFilter = $request->get('status');
            $academicYearId = $request->get('academic_year_id');

            // Verify student history exists
            $studentHistory = StudentHistory::with(['students', 'groups', 'academic_years'])
                ->findOrFail($id);

            // Get current academic year if not specified
            $currentAcademicYear = $academicYearId
                ? AcademicYear::find($academicYearId)
                : AcademicYear::where('is_active', true)->first();

            $query = Attendance::with(['student_histories.students', 'student_histories.groups', 'student_histories.academic_years'])
                ->where('student_history_id', $id);

            // Filter by academic year
            $query->when($currentAcademicYear, function($q) use ($currentAcademicYear) {
                $q->whereHas('student_histories', fn($sq) => 
                    $sq->where('academic_year_id', $currentAcademicYear->id)
                );
            });

            // Filter by status
            $query->when($statusFilter, fn($q) =>
                is_array($statusFilter)
                    ? $q->whereIn('status', $statusFilter)
                    : $q->where('status', $statusFilter)
            );

            // Filter by specific date
            $query->when($date, fn($q) => 
                $q->whereDate('check_in_time', '=', Carbon::parse($date)->startOfDay())
            );

            // Filter by approval status
            // $query->when($isApproved !== null, fn($q) => 
            //     $q->where('is_approved', filter_var($isApproved, FILTER_VALIDATE_BOOLEAN))
            // );

            // Search by reason or note
            // $query->when($search, function ($q) use ($search) {
            //     $q->where(function($sq) use ($search) {
            //         $sq->where('reason', 'LIKE', "%{$search}%")
            //         ->orWhere('note', 'LIKE', "%{$search}%");
            //     });
            // });

            // Sorting
            $allowedSortFields = ['check_in_time', 'check_out_time', 'status', 'date'];
            if ($sortField === 'date') {
                $query->orderByRaw('DATE(check_in_time) ' . $sortDirection);
            } elseif (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
            } else {
                $query->orderBy('check_in_time', 'desc');
            }
            // $allowedSortFields = ['check_in_time', 'check_out_time', 'status'];
            // if (in_array($sortField, $allowedSortFields)) {
            //     $query->orderBy($sortField, $sortDirection);
            // } else {
            //     $query->orderBy('check_in_time', 'desc');
            // }

            $attendances = $query->paginate($perPage);

            // Transform data inline
            $attendances->getCollection()->transform(function($attendance) {
                return [
                    'id' => $attendance->id,
                    'student_history_id' => $attendance->student_history_id,
                    'date' => $attendance->check_in_time ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateString() : null,
                    'check_in_time' => $attendance->check_in_time 
                        ? Carbon::parse($attendance->check_in_time)->format('Y-m-d H:i:s')
                        : null,
                    'check_out_time' => $attendance->check_out_time 
                        ? Carbon::parse($attendance->check_out_time)->format('Y-m-d H:i:s')
                        : null,
                    'status' => $attendance->status,
                    'reason' => $attendance->reason,
                    'file' => $attendance->file 
                        ? Storage::url($attendance->file) 
                        : null,
                    'is_approved' => (bool) $attendance->is_approved,
                    'note' => $attendance->note,
                    'student' => [
                        'id' => $attendance->student_histories->students->id ?? null,
                        'name' => $attendance->student_histories->students->name ?? '-',
                        'nis' => $attendance->student_histories->students->nis ?? '-',
                        'photo' => $attendance->student_histories->students->photo ?? null,
                        'class' => $attendance->student_histories->groups->name ?? '-',
                    ],
                    // 'group' => [
                    //     'id' => $attendance->student_histories->groups->id ?? null,
                    //     'name' => $attendance->student_histories->groups->name ?? '-',
                    // ],
                    'created_at' => $attendance->created_at 
                        ? Carbon::parse($attendance->created_at)->format('Y-m-d H:i:s')
                        : null,
                    'updated_at' => $attendance->updated_at 
                        ? Carbon::parse($attendance->updated_at)->format('Y-m-d H:i:s')
                        : null,
                ];
            });

            // Base query untuk statistics
            $statsQuery = Attendance::where('student_history_id', $id);
            
            // Apply academic year filter to stats
            if ($currentAcademicYear) {
                $statsQuery->whereHas('student_histories', fn($sq) => 
                    $sq->where('academic_year_id', $currentAcademicYear->id)
                );
            }

            // Statistics untuk siswa ini
            $stats = [
                'total_present' => (clone $statsQuery)->where('status', 'present')->count(),
                'total_late' => (clone $statsQuery)->where('status', 'late')->count(),
                'total_missing' => (clone $statsQuery)->where('status', 'missing')->count(),
                'total_sick' => (clone $statsQuery)->where('status', 'sick')->count(),
                'total_excused' => (clone $statsQuery)->where('status', 'excused')->count(),
            ];

            return response()->json([
                'status' => 'success',
                'data' => $attendances,
                // 'student_info' => [
                //     'id' => $studentHistory->students->id ?? null,
                //     'name' => $studentHistory->students->name ?? '-',
                //     'nis' => $studentHistory->students->nis ?? '-',
                //     'photo' => $studentHistory->students->photo ?? null,
                //     'group' => [
                //         'id' => $studentHistory->groups->id ?? null,
                //         'name' => $studentHistory->groups->name ?? '-',
                //     ],
                //     'academic_year' => [
                //         'id' => $studentHistory->academic_years->id ?? $currentAcademicYear->id ?? null,
                //         'name' => $studentHistory->academic_years->name ?? $currentAcademicYear->name ?? '-',
                //         'is_active' => $studentHistory->academic_years->is_active ?? $currentAcademicYear->is_active ?? false,
                //     ],
                // ],
                'stats' => $stats,
                'filters' => [
                    'academicYearId' => $currentAcademicYear->id, 
                    'statusFilter' => $statusFilter, 
                    'date' => $date, 
                    'sortField' => $sortField, 
                    'sortDirection' => $sortDirection, 
                    'perPage' => $perPage,
                ],
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data riwayat siswa tidak ditemukan'
            ], 404);
            
        } catch (\Exception $e) {
            Log::error('Get Attendances By Student Error', [
                'student_history_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data presensi siswa: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getStudentsForBulkAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'academic_year_id' => 'required|exists:academic_years,id',
            'group_id' => 'required|exists:groups,id',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $academicYearId = $request->academic_year_id;
            $groupId = $request->group_id;
            $date = Carbon::parse($request->date)->startOfDay();

            // Validate schedule exists
            $schedule = $this->getCachedAttendanceSchedule($date);
            
            if (!$schedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal presensi tidak ditemukan untuk tanggal ini'
                ], 400);
            }

            // Get all active students in the group
            $studentHistories = StudentHistory::with('students:id,name,nis,photo')
                ->where('academic_year_id', $academicYearId)
                ->where('group_id', $groupId)
                ->where('status', 'active')
                ->get();

            if ($studentHistories->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada siswa aktif di kelas ini'
                ], 404);
            }

            // Get existing attendances for the date
            $studentHistoryIds = $studentHistories->pluck('id');
            
            $existingAttendances = Attendance::whereIn('student_history_id', $studentHistoryIds)
                ->whereBetween('check_in_time', [
                    $date->toDateTimeString(),
                    $date->copy()->endOfDay()->toDateTimeString()
                ])
                ->get()
                ->keyBy('student_history_id');

            // Transform data
            $students = $studentHistories->map(function ($history) use ($existingAttendances) {
                $attendance = $existingAttendances->get($history->id);
                
                return [
                    'student_history_id' => $history->id,
                    // 'student_id' => $history->students->id,
                    'name' => $history->students->name,
                    'nis' => $history->students->nis,
                    // 'photo' => $history->students->photo,
                    'has_attendance' => !is_null($attendance),
                    'attendance' => $attendance ? [
                        'id' => $attendance->id,
                        'check_in_time' => $attendance->check_in_time,
                        'check_out_time' => $attendance->check_out_time,
                        'status' => $attendance->status,
                    ] : null,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => [
                    'students' => $students,
                    'schedule' => [
                        'check_in_start' => $schedule->check_in_start,
                        'check_in_end' => $schedule->check_in_end,
                        'check_out_start' => $schedule->check_out_start,
                        'check_out_end' => $schedule->check_out_end,
                    ],
                    'summary' => [
                        'total_students' => $students->count(),
                        'has_attendance' => $students->where('has_attendance', true)->count(),
                        'not_attendance' => $students->where('has_attendance', false)->count(),
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data siswa: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getFilterOptions(Request $request)
    {
        try {
            // Academic Years
            $academicYears = AcademicYear::orderBy('name', 'desc')->get()->map(function($ay) {
                return [
                    'value' => $ay->id,
                    'label' => $ay->name . ' - Semester ' . $ay->semester,
                    'is_active' => $ay->is_active
                ];
            });

            // Groups/Classes
            $groups = Group::with('majors')
                ->orderBy('name')
                ->get()
                ->map(function($group) {
                    return [
                        'value' => $group->id,
                        'label' => $group->name,
                        'major' => $group->majors->name ?? null
                    ];
                });

            // Status options
            $statusOptions = [
                ['value' => 'present', 'label' => 'Hadir', 'color' => 'green'],
                ['value' => 'late', 'label' => 'Terlambat', 'color' => 'yellow'],
                ['value' => 'missing', 'label' => 'Tidak Presensi Pulang', 'color' => 'red'],
                ['value' => 'sick', 'label' => 'Sakit', 'color' => 'blue'],
                ['value' => 'excused', 'label' => 'Izin', 'color' => 'purple'],
            ];

            $statusStudents = [
                ['value' => 'active', 'label' => 'Aktif', 'color' => 'green'],
                ['value' => 'passed', 'label' => 'Selesai', 'color' => 'yellow'],
                ['value' => 'graduated', 'label' => 'Lulus', 'color' => 'red'],
                ['value' => 'transferred', 'label' => 'Pindah', 'color' => 'blue'],
                ['value' => 'dropped', 'label' => 'Keluar', 'color' => 'purple'],
            ];

            // Approval options
            $approvalOptions = [
                ['value' => '1', 'label' => 'Disetujui'],
                ['value' => '0', 'label' => 'Belum Disetujui'],
            ];

            return response()->json([
                'status' => 'success',
                'data' => [
                    'academic_years' => $academicYears,
                    'groups' => $groups,
                    'status_options' => $statusOptions,
                    'status_students' => $statusStudents,
                    'approval_options' => $approvalOptions,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil filter options: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'student_history_id' => 'required|exists:student_histories,id',
            'check_in_time' => 'required|date',
            'check_out_time' => 'nullable',
            'status' => 'required|in:present,late,missing,sick,excused',
            'file' => 'nullable|array',
            'file.content' => 'required_with:file|string',
            'file.name' => 'required_with:file|string',
            'file.mime_type' => 'required_with:file|string',
            'reason' => 'nullable|string|max:500',
            'is_approved' => 'nullable|boolean',
            'note' => 'nullable|string|max:500',
        ], [
            'student_history_id.required' => 'ID riwayat siswa harus diisi',
            'student_history_id.exists' => 'Data siswa tidak ditemukan',
            'check_in_time.required' => 'Waktu masuk harus diisi',
            'check_in_time.date' => 'Format waktu masuk tidak valid',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
            'file.image' => 'File harus berupa gambar',
            'file.mimes' => 'File harus berformat jpeg, jpg, atau png',
            'file.max' => 'Ukuran file maksimal 1MB',
            'reason.max' => 'Alasan maksimal 500 karakter',
            'note.max' => 'Catatan maksimal 500 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $status = $request->status;
            $isApproved = $request->is_approved ?? true;
            $note = $request->note;
            
            $checkInTime = Carbon::parse($request->check_in_time);
            
            // Handle check_out_time: empty string = missing, null = no change
            $checkOutTime = null;
            if ($request->has('check_out_time')) {
                if ($request->check_out_time === '' || $request->check_out_time === null) {
                    // Empty = set missing status
                    $checkOutTime = null;
                    if ($status === 'present' || $status === 'late') {
                        $status = 'missing';
                    }
                } else {
                    $checkOutTime = Carbon::parse($request->check_out_time);
                    
                    // Validate check_out_time after check_in_time
                    if ($checkOutTime && $checkInTime && $checkOutTime->lt($checkInTime)) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Waktu pulang harus setelah waktu masuk'
                        ], 400);
                    }
                }
            }

            $date = Carbon::parse($checkInTime)->startOfDay();

            // Get attendance schedule for validation
            $schedule = $this->getCachedAttendanceSchedule($date);
            
            if (!$schedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal presensi tidak ditemukan untuk tanggal ini'
                ], 400);
            }

            // Check for duplicate attendance
            $existingAttendance = Attendance::where('student_history_id', $request->student_history_id)
                ->whereDate('check_in_time', $date)
                ->first();

            if ($existingAttendance) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Presensi untuk siswa ini pada tanggal tersebut sudah ada'
                ], 400);
            }
            
            // sick dan excused HARUS ada reason
            $fileUrl = null;
            if (in_array($status, ['sick', 'excused'])) {
                // Validasi reason
                if (empty($request->reason)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Alasan harus diisi untuk status ' . 
                                ($status === 'sick' ? 'sakit' : 'izin')
                    ], 400);
                }

                // Handle file upload
                if ($request->has('file') && is_array($request->file)) {
                    // Validasi file structure
                    if (!isset($request->file['content']) || !isset($request->file['name']) || !isset($request->file['mime_type'])) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Format file tidak valid'
                        ], 400);
                    }

                    try {
                        // Decode base64 dan simpan file
                        $fileContent = base64_decode($request->file['content']);
                        
                        // Validasi apakah decode berhasil
                        if ($fileContent === false) {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'File tidak valid'
                            ], 400);
                        }

                        // Generate filename yang aman
                        $extension = pathinfo($request->file['name'], PATHINFO_EXTENSION);
                        $fileName = time() . '_' . uniqid() . '.' . $extension;
                        $filePath = 'attendance/' . $fileName;
                        
                        // Simpan file
                        Storage::disk('public')->put($filePath, $fileContent);
                        
                        // Update path
                        $fileUrl = $filePath;
                        
                        Log::info('File uploaded successfully', [
                            'file_path' => $filePath,
                            'file_size' => strlen($fileContent)
                        ]);
                        
                    } catch (\Exception $e) {
                        Log::error('File upload error', [
                            'error' => $e->getMessage()
                        ]);
                        
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Gagal mengupload file: ' . $e->getMessage()
                        ], 500);
                    }
                }
                
            } else {
                // present, late, missing TIDAK BOLEH ada reason dan file
                if ($request->filled('reason')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Alasan hanya dapat diisi untuk status sakit atau izin'
                    ], 400);
                }
                
                if ($request->has('file')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'File hanya dapat diupload untuk status sakit atau izin'
                    ], 400);
                }
            }

            // Note hanya untuk is_approved = false
            if ($isApproved && $request->filled('note')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Catatan hanya dapat diisi jika presensi tidak disetujui'
                ], 400);
            }

            // Clear note if approved
            if ($isApproved) {
                $note = null;
            }

            // ==========================================
            // VALIDATE TIME AGAINST SCHEDULE
            // ==========================================
            
            // Only validate time for present, late, missing status
            if (in_array($status, ['present', 'late', 'missing'])) {
                $checkInTimeOnly = Carbon::parse($checkInTime)->format('H:i:s');
                
                // Validate check-in time using existing method
                $validation = $this->validateAttendanceTime($checkInTimeOnly, $schedule, null);
                
                if (!$validation['allowed']) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $validation['message']
                    ], 400);
                }

                // Auto-detect if late based on schedule
                if ($checkInTimeOnly > $schedule->check_in_end) {
                    $status = 'late';
                } else if ($checkInTimeOnly >= $schedule->check_in_start && $checkInTimeOnly <= $schedule->check_in_end) {
                    // Only override to 'present' if user explicitly set it to 'present'
                    if ($status === 'present') {
                        $status = 'present';
                    }
                }

                // Validate check-out time if provided
                if ($checkOutTime) {
                    $checkOutTimeOnly = Carbon::parse($checkOutTime)->format('H:i:s');
                    
                    // Create dummy attendance object for validation
                    $dummyAttendance = new \stdClass();
                    $dummyAttendance->check_out_time = null;
                    
                    $checkOutValidation = $this->validateAttendanceTime($checkOutTimeOnly, $schedule, $dummyAttendance);
                    
                    if (!$checkOutValidation['allowed']) {
                        return response()->json([
                            'status' => 'error',
                            'message' => $checkOutValidation['message']
                        ], 400);
                    }
                }
            }

            // ==========================================
            // CREATE ATTENDANCE
            // ==========================================
            
            // Prepare insert data
            $insertData = [
                'student_history_id' => $request->student_history_id,
                'check_in_time' => $checkInTime,
                'check_out_time' => $checkOutTime,
                'status' => $status,
                'is_approved' => $isApproved,
                'note' => $note,
                'created_at' => Carbon::now('Asia/Jakarta'),
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ];

            // Add reason and file only for sick/excused
            if (in_array($status, ['sick', 'excused'])) {
                $insertData['reason'] = $request->reason;
                $insertData['file'] = $fileUrl;
            } else {
                $insertData['reason'] = null;
                $insertData['file'] = null;
            }

            // Insert attendance
            $attendanceId = DB::table('attendances')->insertGetId($insertData);

            // Get the created attendance with relations
            $attendance = Attendance::with(['student_histories.students', 'student_histories.groups'])
                ->findOrFail($attendanceId);

            DB::commit();

            // Log activity
            Log::info('Attendance created', [
                'attendance_id' => $attendanceId,
                'student_id' => $attendance->student_histories->students->id ?? null,
                'status' => $status,
                'created_by' => auth()->id(),
            ]);

            // Direct response
            return response()->json([
                'status' => 'success',
                'message' => 'Presensi berhasil dibuat',
                'data' => [
                    'id' => $attendance->id,
                    'student_history_id' => $attendance->student_history_id,
                    'check_in_time' => $attendance->check_in_time 
                        ? Carbon::parse($attendance->check_in_time)->format('Y-m-d H:i:s')
                        : null,
                    'check_out_time' => $attendance->check_out_time 
                        ? Carbon::parse($attendance->check_out_time)->format('Y-m-d H:i:s')
                        : null,
                    'status' => $attendance->status,
                    'reason' => $attendance->reason,
                    'file' => $attendance->file 
                        ? Storage::url($attendance->file) 
                        : null,
                    'is_approved' => (bool) $attendance->is_approved,
                    'note' => $attendance->note,
                    'student' => [
                        'id' => $attendance->student_histories->students->id ?? null,
                        'name' => $attendance->student_histories->students->name ?? '-',
                        'nis' => $attendance->student_histories->students->nis ?? '-',
                        'photo' => $attendance->student_histories->students->photo ?? null,
                    ],
                    'group' => [
                        'id' => $attendance->student_histories->groups->id ?? null,
                        'name' => $attendance->student_histories->groups->name ?? '-',
                    ],
                    'created_at' => $attendance->created_at 
                        ? Carbon::parse($attendance->created_at)->format('Y-m-d H:i:s')
                        : null,
                    'updated_at' => $attendance->updated_at 
                        ? Carbon::parse($attendance->updated_at)->format('Y-m-d H:i:s')
                        : null,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            
            // Delete uploaded file if exists
            if (isset($fileUrl) && $fileUrl && Storage::disk('public')->exists($fileUrl)) {
                Storage::disk('public')->delete($fileUrl);
            }
            
            Log::error('Create Attendance Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat presensi: ' . $e->getMessage()
            ], 500);
        }
    }
    public function bulkCreateAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'status' => 'required|in:present,late,missing',
            'student_history_ids' => 'required|array|min:1',
            'student_history_ids.*' => 'required|exists:student_histories,id',
        ], [
            'date.required' => 'Tanggal harus diisi',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
            'student_history_ids.required' => 'Pilih minimal 1 siswa',
            'student_history_ids.min' => 'Pilih minimal 1 siswa',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $date = Carbon::parse($request->date)->startOfDay();
            $status = $request->status;
            $studentHistoryIds = $request->student_history_ids;

            // Get schedule
            $schedule = $this->getCachedAttendanceSchedule($date);
            
            if (!$schedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal presensi tidak ditemukan untuk tanggal ini'
                ], 400);
            }

            // Check existing attendances
            $existingAttendances = Attendance::whereIn('student_history_id', $studentHistoryIds)
                ->whereBetween('check_in_time', [
                    $date->toDateTimeString(),
                    $date->copy()->endOfDay()->toDateTimeString()
                ])
                ->pluck('student_history_id')
                ->toArray();

            // Filter out students who already have attendance
            $newStudentHistoryIds = array_diff($studentHistoryIds, $existingAttendances);

            if (empty($newStudentHistoryIds)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Semua siswa yang dipilih sudah memiliki presensi hari ini'
                ], 400);
            }

            // Generate attendance times based on status
            $times = $this->generateAttendanceTimes($date, $schedule, $status);

            // Prepare bulk insert data
            $attendancesData = [];
            $now = Carbon::now('Asia/Jakarta');

            foreach ($newStudentHistoryIds as $studentHistoryId) {
                $attendancesData[] = [
                    'student_history_id' => $studentHistoryId,
                    'check_in_time' => $times['check_in_time'],
                    'check_out_time' => $times['check_out_time'],
                    'status' => $status,
                    'is_approved' => 1, // Auto approved for bulk
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Bulk insert
            DB::table('attendances')->insert($attendancesData);

            DB::commit();

            $skippedCount = count($existingAttendances);
            $createdCount = count($newStudentHistoryIds);

            return response()->json([
                'status' => 'success',
                'message' => "Berhasil menambahkan {$createdCount} presensi" . 
                           ($skippedCount > 0 ? ", {$skippedCount} siswa dilewati (sudah presensi)" : ""),
                'data' => [
                    'created' => $createdCount,
                    'skipped' => $skippedCount,
                    'total_selected' => count($studentHistoryIds),
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan presensi: ' . $e->getMessage()
            ], 500);
        }
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $attendance = Attendance::findOrFail($id);
            // $studentName = $attendance->student_histories->students->name ?? 'Unknown';
            
            $attendance->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "Presensi berhasil dihapus"
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus presensi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'check_in_time' => 'nullable|date',
            'check_out_time' => 'nullable',
            'status' => 'required|in:present,late,missing,sick,excused',
            'file' => 'nullable|array',
            'file.content' => 'required_with:file|string',
            'file.name' => 'required_with:file|string',
            'file.mime_type' => 'required_with:file|string',
            'reason' => 'nullable|string|max:500',
            'is_approved' => 'nullable|boolean',
            'note' => 'nullable|string|max:500',
        ], [
            'check_in_time.date' => 'Format waktu masuk tidak valid',
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
            'file.image' => 'File harus berupa gambar',
            'file.mimes' => 'File harus berformat jpeg, jpg, atau png',
            'file.max' => 'Ukuran file maksimal 1MB',
            'reason.max' => 'Alasan maksimal 500 karakter',
            'note.max' => 'Catatan maksimal 500 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Find attendance record
            $attendance = Attendance::with(['student_histories.students', 'student_histories.groups'])
                ->findOrFail($id);

            $status = $request->status;
            $isApproved = $request->is_approved ?? $attendance->is_approved;
            $note = $request->note ?? $attendance->note;
            
            $checkInTime = $request->check_in_time 
                ? Carbon::parse($request->check_in_time) 
                : $attendance->check_in_time;
            
            // Handle check_out_time: empty string = missing, null = no change
            $checkOutTime = null;
            if ($request->has('check_out_time')) {
                if ($request->check_out_time === '' || $request->check_out_time === null) {
                    // Empty = set missing status
                    $checkOutTime = null;
                    if ($status === 'present' || $status === 'late') {
                        $status = 'missing';
                    }
                } else {
                    $checkOutTime = Carbon::parse($request->check_out_time);
                    
                    // Validate check_out_time after check_in_time
                    if ($checkOutTime && $checkInTime && $checkOutTime->lt($checkInTime)) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Waktu pulang harus setelah waktu masuk'
                        ], 400);
                    }
                }
            } else {
                $checkOutTime = $attendance->check_out_time;
            }

            // Validate check-in time exists
            if (!$checkInTime) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Waktu masuk harus diisi'
                ], 400);
            }

            $date = Carbon::parse($checkInTime)->startOfDay();

            // Get attendance schedule for validation
            $schedule = $this->getCachedAttendanceSchedule($date);
            
            if (!$schedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal presensi tidak ditemukan untuk tanggal ini'
                ], 400);
            }
            
            // sick dan excused HARUS ada reason
            if (in_array($status, ['sick', 'excused'])) {
                // Validasi reason
                if (empty($request->reason)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Alasan harus diisi untuk status ' . 
                                ($status === 'sick' ? 'sakit' : 'izin')
                    ], 400);
                }

                // Initialize dengan file yang sudah ada (jika tidak ada upload baru)
                $fileUrl = $attendance->file;

                // Handle file upload baru
                if ($request->has('file') && is_array($request->file)) {
                    // Validasi file structure
                    if (!isset($request->file['content']) || !isset($request->file['name']) || !isset($request->file['mime_type'])) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Format file tidak valid'
                        ], 400);
                    }

                    try {
                        // Hapus file lama jika ada
                        if ($attendance->file && Storage::disk('public')->exists($attendance->file)) {
                            Storage::disk('public')->delete($attendance->file);
                        }

                        // Decode base64 dan simpan file baru
                        $fileContent = base64_decode($request->file['content']);
                        
                        // Validasi apakah decode berhasil
                        if ($fileContent === false) {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'File tidak valid'
                            ], 400);
                        }

                        // Generate filename yang aman
                        $extension = pathinfo($request->file['name'], PATHINFO_EXTENSION);
                        $fileName = time() . '_' . uniqid() . '.' . $extension;
                        $filePath = 'attendance/' . $fileName;
                        
                        // Simpan file
                        Storage::disk('public')->put($filePath, $fileContent);
                        
                        // Update path
                        $fileUrl = $filePath;
                        
                        Log::info('File uploaded successfully', [
                            'attendance_id' => $id,
                            'file_path' => $filePath,
                            'file_size' => strlen($fileContent)
                        ]);
                        
                    } catch (\Exception $e) {
                        Log::error('File upload error', [
                            'attendance_id' => $id,
                            'error' => $e->getMessage()
                        ]);
                        
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Gagal mengupload file: ' . $e->getMessage()
                        ], 500);
                    }
                }
                
            } else {
                // present, late, missing TIDAK BOLEH ada reason dan file
                if ($request->filled('reason')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Alasan hanya dapat diisi untuk status sakit atau izin'
                    ], 400);
                }
                
                if ($request->has('file')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'File hanya dapat diupload untuk status sakit atau izin'
                    ], 400);
                }

                // Set fileUrl ke null untuk status selain sick/excused
                $fileUrl = null;
                
                // Hapus file lama jika ada
                if ($attendance->file && Storage::disk('public')->exists($attendance->file)) {
                    Storage::disk('public')->delete($attendance->file);
                }
            }
            // if (in_array($status, ['sick', 'excused'])) {
            //     if (empty($request->reason)) {
            //         return response()->json([
            //             'status' => 'error',
            //             'message' => 'Alasan harus diisi untuk status ' . 
            //                        ($status === 'sick' ? 'sakit' : 'izin')
            //         ], 400);
            //     }

            //     // Validate file for sick/excused (optional but if provided must be valid)
            //     if (isset($validator['file'])) {
            //         if ($attendance->file) {
            //             Storage::disk('public')->delete($attendance->file);
            //         }

            //         $fileContent = base64_decode($validator['file']['content']);
            //         $fileName = time() . '_' . $validator['file']['name'];
            //         $filePath = 'attendance/' . $fileName;
                    
            //         Storage::disk('public')->put($filePath, $fileContent);
                    
            //         $validator['file'] = $filePath;
            //         unset($validator['file']);
            //     }
            //     // $fileUrl = $attendance->file;
                
            //     // if ($request->hasFile('file')) {
            //     //     if ($fileUrl && Storage::disk('public')->exists($fileUrl)) {
            //     //         Storage::disk('public')->delete($fileUrl);
            //     //     }


            //     //     $file = $request->file('file');
            //     //     $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            //     //     $fileUrl = $file->storeAs('attendance_files', $filename, 'public');
            //     // }
            // } else {
            //     // present, late, missing TIDAK BOLEH ada reason dan file
            //     if ($request->filled('reason')) {
            //         return response()->json([
            //             'status' => 'error',
            //             'message' => 'Alasan hanya dapat diisi untuk status sakit atau izin'
            //         ], 400);
            //     }
                
            //     if ($request->hasFile('file')) {
            //         return response()->json([
            //             'status' => 'error',
            //             'message' => 'File hanya dapat diupload untuk status sakit atau izin'
            //         ], 400);
            //     }

            //     // Clear reason and file if changing from sick/excused to other status
            //     $request->merge(['reason' => null]);
            //     $fileUrl = null;
                
            //     // Delete file if exists
            //     if ($attendance->file && Storage::disk('public')->exists($attendance->file)) {
            //         Storage::disk('public')->delete($attendance->file);
            //     }
            // }

            // Note hanya untuk is_approved = false
            if ($isApproved && $request->filled('note')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Catatan hanya dapat diisi jika presensi tidak disetujui'
                ], 400);
            }

            // Clear note if approved
            if ($isApproved) {
                $note = null;
            }

            // ==========================================
            // VALIDATE TIME AGAINST SCHEDULE
            // ==========================================
            
            // Only validate time for present, late, missing status
            if (in_array($status, ['present', 'late', 'missing'])) {
                $checkInTimeOnly = Carbon::parse($checkInTime)->format('H:i:s');
                
                // Validate check-in time using existing method
                $validation = $this->validateAttendanceTime($checkInTimeOnly, $schedule, null);
                
                if (!$validation['allowed']) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $validation['message']
                    ], 400);
                }

                // Auto-detect if late based on schedule
                if ($checkInTimeOnly > $schedule->check_in_end) {
                    $status = 'late';
                } else if ($checkInTimeOnly >= $schedule->check_in_start && $checkInTimeOnly <= $schedule->check_in_end) {
                    // Only override to 'present' if user explicitly set it to 'present'
                    if ($status === 'present') {
                        $status = 'present';
                    }
                }

                // Validate check-out time if provided
                if ($checkOutTime) {
                    $checkOutTimeOnly = Carbon::parse($checkOutTime)->format('H:i:s');
                    
                    // Create dummy attendance object for validation
                    $dummyAttendance = new \stdClass();
                    $dummyAttendance->check_out_time = null;
                    
                    $checkOutValidation = $this->validateAttendanceTime($checkOutTimeOnly, $schedule, $dummyAttendance);
                    
                    if (!$checkOutValidation['allowed']) {
                        return response()->json([
                            'status' => 'error',
                            'message' => $checkOutValidation['message']
                        ], 400);
                    }
                }
            }

            // ==========================================
            // UPDATE ATTENDANCE
            // ==========================================
            
            // Prepare update data
            $updateData = [
                'check_in_time' => $checkInTime,
                'check_out_time' => $checkOutTime,
                'status' => $status,
                'is_approved' => $isApproved,
                'note' => $note,
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ];

            // Add reason and file only for sick/excused
            if (in_array($status, ['sick', 'excused'])) {
                $updateData['reason'] = $request->reason;
                $updateData['file'] = $fileUrl;
            } else {
                $updateData['reason'] = null;
                $updateData['file'] = null;
            }

            // Use query builder for better performance
            DB::table('attendances')
                ->where('id', $id)
                ->update($updateData);

            // Refresh model for response
            $attendance->refresh();

            DB::commit();

            // Log activity
            Log::info('Attendance updated', [
                'attendance_id' => $id,
                'student_id' => $attendance->student_histories->students->id ?? null,
                'old_status' => $attendance->getOriginal('status'),
                'new_status' => $status,
                'updated_by' => auth()->id(),
            ]);

            // Direct response (tidak pakai transform method)
            return response()->json([
                'status' => 'success',
                'message' => 'Presensi berhasil diperbarui',
                'data' => [
                    'id' => $attendance->id,
                    'student_history_id' => $attendance->student_history_id,
                    'check_in_time' => $attendance->check_in_time 
                        ? Carbon::parse($attendance->check_in_time)->format('Y-m-d H:i:s')
                        : null,
                    'check_out_time' => $attendance->check_out_time 
                        ? Carbon::parse($attendance->check_out_time)->format('Y-m-d H:i:s')
                        : null,
                    'status' => $attendance->status,
                    'reason' => $attendance->reason,
                    'file' => $attendance->file 
                        ? Storage::url($attendance->file) 
                        : null,
                    'is_approved' => (bool) $attendance->is_approved,
                    'note' => $attendance->note,
                    'student' => [
                        'id' => $attendance->student_histories->students->id ?? null,
                        'name' => $attendance->student_histories->students->name ?? '-',
                        'nis' => $attendance->student_histories->students->nis ?? '-',
                        'photo' => $attendance->student_histories->students->photo ?? null,
                    ],
                    'group' => [
                        'id' => $attendance->student_histories->groups->id ?? null,
                        'name' => $attendance->student_histories->groups->name ?? '-',
                    ],
                    'created_at' => $attendance->created_at 
                        ? Carbon::parse($attendance->created_at)->format('Y-m-d H:i:s')
                        : null,
                    'updated_at' => $attendance->updated_at 
                        ? Carbon::parse($attendance->updated_at)->format('Y-m-d H:i:s')
                        : null,
                ]
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollback();
            
            return response()->json([
                'status' => 'error',
                'message' => 'Data presensi tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('Update Attendance Error', [
                'attendance_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui presensi: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function rfidAttendance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_uid' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $cardUid = $request->card_uid;
            $now = Carbon::now('Asia/Jakarta');
            $today = $now->copy()->startOfDay();
            $currentTime = $now->format('H:i:s');

            $studentData = Student::where('card_uid', $cardUid)
                ->with([
                    'student_histories' => function($query) {
                        $query->where('status', 'active')
                              ->whereHas('academic_years', function($q) {
                                  $q->where('is_active', true);
                              })
                              ->with('groups:id,name') // Only load needed columns
                              ->latest()
                              ->limit(1);
                    }
                ])
                ->first(['id', 'name', 'nis', 'card_uid', 'photo', 'phone', 'father_phone', 'mother_phone', 'guardian_phone']); // Only select needed columns

            if (!$studentData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Card UID tidak ditemukan'
                ], 404);
            }

            $studentHistory = $studentData->student_histories->first();

            if (!$studentHistory) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa tidak aktif pada tahun akademik ini'
                ], 400);
            }

            $existingAttendance = Attendance::where('student_history_id', $studentHistory->id)
                ->whereBetween('check_in_time', [
                    $today->toDateTimeString(),
                    $today->copy()->endOfDay()->toDateTimeString()
                ])
                ->first(['id', 'student_history_id', 'check_in_time', 'check_out_time', 'status']);

            $schedule = $this->getCachedAttendanceSchedule($today);
            
            if (!$schedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal presensi tidak ditemukan untuk hari ini'
                ], 400);
            }

            // Validate time
            $validation = $this->validateAttendanceTime($currentTime, $schedule, $existingAttendance);
            
            if (!$validation['allowed']) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validation['message']
                ], 400);
            }

            $action = 'check_in';
            
            if (!$existingAttendance) {
                // PRESENSI MASUK
                $isLate = $currentTime > $schedule->check_in_end;

                $attendance = Attendance::create([
                    'student_history_id' => $studentHistory->id,
                    'check_in_time' => $now,
                    'status' => $isLate ? 'late' : 'present',
                ]);

                $action = 'check_in';
                $message = $isLate ? 'Presensi masuk berhasil (Terlambat)' : 'Presensi masuk berhasil';
                
            } else {
                // PRESENSI PULANG
                if ($existingAttendance->check_out_time) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sudah melakukan presensi pulang hari ini'
                    ], 400);
                }

                // 🚀 OPTIMIZATION 4: Use update instead of model update (fewer queries)
                DB::table('attendances')
                    ->where('id', $existingAttendance->id)
                    ->update([
                        'check_out_time' => $now,
                        'is_approved' => 1,
                        'updated_at' => $now
                    ]);

                // Refresh model with new data
                $existingAttendance->check_out_time = $now;
                $existingAttendance->is_approved = 1;
                
                $attendance = $existingAttendance;
                $action = 'check_out';
                $message = 'Presensi pulang berhasil';
            }

            DB::commit();

            try {
                $whatsapp = app(WhatsAppService::class);
                
                if ($action === 'check_in') {
                    if ($attendance->status === 'late') {
                        $checkInEnd = Carbon::parse($today->toDateString() . ' ' . $schedule->check_in_end);
                        $lateMinutes = $checkInEnd->diffInMinutes($now);
                        $whatsapp->sendLateNotification($studentData, $attendance, $studentHistory, $lateMinutes);
                    } else {
                        $whatsapp->sendCheckInNotification($studentData, $attendance, $studentHistory);
                    }
                } else {
                    $whatsapp->sendCheckOutNotification($studentData, $attendance, $studentHistory);
                }
            } catch (\Exception $e) {
                // Jangan throw error - WhatsApp gagal tidak boleh break presensi
                Log::error('WhatsApp queue failed (non-critical)', [
                    'attendance_id' => $attendance->id,
                    'error' => $e->getMessage()
                ]);
            }

            dispatch(function() {
                try {
                    broadcast(new AttendanceRecorded());
                } catch (\Exception $e) {
                    Log::error('Failed to broadcast attendance event', [
                        'error' => $e->getMessage(),
                    ]);
                }
            })->afterResponse();

            // 🚀 OPTIMIZATION 6: Return minimal response data
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => [
                    'student' => [
                        'id' => $studentData->id,
                        'name' => $studentData->name,
                        'nis' => $studentData->nis,
                        'photo' => $studentData->photo,
                        'class' => $studentHistory->groups->name ?? '-'
                    ],
                    'attendance' => [
                        'id' => $attendance->id,
                        'check_in_time' => $attendance->check_in_time 
                            ? $attendance->check_in_time->format('H:i:s')
                            : null,
                        'check_out_time' => $attendance->check_out_time 
                            ? Carbon::parse($attendance->check_out_time)->format('H:i:s')
                            : null,
                        'status' => $attendance->status,
                    ],
                    'action' => $action,
                    'timestamp' => $now->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('RFID Attendance Error', [
                'card_uid' => $request->card_uid,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal melakukan presensi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function nisBased(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'NIS tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $nis = $request->nis;
            $now = Carbon::now('Asia/Jakarta');
            $today = $now->copy()->startOfDay();
            $currentTime = $now->format('H:i:s');

            // Single query dengan eager loading
            $studentData = Student::where('nis', $nis)
                ->with([
                    'student_histories' => function($query) {
                        $query->where('status', 'active')
                              ->whereHas('academic_years', function($q) {
                                  $q->where('is_active', true);
                              })
                              ->with('groups:id,name')
                              ->latest()
                              ->limit(1);
                    }
                ])
                ->first(['id', 'name', 'nis', 'card_uid', 'photo', 'phone', 'father_phone', 'mother_phone', 'guardian_phone']);

            if (!$studentData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'NIS tidak ditemukan'
                ], 404);
            }

            $studentHistory = $studentData->student_histories->first();

            if (!$studentHistory) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa tidak aktif pada tahun akademik ini'
                ], 400);
            }

            // Check existing attendance
            $existingAttendance = Attendance::where('student_history_id', $studentHistory->id)
                ->whereBetween('check_in_time', [
                    $today->toDateTimeString(),
                    $today->copy()->endOfDay()->toDateTimeString()
                ])
                ->first(['id', 'student_history_id', 'check_in_time', 'check_out_time', 'status']);

            // Get cached schedule
            $schedule = $this->getCachedAttendanceSchedule($today);
            
            if (!$schedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal presensi tidak ditemukan untuk hari ini'
                ], 400);
            }

            $validation = $this->validateAttendanceTime($currentTime, $schedule, $existingAttendance);
            
            if (!$validation['allowed']) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validation['message']
                ], 400);
            }

            $action = 'check_in';
            
            if (!$existingAttendance) {
                // PRESENSI MASUK
                $isLate = $currentTime > $schedule->check_in_end;

                $attendance = Attendance::create([
                    'student_history_id' => $studentHistory->id,
                    'check_in_time' => $now,
                    'status' => $isLate ? 'late' : 'present',
                ]);

                $action = 'check_in';
                $message = $isLate ? 'Presensi masuk berhasil (Terlambat)' : 'Presensi masuk berhasil';
                
            } else {
                // PRESENSI PULANG
                if ($existingAttendance->check_out_time) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sudah melakukan presensi pulang hari ini'
                    ], 400);
                }

                DB::table('attendances')
                    ->where('id', $existingAttendance->id)
                    ->update([
                        'check_out_time' => $now,
                        'is_approved' => 1,
                        'updated_at' => $now
                    ]);

                $existingAttendance->check_out_time = $now;
                $existingAttendance->is_approved = 1;
                
                $attendance = $existingAttendance;
                $action = 'check_out';
                $message = 'Presensi pulang berhasil';
            }

            DB::commit();

            try {
                $whatsapp = app(WhatsAppService::class);
                
                if ($action === 'check_in') {
                    if ($attendance->status === 'late') {
                        $checkInEnd = Carbon::parse($today->toDateString() . ' ' . $schedule->check_in_end);
                        $lateMinutes = $checkInEnd->diffInMinutes($now);
                        $whatsapp->sendLateNotification($studentData, $attendance, $studentHistory, $lateMinutes);
                    } else {
                        $whatsapp->sendCheckInNotification($studentData, $attendance, $studentHistory);
                    }
                } else {
                    $whatsapp->sendCheckOutNotification($studentData, $attendance, $studentHistory);
                }
            } catch (\Exception $e) {
                Log::error('WhatsApp queue failed (non-critical)', [
                    'attendance_id' => $attendance->id,
                    'error' => $e->getMessage()
                ]);
            }

            dispatch(function() {
                try {
                    broadcast(new AttendanceRecorded());
                } catch (\Exception $e) {
                    Log::error('Failed to broadcast attendance event', [
                        'error' => $e->getMessage(),
                    ]);
                }
            })->afterResponse();

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => [
                    'student' => [
                        'id' => $studentData->id,
                        'name' => $studentData->name,
                        'nis' => $studentData->nis,
                        'photo' => $studentData->photo,
                        'class' => $studentHistory->groups->name ?? '-'
                    ],
                    'attendance' => [
                        'id' => $attendance->id,
                        'check_in_time' => $attendance->check_in_time 
                            ? $attendance->check_in_time->format('H:i:s')
                            : null,
                        'check_out_time' => $attendance->check_out_time 
                            ? Carbon::parse($attendance->check_out_time)->format('H:i:s')
                            : null,
                        'status' => $attendance->status,
                    ],
                    'action' => $action,
                    'timestamp' => $now->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            Log::error('NIS Attendance Error', [
                'nis' => $request->nis,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal melakukan presensi: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateAttendanceTimes($date, $schedule, $status)
    {
        $checkInTime = null;
        $checkOutTime = null;

        switch ($status) {
            case 'present':
                // Present: Random time in allowed check-in range + check-out time
                $checkInStart = Carbon::parse($date->toDateString() . ' ' . $schedule->check_in_start);
                $checkInEnd = Carbon::parse($date->toDateString() . ' ' . $schedule->check_in_end);
                
                // Random check-in time between start and end
                $checkInTime = $this->randomTimeBetween($checkInStart, $checkInEnd);
                
                // Random check-out time between start and end
                $checkOutStart = Carbon::parse($date->toDateString() . ' ' . $schedule->check_out_start);
                $checkOutEnd = Carbon::parse($date->toDateString() . ' ' . $schedule->check_out_end);
                $checkOutTime = $this->randomTimeBetween($checkOutStart, $checkOutEnd);
                break;

            case 'late':
                // Late: Random time after check_in_end but before check_out_start + check-out time
                $checkInEnd = Carbon::parse($date->toDateString() . ' ' . $schedule->check_in_end);
                $checkOutStart = Carbon::parse($date->toDateString() . ' ' . $schedule->check_out_start);
                
                // Add 5-30 minutes after check_in_end
                $lateMinutes = rand(5, 30);
                $checkInTime = $checkInEnd->copy()->addMinutes($lateMinutes);
                
                // Ensure it's before check_out_start
                if ($checkInTime->gte($checkOutStart)) {
                    $checkInTime = $checkOutStart->copy()->subMinutes(5);
                }
                
                // Random check-out time
                $checkOutEnd = Carbon::parse($date->toDateString() . ' ' . $schedule->check_out_end);
                $checkOutTime = $this->randomTimeBetween($checkOutStart, $checkOutEnd);
                break;

            case 'missing':
                // Missing: Only check-in time, no check-out
                $checkInStart = Carbon::parse($date->toDateString() . ' ' . $schedule->check_in_start);
                $checkInEnd = Carbon::parse($date->toDateString() . ' ' . $schedule->check_in_end);
                $checkInTime = $this->randomTimeBetween($checkInStart, $checkInEnd);
                $checkOutTime = null; // No check-out for missing
                break;
        }

        return [
            'check_in_time' => $checkInTime,
            'check_out_time' => $checkOutTime,
        ];
    }

    private function randomTimeBetween(Carbon $start, Carbon $end)
    {
        $startTimestamp = $start->timestamp;
        $endTimestamp = $end->timestamp;
        
        $randomTimestamp = rand($startTimestamp, $endTimestamp);
        
        return Carbon::createFromTimestamp($randomTimestamp, 'Asia/Jakarta');
    }

    protected function getCachedAttendanceSchedule($date)
    {
        $cacheKey = 'attendance_schedule:' . $date->format('Y-m-d');
        
        return Cache::remember($cacheKey, now()->addHours(6), function() use ($date) {
            return $this->getAttendanceSchedule($date);
        });
    }

    private function validateAttendanceTime($currentTime, $schedule, $existingAttendance)
    {
        if (!$existingAttendance) {
            // Cek apakah masih dalam rentang waktu presensi masuk
            if ($currentTime >= $schedule->check_in_start && $currentTime <= $schedule->check_in_end) {
                return ['allowed' => true, 'message' => 'Waktu presensi masuk'];
            }

            if ($currentTime >= $schedule->check_in_end && $currentTime <= $schedule->check_out_start) {
                return ['allowed' => true, 'message' => 'Waktu presensi masuk (terlambat)'];
            }
            
            // Cek apakah sudah memasuki waktu presensi pulang
            if ($currentTime >= $schedule->check_out_start) {
                return [
                    'allowed' => false, 
                    'message' => 'Presensi masuk ditolak. Sudah memasuki waktu presensi pulang.'
                ];
            }
            
            // Diluar semua rentang waktu
            return [
                'allowed' => false, 
                'message' => 'Presensi masuk ditolak. Waktu presensi masuk: ' . 
                            substr($schedule->check_in_start, 0, 5) . ' - ' . 
                            substr($schedule->check_in_end, 0, 5)
            ];
        }
        
        // Jika sudah presensi masuk, cek untuk presensi pulang
        if ($existingAttendance && !$existingAttendance->check_out_time) {
            // Cek apakah sudah memasuki rentang waktu presensi pulang
            if ($currentTime >= $schedule->check_out_start && $currentTime <= $schedule->check_out_end) {
                return ['allowed' => true, 'message' => 'Waktu presensi pulang'];
            }
            
            // Belum waktunya presensi pulang
            if ($currentTime < $schedule->check_out_start) {
                return [
                    'allowed' => false, 
                    'message' => 'Presensi pulang ditolak. Waktu presensi pulang mulai: ' . 
                                substr($schedule->check_out_start, 0, 5)
                ];
            }
            
            // Sudah lewat waktu presensi pulang
            if ($currentTime > $schedule->check_out_end) {
                return [
                    'allowed' => false, 
                    'message' => 'Presensi pulang ditolak. Sudah melewati batas waktu presensi pulang.'
                ];
            }
        }
        
        return ['allowed' => false, 'message' => 'Tidak dapat melakukan presensi'];
    }

    private function getAttendanceSchedule($date)
    {
        $dayName = strtolower($date->format('l')); 
        
        $override = AttendanceScheduleOverride::where('date', $date->format('Y-m-d'))->first();

        if ($override) {
            return (object)[
                'check_in_start' => $override->check_in_start,
                'check_in_end' => $override->check_in_end,
                'check_out_start' => $override->check_out_start,
                'check_out_end' => $override->check_out_end
            ];
        }

        $schedule = AttendanceSchedule::where('day', $dayName)->first();

        return $schedule;
    }

    public function generateStatus(Request $request)
    {
        try {
            DB::beginTransaction();

            // Gunakan timezone WIB
            $today = Carbon::now('Asia/Jakarta')->startOfDay();
            $now = Carbon::now('Asia/Jakarta');

            // Ambil jadwal hari ini
            $schedule = $this->getAttendanceSchedule($today);
            
            if (!$schedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal presensi tidak ditemukan untuk hari ini'
                ], 400);
            }

            // Validasi apakah sudah melewati waktu check_out_end
            $currentTime = $now->format('H:i:s');
            if ($currentTime < $schedule->check_out_end) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Belum waktunya rekap status. Waktu selesai presensi pulang: ' . substr($schedule->check_out_end, 0, 5)
                ], 400);
            }

            // Ambil tahun akademik aktif
            $currentAcademicYear = AcademicYear::where('is_active', true)->first();
            if (!$currentAcademicYear) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tahun akademik aktif tidak ditemukan'
                ], 400);
            }

            // Ambil presensi hari ini yang check_out_time nya kosong
            // Kecuali yang sudah berstatus sick atau excused
            $missingCheckouts = Attendance::whereDate('check_in_time', $today)
                ->whereNull('check_out_time')
                ->whereNotIn('status', ['sick', 'excused'])
                ->whereHas('student_histories', function($q) use ($currentAcademicYear) {
                    $q->where('academic_year_id', $currentAcademicYear->id)
                      ->where('status', 'active');
                })
                ->with('student_histories.students')
                ->get();

            $stats = [
                'total_checked' => $missingCheckouts->count(),
                'updated_to_missing' => 0,
                'details' => []
            ];

            foreach ($missingCheckouts as $attendance) {
                $oldStatus = $attendance->status;
                
                // Update ke missing
                $attendance->update([
                    'status' => 'missing',
                    'note' => ($attendance->note ? $attendance->note . ' | ' : '') . 
                              "Status updated from '{$oldStatus}' to 'missing' (no check-out) at " . 
                              $now->format('Y-m-d H:i:s')
                ]);

                $stats['updated_to_missing']++;
                $stats['details'][] = [
                    'student_id' => $attendance->student_histories->student_id,
                    'student_name' => $attendance->student_histories->students->name,
                    'nis' => $attendance->student_histories->students->nis,
                    'old_status' => $oldStatus,
                    'new_status' => 'missing',
                    'check_in_time' => Carbon::parse($attendance->check_in_time)->format('H:i:s')
                ];
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "Berhasil rekap status {$stats['updated_to_missing']} siswa",
                'data' => [
                    'generated_at' => $now->toDateTimeString(),
                    'date' => $today->format('Y-m-d'),
                    'statistics' => $stats
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal rekap status: ' . $e->getMessage()
            ], 500);
        }
    }
}