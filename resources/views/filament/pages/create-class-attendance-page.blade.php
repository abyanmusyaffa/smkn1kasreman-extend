<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Filter Form -->
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Filter Kelas dan Tanggal</h2>
            <form wire:submit.prevent="">
                {{ $this->form }}
            </form>
        </div>

        <!-- Instructions (when no class selected) -->
        {{-- @if(!$selectedGroupId)
            <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Cara Menggunakan</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ol class="list-decimal list-inside space-y-1">
                                <li>Pilih tahun ajaran dan kelas yang akan diabsen</li>
                                <li>Pilih tanggal presensi</li>
                                <li>Gunakan tabel untuk mengatur status setiap siswa</li>
                                <li>Gunakan bulk actions untuk mengatur multiple siswa sekaligus</li>
                                <li>Klik "Buat Presensi" untuk menyimpan</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}

        <!-- Students Table -->
        @if($selectedGroupId)
            <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Siswa</h3>
                        <div class="text-sm text-gray-500">
                            Total: {{ $this->getTableQuery()->count() }} siswa
                        </div>
                    </div>
                </div>
                
                {{ $this->table }}
            </div>

            <!-- Tips -->
            {{-- <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-amber-800">Tips</h3>
                        <div class="mt-1 text-sm text-amber-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Klik dropdown Status Presensi untuk mengubah status - data langsung tersimpan</li>
                                <li>Pilih multiple siswa dengan checkbox, lalu gunakan Bulk Actions</li>
                                <li>Status Existing menunjukkan presensi yang sudah ada</li>
                                <li>Hanya status Hadir/Terlambat/Tidak Presensi Pulang (berdasarkan waktu)</li>
                                <li>Waktu masuk/pulang diatur otomatis sesuai jadwal</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> --}}
        @endif
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>