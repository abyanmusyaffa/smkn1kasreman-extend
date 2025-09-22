<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Student Info Card -->
        <div class="flex gap-4 w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
            @if($student_history->students->photo)
                <img src="{{ Storage::url($student_history->students->photo) }}" 
                        alt="{{ $student_history->students->name }}" 
                        class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
            @else
                <div class="w-16 h-16 rounded-full bg-gray-500 flex items-center justify-center border-2">
                    <x-heroicon-o-user class="w-8"/>
                </div>
            @endif
            <div class="flex flex-col">
                <h2 class="text-xl font-semibold text-gray-900">{{ $student_history->students->name }}</h2>
                <p class="text-gray-400 italic text-sm">{{ $student_history->students->nis }}</p>
                <p class="text-sm text-gray-400">
                    {{ $student_history->groups?->name }} - {{ $student_history->academic_years?->name }} Semester {{ $student_history->academic_years?->semester }}
                </p>
            </div>
        </div>

        <!-- Attendance Statistics -->
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $totalAttendance }}</div>
                    <div class="text-sm text-gray-400">Total Presensi</div>
                </div>
            </div>

            <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $attendanceStats['present'] ?? 0 }}</div>
                    <div class="text-sm text-gray-400">Hadir</div>
                </div>
            </div>

            <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-yellow-600">{{ $attendanceStats['late'] ?? 0 }}</div>
                    <div class="text-sm text-gray-400">Terlambat</div>
                </div>
            </div>

            <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $attendanceStats['missing'] ?? 0 }}</div>
                    <div class="text-sm text-gray-400">Tidak Presensi Pulang</div>
                </div>
            </div>

            <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ ($attendanceStats['excused'] ?? 0) + ($attendanceStats['sick'] ?? 0) }}</div>
                    <div class="text-sm text-gray-400">Izin/Sakit</div>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>