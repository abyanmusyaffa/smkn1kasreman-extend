<x-filament-panels::page>
    <div class="space-y-6">
        @if($student_history)
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
        @endif

        <!-- Form -->
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-4">
            <x-filament-panels::form wire:submit="create"> 
                {{ $this->form }}
         
                <x-filament-panels::form.actions 
                    :actions="$this->getFormActions()"
                /> 
            </x-filament-panels::form>
            {{-- <form wire:submit.prevent="create">
                {{ $this->form }}
                
                <div class="flex justify-end space-x-3 mt-6">
                    {{ $this->getFormActions() }}
                </div>
            </form> --}}
        </div>

        <!-- Instructions -->
        {{-- <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-blue-800">Petunjuk Penggunaan:</h3>
                    <ul class="mt-1 text-sm text-blue-700 list-disc list-inside space-y-1">
                        <li>Status akan otomatis terdeteksi berdasarkan waktu masuk</li>
                        <li>Untuk status Izin/Sakit, wajib mengisi alasan</li>
                        <li>File pendukung dapat berupa gambar atau PDF (maksimal 2MB)</li>
                        <li>Presensi yang sudah disetujui tidak dapat diubah tanpa persetujuan admin</li>
                    </ul>
                </div>
            </div>
        </div> --}}
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>