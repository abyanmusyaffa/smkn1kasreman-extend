<?php

namespace App\Http\Controllers\API\Attendance;

use App\Models\Group;
use App\Models\Attendance;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\StudentHistory;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExportController extends Controller
{
/**
     * Export attendance by date
     * Returns: Student names with their check-in/out times and status
     */
    public function exportByDate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
                'group_id' => 'required|exists:groups,id',
            ], [
                'date.required' => 'Tanggal harus diisi',
                'date.date' => 'Format tanggal tidak valid',
                'group_id.required' => 'Kelas harus dipilih',
                'group_id.exists' => 'Kelas tidak ditemukan',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $date = $request->date;
            $groupId = $request->group_id;

            // Get group info
            $group = Group::find($groupId);

            // Get attendances for the date and group
            $attendances = Attendance::with(['student_histories.students', 'student_histories.groups'])
                ->whereDate('check_in_time', $date)
                ->whereHas('student_histories', function($q) use ($groupId) {
                    $q->where('group_id', $groupId);
                })
                ->orderBy('check_in_time')
                ->get();

            if ($attendances->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada data presensi untuk tanggal dan kelas tersebut',
                ], 404);
            }

            // Create spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator('Attendance System')
                ->setTitle('Presensi Berdasarkan Tanggal')
                ->setSubject('Attendance Report');

            // Header
            $sheet->setCellValue('A1', 'LAPORAN PRESENSI BERDASARKAN TANGGAL');
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Info
            $sheet->setCellValue('A2', 'Tanggal: ' . date('d F Y', strtotime($date)));
            $sheet->setCellValue('A3', 'Kelas: ' . $group->name);
            $sheet->getStyle('A2:A3')->getFont()->setBold(true);

            // Table Header
            $headerRow = 5;
            $headers = ['No', 'NIS', 'Nama Siswa', 'Masuk', 'Pulang', 'Status'];
            $column = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($column . $headerRow, $header);
                $column++;
            }

            // Style header
            $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF4472C4');
            $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)
                ->getFont()
                ->setBold(true)
                ->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);

            // Data
            $row = $headerRow + 1;
            $no = 1;
            $statusMap = [
                'present' => 'Hadir',
                'late'    => 'Terlambat',
                'missing' => 'Tidak Presensi Pulang',
                'sick'    => 'Sakit',
                'excused' => 'Izin',
            ];
            foreach ($attendances as $attendance) {
                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, $attendance->student_histories->students->nis);
                $sheet->setCellValue('C' . $row, $attendance->student_histories->students->name);
                $sheet->setCellValue('D' . $row, $attendance->check_in_time ? date('H:i:s', strtotime($attendance->check_in_time)) : '-');
                $sheet->setCellValue('E' . $row, $attendance->check_out_time ? date('H:i:s', strtotime($attendance->check_out_time)) : '-');
                $sheet->setCellValue('F' . $row, $statusMap[$attendance->status] ?? ucfirst($attendance->status));
                
                $row++;
                $no++;
            }

            // Style data rows
            $lastRow = $row - 1;
            $sheet->getStyle('A' . $headerRow . ':F' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Center align No column
            $sheet->getStyle('A' . ($headerRow + 1) . ':F' . $lastRow)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Center align status column
            $sheet->getStyle('E' . ($headerRow + 1) . ':F' . $lastRow)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Auto size columns
            foreach (range('A', 'F') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Generate file
            $fileName = 'Presensi_' . date('Ymd', strtotime($date)) . '_' . str_replace(' ', '_', $group->name) . '.xlsx';
            
            $writer = new Xlsx($spreadsheet);
            $temp_file = tempnam(sys_get_temp_dir(), $fileName);
            $writer->save($temp_file);

            return response()->download($temp_file, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal export data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export attendance by student
     * Returns: Dates with check-in/out times and status for specific student
     */
    public function exportByStudent(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'student_history_id' => 'required|exists:student_histories,id',
                'academic_year_id' => 'required|exists:academic_years,id',
            ], [
                'student_history_id.required' => 'Siswa harus dipilih',
                'student_history_id.exists' => 'Data siswa tidak ditemukan',
                'academic_year_id.required' => 'Tahun ajaran harus dipilih',
                'academic_year_id.exists' => 'Tahun ajaran tidak ditemukan',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $studentHistoryId = $request->student_history_id;
            $academicYearId = $request->academic_year_id;

            // Get student history
            $studentHistory = StudentHistory::with(['students', 'groups', 'academic_years'])
                ->find($studentHistoryId);

            // Get attendances
            $attendances = Attendance::where('student_history_id', $studentHistoryId)
                ->whereHas('student_histories', function($q) use ($academicYearId) {
                    $q->where('academic_year_id', $academicYearId);
                })
                ->orderBy('check_in_time')
                ->get();

            if ($attendances->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada data presensi untuk siswa tersebut',
                ], 404);
            }

            // Create spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator('Attendance System')
                ->setTitle('Presensi Berdasarkan Siswa')
                ->setSubject('Attendance Report');

            // Header
            $sheet->setCellValue('A1', 'LAPORAN PRESENSI BERDASARKAN SISWA');
            $sheet->mergeCells('A1:F1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Info
            $sheet->setCellValue('A2', 'Nama: ' . $studentHistory->students->name);
            $sheet->setCellValue('A3', 'NIS: ' . $studentHistory->students->nis);
            $sheet->setCellValue('A4', 'Kelas: ' . $studentHistory->groups->name);
            $sheet->setCellValue(
                'A5',
                'Tahun Ajaran: ' . $studentHistory->academic_years->name . ' - ' .
                ($studentHistory->academic_years->semester === '1' ? 'Semester Ganjil' : 'Semester Genap')
            );
            $sheet->getStyle('A2:A5')->getFont()->setBold(true);

            // Table Header
            $headerRow = 7;
            $headers = ['No', 'Tanggal', 'Hari', 'Masuk', 'Pulang', 'Status'];
            $column = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($column . $headerRow, $header);
                $column++;
            }

            // Style header
            $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF4472C4');
            $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)
                ->getFont()
                ->setBold(true)
                ->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);

            // Data
            $row = $headerRow + 1;
            $no = 1;
            
            // Day names in Indonesian
            $dayNames = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];

            $statusMap = [
                'present' => 'Hadir',
                'late'    => 'Terlambat',
                'missing' => 'Tidak Presensi Pulang',
                'sick'    => 'Sakit',
                'excused' => 'Izin',
            ];
            foreach ($attendances as $attendance) {
                $dayName = date('l', strtotime($attendance->check_in_time));
                $dayNameIndo = $dayNames[$dayName] ?? $dayName;

                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, date('d/m/Y', strtotime($attendance->check_in_time)));
                $sheet->setCellValue('C' . $row, $dayNameIndo);
                $sheet->setCellValue('D' . $row, $attendance->check_in_time ? date('H:i:s', strtotime($attendance->check_in_time)) : '-');
                $sheet->setCellValue('E' . $row, $attendance->check_out_time ? date('H:i:s', strtotime($attendance->check_out_time)) : '-');
                $sheet->setCellValue('F' . $row, $statusMap[$attendance->status] ?? ucfirst($attendance->status));
                
                $row++;
                $no++;
            }

            // Style data rows
            $lastRow = $row - 1;
            $sheet->getStyle('A' . $headerRow . ':F' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Center align columns
            $sheet->getStyle('A' . ($headerRow + 1) . ':A' . $lastRow)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C' . ($headerRow + 1) . ':C' . $lastRow)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . ($headerRow + 1) . ':F' . $lastRow)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Auto size columns
            foreach (range('A', 'F') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Generate file
            $fileName = 'Presensi_' . str_replace(' ', '_', $studentHistory->students->name) . '_' . date('Ymd') . '.xlsx';
            
            $writer = new Xlsx($spreadsheet);
            $temp_file = tempnam(sys_get_temp_dir(), $fileName);
            $writer->save($temp_file);

            return response()->download($temp_file, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal export data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Export attendance by group
     * Returns: Summary of attendance counts by status for each student
     */
    public function exportByGroup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'group_id' => 'required|exists:groups,id',
                'academic_year_id' => 'required|exists:academic_years,id',
            ], [
                'group_id.required' => 'Kelas harus dipilih',
                'group_id.exists' => 'Kelas tidak ditemukan',
                'academic_year_id.required' => 'Tahun ajaran harus dipilih',
                'academic_year_id.exists' => 'Tahun ajaran tidak ditemukan',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $groupId = $request->group_id;
            $academicYearId = $request->academic_year_id;

            // Get group and academic year info
            $group = Group::find($groupId);
            $academicYear = AcademicYear::find($academicYearId);

            // Get student histories for the group  
            $studentHistories = StudentHistory::with('students')
                ->where('group_id', $groupId)
                ->where('academic_year_id', $academicYearId)
                ->get();

            if ($studentHistories->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tidak ada siswa di kelas tersebut',
                ], 404);
            }

            // Get attendance summary
            $summaryData = [];
            foreach ($studentHistories as $studentHistory) {
                $attendances = Attendance::where('student_history_id', $studentHistory->id)->get();
                
                $summary = [
                    'name' => $studentHistory->students->name,
                    'nis' => $studentHistory->students->nis,
                    'hadir' => $attendances->where('status', 'present')->count(),
                    'terlambat' => $attendances->where('status', 'late')->count(),
                    'izin' => $attendances->where('status', 'excused')->count(),
                    'sakit' => $attendances->where('status', 'sick')->count(),
                    'tidak presensi pulang' => $attendances->where('status', 'missing')->count(),
                    'total' => $attendances->count(),
                ];
                
                $summaryData[] = $summary;
            }

            // Create spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set document properties
            $spreadsheet->getProperties()
                ->setCreator('Attendance System')
                ->setTitle('Rekap Presensi Berdasarkan Kelas')
                ->setSubject('Attendance Report');

            // Header
            $sheet->setCellValue('A1', 'REKAP PRESENSI BERDASARKAN KELAS');
            $sheet->mergeCells('A1:I1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Info
            $sheet->setCellValue('A2', 'Kelas: ' . $group->name);
            $sheet->setCellValue(
                'A3',
                'Tahun Ajaran: ' . $studentHistory->academic_years->name . ' - ' .
                ($studentHistory->academic_years->semester === '1' ? 'Semester Ganjil' : 'Semester Genap')
            );
            $sheet->getStyle('A2:A3')->getFont()->setBold(true);

            // Table Header
            $headerRow = 5;
            $headers = ['No', 'NIS', 'Nama Siswa', 'Hadir', 'Terlambat', 'Izin', 'Sakit', 'Tidak Presensi Pulang', 'Total'];
            $column = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($column . $headerRow, $header);
                $column++;
            }

            // Style header
            $sheet->getStyle('A' . $headerRow . ':I' . $headerRow)
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF4472C4');
            $sheet->getStyle('A' . $headerRow . ':I' . $headerRow)
                ->getFont()
                ->setBold(true)
                ->getColor()->setARGB('FFFFFFFF');
            $sheet->getStyle('A' . $headerRow . ':I' . $headerRow)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);

            // Data
            $row = $headerRow + 1;
            $no = 1;
            foreach ($summaryData as $data) {
                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, $data['nis']);
                $sheet->setCellValue('C' . $row, $data['name']);
                $sheet->setCellValue('D' . $row, $data['hadir']);
                $sheet->setCellValue('E' . $row, $data['terlambat']);
                $sheet->setCellValue('F' . $row, $data['izin']);
                $sheet->setCellValue('G' . $row, $data['sakit']);
                $sheet->setCellValue('H' . $row, $data['tidak presensi pulang']);
                $sheet->setCellValue('I' . $row, $data['total']);
                
                $row++;
                $no++;
            }

            // Style data rows
            $lastRow = $row - 1;
            $sheet->getStyle('A' . $headerRow . ':I' . $lastRow)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            // Center align numeric columns
            foreach (['A', 'C', 'D', 'E', 'F', 'G', 'H', 'I'] as $col) {
                $sheet->getStyle($col . ($headerRow + 1) . ':' . $col . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            // Auto size columns
            foreach (range('A', 'I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Generate file
            $fileName = 'Rekap_Presensi_' . str_replace(' ', '_', $group->name) . '_' . date('Ymd') . '.xlsx';
            
            $writer = new Xlsx($spreadsheet);
            $temp_file = tempnam(sys_get_temp_dir(), $fileName);
            $writer->save($temp_file);

            return response()->download($temp_file, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ])->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal export data: ' . $e->getMessage(),
            ], 500);
        }
    }
}
