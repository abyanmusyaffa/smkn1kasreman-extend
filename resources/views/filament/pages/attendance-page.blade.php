<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header Stats -->
        {{-- <div class="flex flex-col lg:flex-row gap-4">
            <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="flex items-center gap-4">
                    <x-heroicon-o-user class="w-8"/>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Siswa</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\StudentHistory::where('status', 'active')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="flex items-center gap-4">
                    <x-heroicon-o-check-circle class="w-8"/>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Hadir Hari Ini</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Attendance::whereDate('check_in_time', today())->where('status', 'present')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="flex items-center gap-4">
                    <x-heroicon-o-clock class="w-8"/>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Terlambat Hari Ini</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Attendance::whereDate('check_in_time', today())->where('status', 'late')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="w-full rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="flex items-center gap-4">
                    <x-heroicon-o-x-circle class="w-8"/>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Tidak Presensi Pulang Hari Ini</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Attendance::whereDate('check_in_time', today())->where('status', 'missing')->count() }}</p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Main Table -->
        <div class="">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>