<div class="flex-col items-center lg:hidden w-full min-h-[calc(100dvh-64px)] bg-gradient-to-b from-blue-600/80 to-blue-800/90 absolute right-full peer-checked:translate-x-full top-16 px-4 py-4 gap-2 flex transition-all duration-700">
    {{-- Beranda --}}
    <a href="/" wire:navigate class="font-medium text-slate-50 text-xl ">Beranda</a>

    <div class="flex flex-col w-full">
    <input type="checkbox" class="peer hidden" id="skankakita-menu" />
    <label for="skankakita-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
        <p class="font-medium text-slate-50 text-xl whitespace-nowrap">{{ $school->alias }} Kita</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
    </label>
    <!-- dropdown -->
    <div class="flex-col w-full gap-2 rounded-lg items-center hidden peer-checked:flex transition-all py-2" id="dropdownMenu">
        <a href="/about" wire:navigate class="text-slate-50 whitespace-nowrap">Tentang Sekolah</a>
        <a href="/oraganizational-structure" wire:navigate class="text-slate-50 whitespace-nowrap">Struktur Organisasi</a>
        <a href="/staff" wire:navigate class="text-slate-50 whitespace-nowrap">GTK</a>
        <a href="/achievement" wire:navigate class="text-slate-50 whitespace-nowrap">Prestasi</a>
        <a href="/facility" wire:navigate class="text-slate-50 whitespace-nowrap">Sarana Prasarana</a>
        <a href="/gallery" wire:navigate class="text-slate-50 whitespace-nowrap">Galeri</a>
    </div>
    <!-- dropdown -->
    </div>

    <a href="/major" wire:navigate class="font-medium text-slate-50 text-xl">Program Keahlian</a>

    <div class="flex flex-col w-full">
    <input type="checkbox" class="peer hidden" id="unit-menu" />
    <label for="unit-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
        <p class="font-medium text-slate-50 text-xl whitespace-nowrap">Unit Kerja</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
    </label>
    <!-- dropdown -->
    <div class="flex-col w-full gap-2 rounded-lg items-center hidden peer-checked:flex transition-all py-2" id="dropdownMenu">
        @foreach($school_departments as $school_department)
        <div class="w-full flex flex-col">
            <input type="checkbox" class="peer hidden" id="{{ $school_department->slug }}-menu" />
            <label for="{{ $school_department->slug }}-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
                <p class="text-slate-50 text-lg whitespace-nowrap">{{ $school_department->name }}</p>
                <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
            </label>
            <div class="w-full flex-col items-center hidden peer-checked:flex transition-all duration-500">
                <a href="/d/{{ $school_department->slug }}" wire:navigate class="text-slate-50 whitespace-nowrap">Profil</a>
                @foreach($school_department->units as $unit )
                <a href="/u/{{ $unit->slug }}" wire:navigate class="text-slate-50 whitespace-nowrap">{{ $unit->name }}</a>
                @endforeach
                @if($school_department->name === 'Kurikulum')
                <a href="/academic-calendar" wire:navigate class="text-slate-50 whitespace-nowrap">Kalender Akademik</a>
                <a href="/lesson-timetable" wire:navigate class="text-slate-50 whitespace-nowrap">Jadwal Pelajaran</a>
                @elseif($school_department->name === 'Kesiswaan')
                <a href="/e/{{ $osis_slug }}" wire:navigate class="text-slate-50 whitespace-nowrap">OSIS</a>
                <a href="/extracurricular" wire:navigate class="text-slate-50 whitespace-nowrap">Ekstrakurikuler</a>
                <a href="/student-regulation" wire:navigate class="text-slate-50 whitespace-nowrap">Tata Tertib</a>
                <a href="/student-event" wire:navigate class="text-slate-50 whitespace-nowrap">Agenda Siswa</a>
                @elseif($school_department->name === 'Humas')
                <a href="/internship" wire:navigate class="text-slate-50 whitespace-nowrap">PKL</a>
                <a href="/alumni" wire:navigate class="text-slate-50 whitespace-nowrap">Tracer Study</a>
                @elseif($school_department->name === 'Sarpras')
                <a href="/lab-workshop" wire:navigate class="text-slate-50 whitespace-nowrap">Lab & Bengkel</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <!-- dropdown -->
    </div>

    <div class="flex flex-col w-full">
    <input type="checkbox" class="peer hidden" id="program-skolah-menu" />
    <label for="program-skolah-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
        <p class="font-medium text-slate-50 text-xl whitespace-nowrap">Program Sekolah</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
    </label>
    <!-- dropdown -->
    <div class="flex-col w-full gap-2 rounded-lg items-center hidden peer-checked:flex transition-all py-2" id="dropdownMenu">
        
        @foreach($school_programs as $program)
            @if($program->name === 'Teaching Factory')
            <div class="w-full flex flex-col">
                <input type="checkbox" class="peer hidden" id="{{ $program->slug }}-menu" />
                <label for="{{ $program->slug }}-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
                    <p class="text-slate-50 text-lg whitespace-nowrap">{{ $program->name  }}</p>
                    <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
                </label>
                <div class="w-full flex-col items-center hidden peer-checked:flex transition-all duration-500">
                    <a href="/p/{{ $program->slug }}" wire:navigate class="text-slate-50 whitespace-nowrap">Profil</a>
                    @foreach($teaching_factories as $teaching_factory)
                    <a href="/t/{{ $teaching_factory->slug }}" wire:navigate class="text-slate-50 whitespace-nowrap">{{ $teaching_factory->name }}</a>
                    @endforeach
                </div>
            </div>
            @elseif($program->name === 'UPJ')
            <div class="w-full flex flex-col">
                <input type="checkbox" class="peer hidden" id="{{ $program->slug }}-menu" />
                <label for="{{ $program->slug }}-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
                    <p class="text-slate-50 text-lg whitespace-nowrap">{{ $program->name }}</p>
                    <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
                </label>
                <div class="w-full flex-col items-center hidden peer-checked:flex transition-all duration-500">
                    <a href="/p/{{ $program->slug }}" wire:navigate class="text-slate-50 whitespace-nowrap">Profil</a>
                    @foreach($business_units as $business_unit)
                    <a href="/b/{{ $business_unit->slug }}" wire:navigate class="text-slate-50 whitespace-nowrap">{{ $business_unit->name }}</a>
                    @endforeach
                </div>
            </div>
            @else
            <a href="/p/{{ $program->slug  }}" wire:navigate class="text-slate-50 text-lg whitespace-nowrap">{{ $program->name }}</a>
            @endif
        @endforeach
    </div>
    <!-- dropdown -->
    </div>

    <div class="flex flex-col w-full">
    <input type="checkbox" class="peer hidden" id="informasi-menu" />
    <label for="informasi-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
        <p class="font-medium text-slate-50 text-xl whitespace-nowrap">Informasi</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
    </label>

    <!-- dropdown -->
    <div class="flex-col w-full gap-2 rounded-lg items-center hidden peer-checked:flex transition-all py-2" id="dropdownMenu">
        <a href="/news" wire:navigate class="text-slate-50 whitespace-nowrap">Berita</a>
        <a href="/announcement" wire:navigate class="text-slate-50 whitespace-nowrap">Pengumuman</a>
        <a href="/jobfair" wire:navigate class="text-slate-50 whitespace-nowrap">Lowongan</a>
        <a href="/partner" wire:navigate class="text-slate-50 whitespace-nowrap">Mitra DU/DI</a>
        <a href="/enrollment" wire:navigate class="text-slate-50 whitespace-nowrap">SPMB</a>
    </div>
    <!-- dropdown -->
    </div>

    <div class="flex flex-col w-full">
    <input type="checkbox" class="peer hidden" id="weblink-menu" />
    <label for="weblink-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
        <p class="font-medium text-slate-50 text-xl whitespace-nowrap">Web Link</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
    </label>

    <!-- dropdown -->
    <div class="flex-col w-full gap-2 rounded-lg items-center hidden peer-checked:flex transition-all py-2" id="dropdownMenu">
        <a href="/download" wire:navigate class="text-slate-50 whitespace-nowrap">Download Area</a>
        @foreach($web_links as $weblink)
        <a href="{{ $weblink->url }}" class="text-slate-50 whitespace-nowrap">{{ $weblink->title }}</a>
        @endforeach
    </div>
    <!-- dropdown -->
    </div>
</div>