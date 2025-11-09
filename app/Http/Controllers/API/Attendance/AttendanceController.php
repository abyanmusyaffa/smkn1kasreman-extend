<?php

namespace App\Http\Controllers\API\Attendance;

use Carbon\Carbon;
use App\Models\Group;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\StudentHistory;
use App\Models\AttendanceSchedule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use App\Models\AttendanceScheduleOverride;

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
            'check_in_time' => $attendance->check_in_time
                ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateTimeString()
                : null,
            'check_out_time' => $attendance->check_out_time
                ? Carbon::parse($attendance->check_out_time)->timezone('Asia/Jakarta')->toDateTimeString()
                : null,
            'status' => $attendance->status,
            'created_at' => $attendance->created_at,
            'updated_at' => $attendance->updated_at,
        ];
    }
    
    public function index(Request $request)
    {
        try {
            // 1️⃣ Ambil parameter
            $search = $request->get('search', '');
            $sortField = $request->get('sort_field', 'check_in_time');
            $sortDirection = $request->get('sort_direction', 'desc');
            $perPage = $request->integer('per_page', 10);
            $date = $request->get('date');
            $statusFilter = $request->get('status');
            $groupId = $request->get('group_id');
            $academicYearId = $request->get('academic_year_id');
            $isApproved = $request->get('is_approved');

            // 2️⃣ Ambil tahun akademik aktif kalau belum di-filter
            $currentAcademicYear = $academicYearId
                ? AcademicYear::find($academicYearId)
                : AcademicYear::where('is_active', true)->first();

            // 3️⃣ Base query
            $query = Attendance::with(['student_histories.students', 'student_histories.groups']);

            // 4️⃣ Filter dinamis
            $query->when($currentAcademicYear, fn($q) => 
                $q->whereHas('student_histories', fn($sq) => 
                    $sq->where('academic_year_id', $currentAcademicYear->id)));

            $query->when($groupId, fn($q) => 
                $q->whereHas('student_histories', fn($sq) => $sq->where('group_id', $groupId)));

            $query->when($statusFilter, fn($q) => 
                is_array($statusFilter) ? $q->whereIn('status', $statusFilter) : $q->where('status', $statusFilter));

            $query->when($isApproved !== null, fn($q) => $q->where('is_approved', $isApproved));

            $query->when($date, fn($q) => $q->whereDate('check_in_time', '=', Carbon::parse($date)->startOfDay()));

            $query->when($search, function ($q) use ($search) {
                $q->whereHas('student_histories.students', function ($sq) use ($search) {
                    $sq->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('nis', 'LIKE', "%{$search}%")
                    ->orWhere('card_uid', 'LIKE', "%{$search}%");
                });
            });

            // 5️⃣ Sorting
            $allowedSortFields = ['check_in_time', 'check_out_time', 'status'];
            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortDirection);
            } else {
                $query->orderBy('check_in_time', 'desc');
            }

            // 6️⃣ Pagination
            $attendances = $query->paginate($perPage);

            // 7️⃣ Transform data
            $attendances->getCollection()->transform(fn($a) => $this->transformAttendance($a));

            // 8️⃣ Meta data
            $meta = [
                'total_present' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
                    ->where('status', 'present')->count(),
                'total_late' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
                    ->where('status', 'late')->count(),
                'total_missing' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
                    ->where('status', 'missing')->count(),
                'total_sick' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
                    ->where('status', 'sick')->count(),
                'total_excused' => Attendance::when($date, fn($q) => $q->whereDate('check_in_time', '=', $date))
                    ->where('status', 'excused')->count(),
            ];

            // 9️⃣ Response
            return response()->json([
                'status' => 'success',
                'data' => $attendances,
                'meta' => $meta,
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
    // public function index(Request $request)
    // {
    //     try {
    //         $perPage = $request->get('per_page', 10);
    //         $search = $request->get('search', '');
    //         $sortField = $request->get('sort_field', 'check_in_time');
    //         $sortDirection = $request->get('sort_direction', 'desc');
            
    //         // Date range filters
    //         $date = $request->get('date');
            
    //         // Status filter
    //         $statusFilter = $request->get('status');
            
    //         // Academic year filter
    //         $academicYearId = $request->get('academic_year_id');
            
    //         // Group/Class filter
    //         $groupId = $request->get('group_id');
            
    //         // Approved filter
    //         $isApproved = $request->get('is_approved');

    //         // Get current academic year jika tidak di-filter
    //         $currentAcademicYear = null;
    //         if (!$academicYearId) {
    //             $currentAcademicYear = AcademicYear::where('is_active', true)->first();
    //             $academicYearId = $currentAcademicYear?->id;
    //         }

    //         // Base query dengan relations
    //         $query = Attendance::with([
    //             'student_histories' => function($q) {
    //                 $q->with(['students', 'groups']);
    //             }
    //         ]);

    //         // Filter by academic year
    //         if ($academicYearId) {
    //             $query->whereHas('student_histories', function($q) use ($academicYearId) {
    //                 $q->where('academic_year_id', $academicYearId);
    //             });
    //         }

    //         // Filter by group/class
    //         if ($groupId) {
    //             $query->whereHas('student_histories', function($q) use ($groupId) {
    //                 $q->where('group_id', $groupId);
    //             });
    //         }

    //         // Filter by status
    //         if ($statusFilter) {
    //             if (is_array($statusFilter)) {
    //                 $query->whereIn('status', $statusFilter);
    //             } else {
    //                 $query->where('status', $statusFilter);
    //             }
    //         }

    //         // Filter by is_approved
    //         if ($isApproved !== null) {
    //             $query->where('is_approved', $isApproved);
    //         }

    //         // Date range filter
    //         if ($date) {
    //             $query->whereDate('check_in_time', '=', Carbon::parse($date)->startOfDay());
    //         }

    //         // Global search (name, nis, card_uid, note)
    //         if ($search) {
    //             $query->where(function($q) use ($search) {
    //                 $q->whereHas('student_histories.students', function($sq) use ($search) {
    //                     $sq->where('name', 'LIKE', "%{$search}%")
    //                        ->orWhere('nis', 'LIKE', "%{$search}%")
    //                        ->orWhere('card_uid', 'LIKE', "%{$search}%");
    //                 });
    //             });
    //         }

    //         // Sorting
    //         $allowedSortFields = [
    //             'check_in_time',
    //             'check_out_time',
    //             'status',
    //         ];

    //         if (in_array($sortField, $allowedSortFields)) {
    //             $query->orderBy($sortField, $sortDirection);
    //         } else {
    //             // Default sorting
    //             $query->orderBy('check_in_time', 'desc');
    //         }

    //         // Paginate
    //         $attendances = $query->paginate($perPage);

    //         // Transform data untuk response
    //         $attendances->getCollection()->transform(function ($attendance) {
    //             $studentHistory = $attendance->student_histories;
    //             $student = $studentHistory->students ?? null;
    //             $group = $studentHistory->groups ?? null;

    //             return [
    //                 'id' => $attendance->id,
    //                 'student_history_id' => $attendance->student_history_id,
    //                 'student' => $student ? [
    //                     'id' => $student->id,
    //                     'name' => $student->name,
    //                     'nis' => $student->nis,
    //                     'card_uid' => $student->card_uid,
    //                     'photo' => $student->photo,
    //                 ] : null,
    //                 'group' => $group ? [
    //                     'id' => $group->id,
    //                     'name' => $group->name,
    //                 ] : null,
    //                 'check_in_time' => $attendance->check_in_time 
    //                     ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateTimeString() 
    //                     : null,
    //                 'check_out_time' => $attendance->check_out_time 
    //                     ? Carbon::parse($attendance->check_out_time)->timezone('Asia/Jakarta')->toDateTimeString() 
    //                     : null,
    //                 'check_in_date' => $attendance->check_in_time 
    //                     ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->format('Y-m-d') 
    //                     : null,
    //                 'check_in_time_only' => $attendance->check_in_time 
    //                     ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->format('H:i:s') 
    //                     : null,
    //                 'check_out_time_only' => $attendance->check_out_time 
    //                     ? Carbon::parse($attendance->check_out_time)->timezone('Asia/Jakarta')->format('H:i:s') 
    //                     : null,
    //                 'status' => $attendance->status,
    //                 'created_at' => $attendance->created_at 
    //                     ? Carbon::parse($attendance->created_at)->timezone('Asia/Jakarta')->toDateTimeString() 
    //                     : null,
    //                 'updated_at' => $attendance->updated_at 
    //                     ? Carbon::parse($attendance->updated_at)->timezone('Asia/Jakarta')->toDateTimeString() 
    //                     : null,
    //             ];
    //         });

    //         // Additional meta data
    //         $meta = [
    //             // 'total_active' => StudentHistory::where('academic_year_id', $currentAcademicYear->id)
    //             //     ->where('status', 'active')
    //             //     ->count(),
    //             'total_present' => Attendance::when($date, function($q) use ($date) {
    //                     $q->whereDate('check_in_time', '=', $date);
    //                 })
    //                 ->where('status', 'present')->count(),
    //             'total_late' => Attendance::when($date, function($q) use ($date) {
    //                     $q->whereDate('check_in_time', '=', $date);
    //                 })
    //                 ->where('status', 'late')->count(),
    //             'total_missing' => Attendance::when($date, function($q) use ($date) {
    //                     $q->whereDate('check_in_time', '=', $date);
    //                 })
    //                 ->where('status', 'missing')->count(),
    //             'total_sick' => Attendance::when($date, function($q) use ($date) {
    //                     $q->whereDate('check_in_time', '=', $date);
    //                 })
    //                 ->where('status', 'sick')->count(),
    //             'total_excused' => Attendance::when($date, function($q) use ($date) {
    //                     $q->whereDate('check_in_time', '=', $date);
    //                 })
    //                 ->where('status', 'excused')->count(),
    //         ];

    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $attendances,
    //             'meta' => $meta,
    //             'filters' => [
    //                 'academic_year_id' => $academicYearId,
    //                 'group_id' => $groupId,
    //                 'status' => $statusFilter,
    //                 'date' => $date,
    //                 'search' => $search,
    //                 'sort_field' => $sortField,
    //                 'sort_direction' => $sortDirection,
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal mengambil data presensi: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

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

    public function approve($id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            
            $attendance->update([
                'is_approved' => true,
                'note' => ($attendance->note ? $attendance->note . ' | ' : '') . 
                          'Approved at ' . Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Presensi berhasil disetujui',
                'data' => $attendance
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyetujui presensi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $attendance = Attendance::findOrFail($id);
            $studentName = $attendance->student_histories->students->name ?? 'Unknown';
            
            $attendance->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "Presensi {$studentName} berhasil dihapus"
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus presensi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkApprove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:attendances,id'
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

            $updated = Attendance::whereIn('id', $request->ids)
                ->update([
                    'is_approved' => true,
                    'updated_at' => Carbon::now('Asia/Jakarta')
                ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "{$updated} presensi berhasil disetujui",
                'data' => [
                    'total_updated' => $updated
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menyetujui presensi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:attendances,id'
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

            $deleted = Attendance::whereIn('id', $request->ids)->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "{$deleted} presensi berhasil dihapus",
                'data' => [
                    'total_deleted' => $deleted
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus presensi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkUpdateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:attendances,id',
            'status' => 'required|in:present,late,missing,sick,excused'
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

            $updated = Attendance::whereIn('id', $request->ids)
                ->update([
                    'status' => $request->status,
                    'updated_at' => Carbon::now('Asia/Jakarta')
                ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => "{$updated} presensi berhasil diupdate ke status {$request->status}",
                'data' => [
                    'total_updated' => $updated,
                    'new_status' => $request->status
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal update status: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function export(Request $request)
    // {
    //     try {
    //         $format = $request->get('format', 'xlsx');
    //         $ids = $request->get('ids'); // Untuk export selected
            
    //         // Filters
    //         $dateFrom = $request->get('date_from');
    //         $dateTo = $request->get('date_to');
    //         $status = $request->get('status');
    //         $academicYearId = $request->get('academic_year_id');
    //         $groupId = $request->get('group_id');
    //         $search = $request->get('search');

    //         $query = Attendance::with(['student_histories.students', 'student_histories.groups']);

    //         // If specific IDs provided (export selected)
    //         if ($ids) {
    //             $idsArray = is_array($ids) ? $ids : explode(',', $ids);
    //             $query->whereIn('id', $idsArray);
    //         } else {
    //             // Apply filters
    //             if ($dateFrom) {
    //                 $query->whereDate('check_in_time', '>=', Carbon::parse($dateFrom)->startOfDay());
    //             }
    //             if ($dateTo) {
    //                 $query->whereDate('check_in_time', '<=', Carbon::parse($dateTo)->endOfDay());
    //             }
    //             if ($status) {
    //                 $query->where('status', $status);
    //             }
    //             if ($academicYearId) {
    //                 $query->whereHas('student_histories', function($q) use ($academicYearId) {
    //                     $q->where('academic_year_id', $academicYearId);
    //                 });
    //             }
    //             if ($groupId) {
    //                 $query->whereHas('student_histories', function($q) use ($groupId) {
    //                     $q->where('group_id', $groupId);
    //                 });
    //             }
    //             if ($search) {
    //                 $query->where(function($q) use ($search) {
    //                     $q->whereHas('student_histories.students', function($sq) use ($search) {
    //                         $sq->where('name', 'LIKE', "%{$search}%")
    //                            ->orWhere('nis', 'LIKE', "%{$search}%");
    //                     });
    //                 });
    //             }
    //         }

    //         $attendances = $query->orderBy('check_in_time', 'desc')->get();

    //         // Prepare data for export
    //         $exportData = [];
    //         $exportData[] = ['No', 'Nama', 'NIS', 'Kelas', 'Tanggal', 'Jam Masuk', 'Jam Pulang', 'Status', 'Keterangan'];

    //         foreach ($attendances as $index => $attendance) {
    //             $exportData[] = [
    //                 $index + 1,
    //                 $attendance->student_histories->students->name ?? '-',
    //                 $attendance->student_histories->students->nis ?? '-',
    //                 $attendance->student_histories->groups->name ?? '-',
    //                 Carbon::parse($attendance->check_in_time)->format('Y-m-d'),
    //                 Carbon::parse($attendance->check_in_time)->format('H:i:s'),
    //                 $attendance->check_out_time ? Carbon::parse($attendance->check_out_time)->format('H:i:s') : '-',
    //                 // $this->getStatusLabel($attendance->status),
    //                 $attendance->note ?? '-'
    //             ];
    //         }

    //         $filename = 'presensi_' . date('Y-m-d_His');

    //         if ($format === 'csv') {
    //             return $this->exportToCsv($exportData, $filename);
    //         } else {
    //             return $this->exportToExcel($exportData, $filename);
    //         }

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal export: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // private function exportToCsv($data, $filename)
    // {
    //     $headers = [
    //         'Content-Type' => 'text/csv',
    //         'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
    //     ];

    //     $callback = function() use ($data) {
    //         $file = fopen('php://output', 'w');
            
    //         foreach ($data as $row) {
    //             fputcsv($file, $row);
    //         }
            
    //         fclose($file);
    //     };

    //     return response()->stream($callback, 200, $headers);
    // }

    // private function exportToExcel($data, $filename)
    // {
    //     // Untuk Excel yang lebih baik, install: composer require phpoffice/phpspreadsheet
    //     // Ini versi simple HTML table yang bisa dibuka Excel
        
    //     $html = '<html><head><meta charset="utf-8"></head><body>';
    //     $html .= '<table border="1">';
        
    //     foreach ($data as $row) {
    //         $html .= '<tr>';
    //         foreach ($row as $cell) {
    //             $html .= '<td>' . htmlspecialchars($cell) . '</td>';
    //         }
    //         $html .= '</tr>';
    //     }
        
    //     $html .= '</table></body></html>';

    //     $headers = [
    //         'Content-Type' => 'application/vnd.ms-excel',
    //         'Content-Disposition' => "attachment; filename=\"{$filename}.xls\"",
    //     ];

    //     return response($html, 200, $headers);
    // }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'check_in_time' => 'nullable|date',
            'check_out_time' => 'nullable|date',
            'status' => 'nullable|in:present,late,missing,sick,excused',
            'reason' => 'nullable|string|max:500',
            'note' => 'nullable|string|max:500',
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

            $attendance = Attendance::findOrFail($id);
            
            $updateData = array_filter($request->only([
                'check_in_time',
                'check_out_time', 
                'status',
                'reason',
                'note'
            ]));

            $attendance->update($updateData);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Presensi berhasil diupdate',
                'data' => $attendance
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal update presensi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $attendance = Attendance::with(['student_histories.students', 'student_histories.groups'])
                                   ->findOrFail($id);

            $studentHistory = $attendance->student_histories;
            $student = $studentHistory->students ?? null;
            $group = $studentHistory->groups ?? null;

            $data = [
                'id' => $attendance->id,
                'student_history_id' => $attendance->student_history_id,
                'student' => $student ? [
                    'id' => $student->id,
                    'name' => $student->name,
                    'nis' => $student->nis,
                    'nisn' => $student->nisn,
                    'photo' => $student->photo,
                ] : null,
                'group' => $group ? [
                    'id' => $group->id,
                    'name' => $group->name,
                ] : null,
                'check_in_time' => $attendance->check_in_time 
                    ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateTimeString() 
                    : null,
                'check_out_time' => $attendance->check_out_time 
                    ? Carbon::parse($attendance->check_out_time)->timezone('Asia/Jakarta')->toDateTimeString() 
                    : null,
                'status' => $attendance->status,
                // 'status_label' => $this->getStatusLabel($attendance->status),
                'reason' => $attendance->reason,
                'file' => $attendance->file,
                'is_approved' => (bool) $attendance->is_approved,
                'note' => $attendance->note,
                'created_at' => $attendance->created_at,
                'updated_at' => $attendance->updated_at,
            ];

            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan: ' . $e->getMessage()
            ], 404);
        }
    }

    public function getTodayAttendances(Request $request)
    {
        try {
            $date = $request->get('date', Carbon::now('Asia/Jakarta')->toDateString());
            $search = $request->get('search', '');
            $sortField = $request->get('sort_field', 'check_in_time');
            $sortDirection = $request->get('sort_direction', 'asc');
            $page = $request->integer('page');
            $perPage = $request->integer('per_page', 10);

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

            // 9️⃣ Response
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
    // public function getTodayAttendances(Request $request)
    // {
    //     try {
    //         $today = Carbon::now('Asia/Jakarta')->startOfDay();
    //         $search = $request->get('search', '');
    //         $sortField = $request->get('sort_field', 'check_in_time');
    //         $sortDirection = $request->get('sort_direction', 'asc');
    //         $perPage = $request->get('per_page', 10);

    //         $currentAcademicYear = AcademicYear::where('is_active', true)->first();
    //         if (!$currentAcademicYear) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Tahun akademik aktif tidak ditemukan'
    //             ], 400);
    //         }

    //         $todayAttendances = Attendance::whereDate('check_in_time', $today)
    //             ->with('student_histories')
    //             ->get();

    //         $query = Attendance::with(['student_histories.students', 'student_histories.groups'])
    //             ->whereDate('check_in_time', $today)
    //             ->whereHas('student_histories', function($q) use ($currentAcademicYear) {
    //                 $q->where('academic_year_id', $currentAcademicYear->id)
    //                   ->where('status', 'active');
    //             });


    //         // Search filter
    //         if ($search) {
    //             $query->where(function ($query) use ($search) {
    //                 $query->where('status', 'LIKE', "%{$search}%")
    //                     ->orWhereHas('student_histories.students', function($q) use ($search) {
    //                         $q->where('name', 'LIKE', "%{$search}%")
    //                           ->orWhere('nis', 'LIKE', "%{$search}%")
    //                           ->orWhere('card_uid', 'LIKE', "%{$search}%");
    //                     })
    //                     ->orWhereHas('student_histories.groups', function($q) use ($search) {
    //                         $q->where('name', 'LIKE', "%{$search}%");
    //                     });
    //             });
    //         }

    //         // Sorting
    //         if (in_array($sortField, ['check_in_time', 'check_out_time', 'status'])) {
    //             $query->orderBy($sortField, $sortDirection);
    //         }
            
    //         if ($sortField === 'name') {
    //             $query->join('student_histories', 'student_histories.id', '=', 'attendances.student_history_id')
    //                 ->join('students', 'students.id', '=', 'student_histories.student_id')
    //                 ->orderBy('students.name', $sortDirection)
    //                 ->select('attendances.*');
    //         }
            
    //         if ($sortField === 'group') {
    //             $query->join('student_histories', 'student_histories.id', '=', 'attendances.student_history_id')
    //                 ->join('groups', 'groups.id', '=', 'student_histories.group_id')
    //                 ->orderBy('groups.name', $sortDirection)
    //                 ->select('attendances.*');
    //         }

    //         // Hitung total data untuk mendapatkan last page
    //         $totalData = $query->count();
    //         $lastPage = ceil($totalData / $perPage);
            
    //         // Jika tidak ada parameter page, set ke last page
    //         $currentPage = $request->get('page', $lastPage);
            
    //         // Pastikan current page tidak melebihi last page dan minimal 1
    //         $currentPage = max(1, min($currentPage, $lastPage));

    //         $attendances = $query->orderBy('updated_at')
    //                             ->paginate($perPage, ['*'], 'page', $currentPage);

    //         // Transform data untuk response
    //         $attendances->getCollection()->transform(function ($attendance) {
    //             return [
    //                 'id' => $attendance->id,
    //                 'student' => [
    //                     'id' => $attendance->student_histories->students->id,
    //                     'name' => $attendance->student_histories->students->name,
    //                     'nis' => $attendance->student_histories->students->nis,
    //                     'photo' => $attendance->student_histories->students->photo,
    //                     'class' => $attendance->student_histories->groups->name ?? '-'
    //                 ],
    //                 'check_in_time' => $attendance->check_in_time 
    //                     ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateTimeString() 
    //                     : null,
    //                 'check_out_time' => $attendance->check_out_time 
    //                     ? Carbon::parse($attendance->check_out_time)->timezone('Asia/Jakarta')->toDateTimeString() 
    //                     : null,
    //                 'status' => $attendance->status,
    //                 'created_at' => $attendance->created_at,
    //                 'updated_at' => $attendance->updated_at,
    //             ];
    //         });

    //         $meta = [
    //             'total_active_students' => StudentHistory::where('academic_year_id', $currentAcademicYear->id)->where('status', 'active')->count(),
    //             'total_present_in' => Attendance::whereDate('check_in_time', $today)->whereNotNull('check_in_time')->count(),
    //             'total_present_out' => Attendance::whereDate('check_in_time', $today)->whereNotNull('check_out_time')->count(),
    //             'total_late' => Attendance::whereDate('check_in_time', $today)->where('status', 'late')->count(),
    //             'total_sick_excused' => Attendance::whereDate('check_in_time', $today)->whereIn('status', ['sick', 'excused'])->count(),
    //         ];
            
    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $attendances,
    //             'meta' => $meta,
    //             'filters' => [
    //                 'search' => $search,
    //                 'sort_field' => $sortField,
    //                 'sort_direction' => $sortDirection,
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal mengambil data presensi: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

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

            $student = Student::where('card_uid', $request->card_uid)->first();

            if (!$student) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Card UID tidak ditemukan'
                ], 404);
            }

            $currentAcademicYear = AcademicYear::where('is_active', true)->first();
            $studentHistory = StudentHistory::where('student_id', $student->id)
                                           ->where('academic_year_id', $currentAcademicYear->id)
                                           ->where('status', 'active')
                                           ->with('groups')
                                           ->first();

            if (!$studentHistory) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa tidak aktif pada tahun akademik ini'
                ], 400);
            }

            $today = Carbon::now('Asia/Jakarta')->startOfDay();
            $now = Carbon::now('Asia/Jakarta');
            $currentTime = $now->format('H:i:s');

            $existingAttendance = Attendance::where('student_history_id', $studentHistory->id)
                                          ->whereDate('check_in_time', $today)
                                          ->first();

            $schedule = $this->getAttendanceSchedule($today);
            
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

            if (!$existingAttendance) {
                // PRESENSI MASUK
                $isLate = $currentTime > $schedule->check_in_end;

                $attendance = Attendance::create([
                    'student_history_id' => $studentHistory->id,
                    'check_in_time' => $now,
                    'status' => $isLate ? 'late' : 'present',
                ]);

                // $action = 'masuk';
                $message = $isLate ? 'Presensi masuk berhasil (Terlambat)' : 'Presensi masuk berhasil';
                
            } else {
                // PRESENSI PULANG
                if ($existingAttendance->check_out_time) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sudah melakukan presensi pulang hari ini'
                    ], 400);
                }

                $existingAttendance->update([
                    'check_out_time' => $now,
                    'is_approved' => 1
                ]);

                $attendance = $existingAttendance;
                // $action = 'pulang';
                $message = 'Presensi pulang berhasil';
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => [
                    'student' => [
                        'id' => $student->id,
                        'name' => $student->name,
                        'nis' => $student->nis,
                        'photo' => $student->photo,
                        'class' => $studentHistory->groups->name ?? '-'
                    ],
                    'attendance' => [
                        'id' => $attendance->id,
                        'check_in_time' => $attendance->check_in_time 
                            ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateTimeString() 
                            : null,
                        'check_out_time' => $attendance->check_out_time 
                            ? Carbon::parse($attendance->check_out_time)->timezone('Asia/Jakarta')->toDateTimeString() 
                            : null,
                        'status' => $attendance->status,
                        // 'note' => $attendance->note,
                    ],
                    // 'action' => $action,
                    'timestamp' => $now->toDateTimeString()
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
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

            $student = Student::where('nis', $request->nis)->first();

            if (!$student) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'NIS tidak ditemukan'
                ], 404);
            }

            $currentAcademicYear = AcademicYear::where('is_active', true)->first();
            $studentHistory = StudentHistory::where('student_id', $student->id)
                                           ->where('academic_year_id', $currentAcademicYear->id)
                                           ->where('status', 'active')
                                           ->with('groups')
                                           ->first();

            if (!$studentHistory) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Siswa tidak aktif pada tahun akademik ini'
                ], 400);
            }

            $today = Carbon::now('Asia/Jakarta')->startOfDay();
            $now = Carbon::now('Asia/Jakarta');
            $currentTime = $now->format('H:i:s');

            $existingAttendance = Attendance::where('student_history_id', $studentHistory->id)
                                          ->whereDate('check_in_time', $today)
                                          ->first();

            $schedule = $this->getAttendanceSchedule($today);
            
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

            if (!$existingAttendance) {
                // PRESENSI MASUK
                $isLate = $currentTime > $schedule->check_in_end;

                $attendance = Attendance::create([
                    'student_history_id' => $studentHistory->id,
                    'check_in_time' => $now,
                    'status' => $isLate ? 'late' : 'present',
                    // 'note' => 'Presensi manual via NIS'
                ]);

                // $action = 'masuk';
                $message = $isLate ? 'Presensi masuk berhasil (Terlambat)' : 'Presensi masuk berhasil';
                
            } else {
                // PRESENSI PULANG
                if ($existingAttendance->check_out_time) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sudah melakukan presensi pulang hari ini'
                    ], 400);
                }

                $existingAttendance->update([
                    'check_out_time' => $now,
                    'is_approved' => 1
                ]);

                $attendance = $existingAttendance;
                // $action = 'pulang';
                $message = 'Presensi pulang berhasil';
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'data' => [
                    'student' => [
                        'id' => $student->id,
                        'name' => $student->name,
                        'nis' => $student->nis,
                        'photo' => $student->photo,
                        'class' => $studentHistory->groups->name ?? '-'
                    ],
                    'attendance' => [
                        'id' => $attendance->id,
                        'check_in_time' => $attendance->check_in_time 
                            ? Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateTimeString() 
                            : null,
                        'check_out_time' => $attendance->check_out_time 
                            ? Carbon::parse($attendance->check_out_time)->timezone('Asia/Jakarta')->toDateTimeString() 
                            : null,
                        'status' => $attendance->status,
                        // 'note' => $attendance->note,
                    ],
                    // 'action' => $action,
                    'timestamp' => $now->toDateTimeString()
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal melakukan presensi: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function manualSickExcused(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'student_id' => 'required|exists:students,id',
    //         'status' => 'required|in:sick,excused',
    //         'reason' => 'nullable|string|max:500',
    //         'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120' // 5MB max
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Data tidak valid',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     try {
    //         DB::beginTransaction();

    //         $student = Student::find($request->student_id);
            
    //         // Ambil student history yang aktif
    //         $currentAcademicYear = AcademicYear::where('is_active', true)->first();
    //         $studentHistory = StudentHistory::where('student_id', $student->id)
    //                                        ->where('academic_year_id', $currentAcademicYear->id)
    //                                        ->where('status', 'active')
    //                                        ->with('groups')
    //                                        ->first();

    //         if (!$studentHistory) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Siswa tidak aktif pada tahun akademik ini'
    //             ], 400);
    //         }

    //         // Gunakan timezone WIB
    //         $today = Carbon::now('Asia/Jakarta')->startOfDay();

    //         // Cek apakah sudah ada presensi hari ini
    //         $existingAttendance = Attendance::where('student_history_id', $studentHistory->id)
    //                                       ->whereDate('check_in_time', $today)
    //                                       ->first();

    //         if ($existingAttendance) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Siswa sudah melakukan presensi hari ini'
    //             ], 400);
    //         }

    //         $filePath = null;
    //         if ($request->hasFile('file')) {
    //             $filePath = $request->file('file')
    //                 ->store('attendance/sick_excused', 'public');
    //         }

    //         $attendance = Attendance::create([
    //             'student_history_id' => $studentHistory->id,
    //             'check_in_time' => $today, // Set waktu ke awal hari dengan WIB
    //             'status' => $request->status,
    //             'reason' => $request->reason,
    //             'file' => $filePath,
    //             'note' => 'Presensi manual ' . ($request->status == 'sick' ? 'sakit' : 'izin')
    //         ]);

    //         DB::commit();

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Presensi ' . ($request->status == 'sick' ? 'sakit' : 'izin') . ' berhasil dicatat',
    //             'data' => [
    //                 'student' => [
    //                     'id' => $student->id,
    //                     'name' => $student->name,
    //                     'nis' => $student->nis,
    //                     'class' => $studentHistory->groups->name ?? '-'
    //                 ],
    //                 'attendance' => [
    //                     'id' => $attendance->id,
    //                     'check_in_time' => Carbon::parse($attendance->check_in_time)->timezone('Asia/Jakarta')->toDateTimeString(),
    //                     'status' => $attendance->status,
    //                     'reason' => $attendance->reason,
    //                     'file' => $attendance->file,
    //                 ]
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal mencatat presensi: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function getCurrentStudentInfo($cardUid)
    // {
    //     try {
    //         $student = Student::where('card_uid', $cardUid)->first();

    //         if (!$student) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Card UID tidak ditemukan'
    //             ], 404);
    //         }

    //         $currentAcademicYear = AcademicYear::where('is_active', true)->first();
    //         $studentHistory = StudentHistory::where('student_id', $student->id)
    //                                        ->where('academic_year_id', $currentAcademicYear->id)
    //                                        ->where('status', 'active')
    //                                        ->with('groups')
    //                                        ->first();

    //         return response()->json([
    //             'status' => 'success',
    //             'data' => [
    //                 'id' => $student->id,
    //                 'name' => $student->name,
    //                 'nis' => $student->nis,
    //                 'photo' => $student->photo,
    //                 'class' => $studentHistory->groups->name ?? '-'
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal mengambil data siswa: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

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