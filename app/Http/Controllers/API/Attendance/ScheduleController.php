<?php

namespace App\Http\Controllers\API\Attendance;

use Illuminate\Http\Request;
use App\Models\AttendanceSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\AttendanceScheduleOverride;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $schedules = AttendanceSchedule::all();

            return response()->json([
                'status' => 'success',
                'data' => $schedules,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data jadwal presensi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday|unique:attendance_schedules,day',
                'check_in_start' => 'required|date_format:H:i:s',
                'check_in_end' => 'required|date_format:H:i:s|after:check_in_start',
                'check_out_start' => 'required|date_format:H:i:s',
                'check_out_end' => 'required|date_format:H:i:s|after:check_out_start',
            ], [
                'day.required' => 'Hari harus diisi',
                'day.in' => 'Hari tidak valid',
                'day.unique' => 'Jadwal untuk hari ini sudah ada',
                'check_in_start.required' => 'Waktu mulai check-in harus diisi',
                'check_in_start.date_format' => 'Format waktu check-in start harus HH:mm:ss',
                'check_in_end.required' => 'Waktu akhir check-in harus diisi',
                'check_in_end.date_format' => 'Format waktu check-in end harus HH:mm:ss',
                'check_in_end.after' => 'Waktu akhir check-in harus setelah waktu mulai',
                'check_out_start.required' => 'Waktu mulai check-out harus diisi',
                'check_out_start.date_format' => 'Format waktu check-out start harus HH:mm:ss',
                'check_out_end.required' => 'Waktu akhir check-out harus diisi',
                'check_out_end.date_format' => 'Format waktu check-out end harus HH:mm:ss',
                'check_out_end.after' => 'Waktu akhir check-out harus setelah waktu mulai',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $schedule = AttendanceSchedule::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal presensi berhasil ditambahkan',
                'data' => $schedule,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan jadwal presensi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     try {
    //         $schedule = AttendanceSchedule::find($id);

    //         if (!$schedule) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Jadwal presensi tidak ditemukan',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $schedule,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal mengambil data jadwal presensi: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $schedule = AttendanceSchedule::find($id);

            if (!$schedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal presensi tidak ditemukan',
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'day' => 'sometimes|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday|unique:attendance_schedules,day,' . $id,
                'check_in_start' => 'sometimes|date_format:H:i:s',
                'check_in_end' => 'sometimes|date_format:H:i:s|after:check_in_start',
                'check_out_start' => 'sometimes|date_format:H:i:s',
                'check_out_end' => 'sometimes|date_format:H:i:s|after:check_out_start',
            ], [
                'day.in' => 'Hari tidak valid',
                'day.unique' => 'Jadwal untuk hari ini sudah ada',
                'check_in_start.date_format' => 'Format waktu check-in start harus HH:mm:ss',
                'check_in_end.date_format' => 'Format waktu check-in end harus HH:mm:ss',
                'check_in_end.after' => 'Waktu akhir check-in harus setelah waktu mulai',
                'check_out_start.date_format' => 'Format waktu check-out start harus HH:mm:ss',
                'check_out_end.date_format' => 'Format waktu check-out end harus HH:mm:ss',
                'check_out_end.after' => 'Waktu akhir check-out harus setelah waktu mulai',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak valid',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $schedule->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal presensi berhasil diperbarui',
                'data' => $schedule,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui jadwal presensi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $schedule = AttendanceSchedule::find($id);

            if (!$schedule) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Jadwal presensi tidak ditemukan',
                ], 404);
            }

            $schedule->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Jadwal presensi berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus jadwal presensi: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getScheduleOverrides(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 5);
            $search = $request->get('search', '');
            $sortDirection = $request->get('sort_direction', 'desc');

            $query = AttendanceScheduleOverride::query();

            $query->where(function($q) use ($search) {
                $q->where('date', 'like', '%' . $search . '%')
                    ->orWhere('reason', 'like', '%' . $search . '%');
            });

            // // Filter by specific date
            // if ($request->has('date') && $request->date != '') {
            //     $query->whereDate('date', $request->date);
            // }

            // Filter by reason
            // if ($request->has('reason') && $request->reason != '') {
            //     $query->where('reason', 'like', '%' . $request->reason . '%');
            // }

            // Sorting by date (asc or desc)

            if (!in_array($sortDirection, ['asc', 'desc'])) {
                $sortDirection = 'desc';
            }
            $query->orderBy('date', $sortDirection);

            // Pagination

            // if (!is_numeric($perPage) || $perPage < 1) {
            //     $perPage = 10;
            // }

            $overrides = $query->paginate($perPage);

            $overrides->getCollection()->transform(function($override) {
                return [
                    'id' => $override->id,
                    'date' => $override->date,
                    'check_in_start' => $override->check_in_start,
                    'check_in_end' => $override->check_in_end,
                    'check_out_start' => $override->check_out_start,
                    'check_out_end' => $override->check_out_end,
                    'reason' => $override->reason,
                    'created_at' => $override->created_at ,
                    'updated_at' => $override->updated_at 
                ];
            });
            
            return response()->json([
                'status' => 'success',
                'data' => $overrides,
                'filters' => compact(
                    'search', 'sortDirection', 'perPage'
                ),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data override jadwal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created attendance override.
     */
    public function storeScheduleOverride(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date|unique:attendance_schedule_overrides,date',
                'check_in_start' => 'required|date_format:H:i:s',
                'check_in_end' => 'required|date_format:H:i:s|after:check_in_start',
                'check_out_start' => 'required|date_format:H:i:s',
                'check_out_end' => 'required|date_format:H:i:s|after:check_out_start',
                'reason' => 'required|string|max:255',
            ], [
                'date.required' => 'Tanggal harus diisi',
                'date.date' => 'Format tanggal tidak valid',
                'date.unique' => 'Override untuk tanggal ini sudah ada',
                'check_in_start.required' => 'Waktu mulai check-in harus diisi',
                'check_in_start.date_format' => 'Format waktu check-in start harus HH:mm:ss',
                'check_in_end.required' => 'Waktu akhir check-in harus diisi',
                'check_in_end.date_format' => 'Format waktu check-in end harus HH:mm:ss',
                'check_in_end.after' => 'Waktu akhir check-in harus setelah waktu mulai',
                'check_out_start.required' => 'Waktu mulai check-out harus diisi',
                'check_out_start.date_format' => 'Format waktu check-out start harus HH:mm:ss',
                'check_out_end.required' => 'Waktu akhir check-out harus diisi',
                'check_out_end.date_format' => 'Format waktu check-out end harus HH:mm:ss',
                'check_out_end.after' => 'Waktu akhir check-out harus setelah waktu mulai',
                'reason.required' => 'Alasan harus diisi',
                'reason.max' => 'Alasan maksimal 255 karakter',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $override = AttendanceScheduleOverride::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Override jadwal presensi berhasil ditambahkan',
                'data' => $override,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan override jadwal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified attendance override.
     */
    // public function showScheduleOverride(string $id)
    // {
    //     try {
    //         $override = AttendanceScheduleOverride::find($id);

    //         if (!$override) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Override jadwal tidak ditemukan',
    //             ], 404);
    //         }

    //         return response()->json([
    //             'status' => 'success',
    //             'data' => $override,
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Gagal mengambil data override jadwal: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    /**
     * Update the specified attendance override.
     */
    public function updateScheduleOverride(Request $request, string $id)
    {
        try {
            $override = AttendanceScheduleOverride::find($id);

            if (!$override) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Override jadwal tidak ditemukan',
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'date' => 'sometimes|date|unique:attendance_schedule_overrides,date,' . $id,
                'check_in_start' => 'sometimes|date_format:H:i:s',
                'check_in_end' => 'sometimes|date_format:H:i:s|after:check_in_start',
                'check_out_start' => 'sometimes|date_format:H:i:s',
                'check_out_end' => 'sometimes|date_format:H:i:s|after:check_out_start',
                'reason' => 'sometimes|string|max:255',
            ], [
                'date.date' => 'Format tanggal tidak valid',
                'date.unique' => 'Override untuk tanggal ini sudah ada',
                'check_in_start.date_format' => 'Format waktu check-in start harus HH:mm:ss',
                'check_in_end.date_format' => 'Format waktu check-in end harus HH:mm:ss',
                'check_in_end.after' => 'Waktu akhir check-in harus setelah waktu mulai',
                'check_out_start.date_format' => 'Format waktu check-out start harus HH:mm:ss',
                'check_out_end.date_format' => 'Format waktu check-out end harus HH:mm:ss',
                'check_out_end.after' => 'Waktu akhir check-out harus setelah waktu mulai',
                'reason.max' => 'Alasan maksimal 255 karakter',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $override->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Override jadwal berhasil diperbarui',
                'data' => $override,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui override jadwal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified attendance override.
     */
    public function destroyScheduleOverride(string $id)
    {
        try {
            $override = AttendanceScheduleOverride::find($id);

            if (!$override) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Override jadwal tidak ditemukan',
                ], 404);
            }

            $override->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Override jadwal berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus override jadwal: ' . $e->getMessage(),
            ], 500);
        }
    }
}
