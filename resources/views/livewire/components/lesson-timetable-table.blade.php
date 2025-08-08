{{-- @dd($lessonSessions) --}}
<div class="bg-white w-full p-4 flex flex-col gap-6">
    <!-- Filters -->
    <div class="flex flex-col w-full lg:w-96 gap-4 self-end">
        {{-- Filter Kelas --}}
        <x-select
            label="Pilih Kelas"
            placeholder="Pilih Kelas"
            wire:model.live="selectedGroup"
            :options="$groups"
            option-label="name"
            option-value="id"
            clearable
            searchable
        />
    

        {{-- Filter Guru --}}
        <x-select
            label="Pilih Guru"
            placeholder="Semua Guru"
            wire:model.live="selectedTeacher"
            :options="$teachers"
            option-label="name"
            option-value="id"
            clearable
            searchable
        />
    </div>

    <!-- Schedule Table -->
    <div class="flex flex-col items-center gap-4">
        @if($selectedGroup || $selectedTeacher)
            <!-- Table Loading Overlay -->
            <div wire:loading.delay class="flex w-full gap-2 text-blue-600 text-sm items-center justify-center">
                <span class="icon-[mingcute--loading-3-fill] animate-spin"></span>
                <p class="inline">Memperbarui...</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-4 lg:gap-8 w-full" wire:loading.remove >
                @foreach($days as $day => $dayLabel)
                <div class="flex flex-col w-full rounded-xl gap-1">
                    <div class="w-full flex bg-blue-600 justify-center rounded-md py-1">
                        <h3 class="text-slate-50 font-semibold text-lg">{{ $dayLabel }}</h3>
                    </div>
                    <div class="w-full flex flex-col gap-1 lg:gap-2">
                        @foreach($lessonSessions->where('type', $day === 'friday' ? 'friday' : ( $day === 'monday' ? 'monday' : 'tuesday-thursday')) as $lessonSession)
                        <div class="flex flex-col w-full min-h-[136px] border border-blue-300 rounded-md overflow-x-hidden" >
                            <div class="flex w-full justify-center gap-0.5 py-0.5 {{ str_contains(strtolower($lessonSession['number']), 'istirahat') || str_contains(strtolower($lessonSession['number']), 'upacara') ? 'bg-purple-400 text-slate-50' : 'bg-blue-200 text-blue-800' }}">
                                <p class=" text-sm  italic">Sesi {{  $lessonSession['number'] }} <span class="font-medium">{{ \Carbon\Carbon::parse($lessonSession['start_time'])->translatedFormat('H:i') . '-' . \Carbon\Carbon::parse($lessonSession['end_time'])->translatedFormat('H:i')  }}</span></p>
                            </div>
                            <div class="flex w-full flex-col gap-1 items-center justify-center p-1">
                                @php
                                    $schedulesToday = $this->getSchedulesByDay($day);
                                    $matchingSchedules = $schedulesToday->filter(fn($s) => in_array($lessonSession->id, (array) $s->lesson_session));
                                @endphp
        
                                @forelse($matchingSchedules as $schedule)
                                    <div class="flex items-center w-full justify-center gap-1 text-xs text-slate-600">
                                        <span class="icon-[mdi--user]"></span>
                                        <p class="italic">{{ $schedule->staff->name }}</p>
                                    </div>
                                    <p class="text-slate-700 text-sm text-center h-[3lh] line-clamp-3 font-medium">{{ $schedule->subjects->name }}</p>
                                    <div class="flex w-full justify-between">
                                        @if($selectedTeacher && !$selectedGroup)
                                        <div class="flex items-center w-full justify-center gap-1 text-xs text-slate-600">
                                            <span class="icon-[mdi--account-group]"></span>
                                            <p class="italic">{{ $schedule->groups->name }}</p>
                                        </div>
                                        @endif
                                        @if($schedule->rooms)
                                        <div class="flex items-center w-full justify-center gap-1 text-xs text-slate-600">
                                            <span class="icon-[mdi--building]"></span>
                                            <p class="italic">{{ $schedule->rooms->name }}</p>
                                        </div>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 italic ">Kosong</p>
                                @endforelse
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
                {{-- <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            @php
                                $days = [
                                    'monday' => 'Senin',
                                    'tuesday' => 'Selasa', 
                                    'wednesday' => 'Rabu',
                                    'thursday' => 'Kamis',
                                    'friday' => 'Jumat'
                                ];
                            @endphp
                            @foreach($days as $day => $dayLabel)
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200 last:border-r-0">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-day mr-2"></i>
                                        {{ $dayLabel }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $maxRows = 0;
                            foreach($days as $day => $dayLabel) {
                                $daySchedules = $this->getSchedulesByDay($day);
                                $maxRows = max($maxRows, $daySchedules->count());
                            }
                            $maxRows = max($maxRows, 1); // At least 1 row
                        @endphp

                        @for($row = 0; $row < $maxRows; $row++)
                            <tr class="hover:bg-gray-50 transition-colors">
                                @foreach($days as $day => $dayLabel)
                                    @php
                                        $daySchedules = $this->getSchedulesByDay($day)->values();
                                        $schedule = $daySchedules->get($row);
                                    @endphp
                                    <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 last:border-r-0 align-top">
                                        @if($schedule)
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 hover:bg-blue-100 transition-colors">
                                                <div class="font-semibold text-blue-900 mb-2">
                                                    <i class="fas fa-book mr-2"></i>
                                                    {{ $schedule->subject->name ?? '-' }}
                                                </div>
                                                
                                                <div class="text-sm text-gray-700 mb-2">
                                                    <i class="fas fa-user mr-2"></i>
                                                    {{ $schedule->staff->name ?? '-' }}
                                                </div>
                                                
                                                @if(!$selectedGroup)
                                                    <div class="text-sm text-gray-600 mb-2">
                                                        <i class="fas fa-users mr-2"></i>
                                                        {{ $schedule->group->name ?? '-' }}
                                                    </div>
                                                @endif
                                                
                                                <div class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $this->getSessionsText($schedule->lesson_session) }}
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endfor

                        @if($schedules->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-calendar-times text-4xl mb-4"></i>
                                        <p class="text-lg font-medium">Tidak ada jadwal ditemukan</p>
                                        <p class="text-sm">Silakan pilih kelas atau guru untuk melihat jadwal</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table> --}}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="text-gray-500">
                    <i class="fas fa-calendar-alt text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium mb-2">Pilih Kelas atau Guru untuk Melihat Jadwal</h3>
                    <p class="text-sm">Gunakan filter di atas untuk menampilkan jadwal pelajaran</p>
                </div>
            </div>
        @endif
    </div>
</div>