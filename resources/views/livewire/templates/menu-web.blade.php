<div class="hidden lg:flex lg:gap-0 2xl:gap-2 items-center">
    <a href="/" wire:navigate class="flex flex-col gap-1 px-2 group">
      <p class="text-slate-50">Beranda</p>
      <div class="w-full h-0.5 {{ $title === 'Beranda' ? 'bg-slate-50' : 'bg-transparent' }} group-hover:bg-slate-50 transition-all" ... wire:current="bg-slate-50"></div>
    </a>
    
    <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
      <div class="flex gap-1 items-center">
        <p class="text-slate-50 whitespace-nowrap">{{ $school->alias }} Kita</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
      </div>
      <div class="w-full h-0.5 bg-transparent"></div>
      <!-- Dropdown -->
      <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all shadow-xl">
        <a href="/about" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Tentang Sekolah' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500 whitespace-nowrap">Tentang Sekolah</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        <a href="/oraganizational-structure" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Struktur Organisasi' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500 whitespace-nowrap">Struktur Organisasi</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        <a href="/staff" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Guru & Tenaga Kependidikan' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500 whitespace-nowrap">GTK</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        <a href="/achievement" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Prestasi' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Prestasi</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        <a href="/facility" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Sarana Prasarana' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500 whitespace-nowrap">Sarana Prasarana</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        <a href="/gallery" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Galeri' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500 whitespace-nowrap">Galeri</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
      </div>
      <!-- Dropdown -->
    </div>

    <a href="/major" wire:navigate class="flex flex-col gap-1 px-2 group">
      <p class="text-slate-50 whitespace-nowrap">Program Keahlian</p>
      <div class="w-full h-0.5 {{ $title === 'Program Keahlian' ? 'bg-slate-50' : 'bg-transparent' }} group-hover:bg-slate-50 transition-all"></div>
    </a>

    <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
      <div class="flex gap-1 items-center">
        <p class="text-slate-50 whitespace-nowrap">Unit Kerja</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
      </div>
      <div class="w-full h-0.5 bg-transparent"></div>
      <!-- Dropdown -->
      <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all shadow-xl">
        @foreach($school_departments as $school_department)
        <div class="flex flex-col gap-1 group group/dropside relative">
          <div class="flex gap-1 items-center text-sm  {{ $title === $school_department->name || $school_department->units->contains('name', $title) || ($school_department->name === 'Kurikulum' && in_array($title, ['Kalender Akademik', 'Jadwal Pelajaran'])) || ($school_department->name === 'Kesiswaan' && in_array($title, [$osis_name, 'Ekstrakurikuler', 'Tata Tertib', 'Agenda Siswa'])) || ($school_department->name === 'Humas' && in_array($title, ['Praktek Kerja Lapangan', 'Tracer Study'])) || ($school_department->name === 'Sarpras' && in_array($title, ['Lab & Bengkel'])) ? 'text-blue-500' : 'text-slate-500' }}  group-hover:text-blue-500">
            <p class="whitespace-nowrap">{{ $school_department->name }}</p>
            <span class="icon-[mdi--chevron-right]"></span>
          </div>
          <div class="h-[1px] w-full bg-slate-200"></div>
          <div class="w-64 h-fit rounded-lg absolute left-[72px] -top-4 bg-transparent hidden group-hover/dropside:flex ps-12 py-4 transition-all ">
            <div class="size-fit flex flex-col px-4 py-2 gap-2 rounded-lg bg-slate-50 shadow-xl">
              <a href="/d/{{ $school_department->slug }}" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === $school_department->name ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Profil</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              @foreach($school_department->units as $unit )
              <a href="/u/{{ $unit->slug }}" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === $unit->name ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">{{ $unit->name }}</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              @endforeach
              @if($school_department->name === 'Kurikulum')
              <a href="/academic-calendar" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === 'Kalender Akademik' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Kalender Akademik</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              <a href="/lesson-timetable" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === 'Jadwal Pelajaran' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Jadwal Pelajaran</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              @elseif($school_department->name === 'Kesiswaan')
              <a href="/e/{{ $osis_slug }}" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === $osis_name ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">OSIS</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              <a href="/extracurricular" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === 'Ekstrakurikuler' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Ekstrakurikuler</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              <a href="/student-regulation" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === 'Tata Tertib' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Tata Tertib</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              <a href="/student-event" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === 'Agenda Siswa' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Agenda Siswa</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              @elseif($school_department->name === 'Humas')
              <a href="/internship" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === 'Praktek Kerja Lapangan'  ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">PKL</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              <a href="/alumni" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === 'Tracer Study' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Tracer Study</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              @elseif($school_department->name === 'Sarpras')
              <a href="/lab-workshop" wire:navigate class="flex flex-col gap-1 group/active">
                <p class="text-sm whitespace-nowrap {{ $title === 'Lab & Bengkel'  ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Lab & Bengkel</p>
                <div class="h-[1px] w-full bg-slate-200"></div>
              </a>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <!-- Dropdown -->
    </div>

    <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
      <div class="flex gap-1 items-center">
        <p class="text-slate-50 whitespace-nowrap">Program Sekolah</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
      </div>
      <div class="w-full h-0.5 bg-transparent"></div>
      <!-- Dropdown -->
      {{-- <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all shadow-xl">
    
        @foreach($school_programs as $program)
        @if($program->name === 'Teaching Factory')
          <div class="group relative">
            <div class="flex gap-1 items-center text-sm {{ ($title === $program->name || $teaching_factories->pluck('name')->contains($title)) ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">
              <p>{{ $program->name }}</p>
              <span class="icon-[mdi--chevron-right]"></span>
            </div>
            <div class="absolute left-28 top-0 hidden group-hover:flex flex-col bg-slate-50 shadow-xl rounded-lg p-2">
              <a href="/program/{{ $program->slug }}" wire:navigate class="text-sm {{ $title === $program->name ? 'text-blue-500' : 'text-slate-500' }}">Profil</a>
              @foreach($teaching_factories as $factory)
                <a href="/t/{{ $factory->slug }}" wire:navigate class="text-sm {{ $title === $factory->name ? 'text-blue-500' : 'text-slate-500' }}">{{ $factory->name }}</a>
              @endforeach
            </div>
          </div>
      
        @elseif($program->name === 'UPJ')
          <div class="group relative">
            <div class="flex gap-1 items-center text-sm {{ ($title === $program->name || $business_units->pluck('name')->contains($title)) ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">
              <p>{{ $program->name }}</p>
              <span class="icon-[mdi--chevron-right]"></span>
            </div>
            <div class="absolute left-28 top-0 hidden group-hover:flex flex-col bg-slate-50 shadow-xl rounded-lg p-2">
              <a href="/program/{{ $program->slug }}" wire:navigate class="text-sm {{ $title === $program->name ? 'text-blue-500' : 'text-slate-500' }}">Profil</a>
              @foreach($business_units as $unit)
                <a href="/b/{{ $unit->slug }}" wire:navigate class="text-sm {{ $title === $unit->name ? 'text-blue-500' : 'text-slate-500' }}">{{ $unit->name }}</a>
              @endforeach
            </div>
          </div>
      
        @else
          <a href="/program/{{ $program->slug }}" wire:navigate class="text-sm {{ $title === $program->name ? 'text-blue-500' : 'text-slate-500' }}">
            {{ $program->name }}
          </a>
        @endif
        @endforeach

      </div> --}}
      <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all shadow-xl">
        
        @foreach($school_programs as $program)
          @if($program->name === 'Teaching Factory')
          <div class="flex flex-col gap-1 group group/dropside relative">
            <div class="flex gap-1 items-center text-sm {{ ($title === $program->name || $teaching_factories->pluck('name')->contains($title)) ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">
              <p class="whitespace-nowrap">{{ $program->name }}</p>
              <span class="icon-[mdi--chevron-right]"></span>
            </div>
            <div class="h-[1px] w-full bg-slate-200"></div>
            <div class="w-64 h-fit rounded-lg absolute left-28 -top-4 bg-transparent hidden group-hover/dropside:flex ps-12 py-4 transition-all ">
              <div class="size-fit flex flex-col px-4 py-2 gap-2 rounded-lg bg-slate-50 shadow-xl">
                <a href="/p/{{ $program->slug }}" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === $program->name ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Profil</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                @foreach($teaching_factories as $teaching_factory)
                <a href="/t/{{ $teaching_factory->slug }}" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === $teaching_factory->name ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">{{ $teaching_factory->name }}</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                @endforeach
              </div>
            </div>
          </div>
          @elseif($program->name === 'UPJ')
          <div class="flex flex-col gap-1 group group/dropside relative">
            <div class="flex gap-1 items-center text-sm {{ ($title === $program->name || $business_units->pluck('name')->contains($title)) ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">
              <p>{{ $program->name }}</p>
              <span class="icon-[mdi--chevron-right]"></span>
            </div>
            <div class="h-[1px] w-full bg-slate-200"></div>
            <div class="w-64 h-fit rounded-lg absolute left-28 -top-4 bg-transparent hidden group-hover/dropside:flex ps-12 py-4 transition-all">
              <div class="size-fit flex flex-col px-4 py-2 gap-2 rounded-lg bg-slate-50 shadow-xl">
                <a href="/p/{{ $program->slug }}" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === $program->name ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Profil</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                @foreach($business_units as $business_unit)
                <a href="/b/{{ $business_unit->slug }}" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === $business_unit->name ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">{{ $business_unit->name }}</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                @endforeach
              </div>
            </div>
          </div>
          @else
          <a href="/p/{{ $program->slug }}" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === $program->name ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">{{ $program->name }}</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          @endif
        @endforeach
        
      </div>
      <!-- Dropdown -->
    </div>

    <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
      <div class="flex gap-1 items-center">
        <p class="text-slate-50">Informasi</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
      </div>
      <div class="w-full h-0.5 bg-transparent"></div>
      <!-- Dropdown -->
      <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all shadow-xl">
        <a href="/news" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Berita' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Berita</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        <a href="/announcement" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Pengumuman' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Pengumuman</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        <a href="/partner" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Mitra DU/DI' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Mitra DU/DI</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        <a href="/jobfair" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Lowongan Pekerjaan' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Lowongan</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        <a href="/enrollment" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Informasi SPMB' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">SPMB</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
      </div>
      <!-- Dropdown -->
    </div>

    <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
      <div class="flex gap-1 items-center">
        <p class="text-slate-50 whitespace-nowrap">Web Link</p>
        <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
      </div>
      <div class="w-full h-0.5 bg-transparent"></div>
      <!-- Dropdown -->
      <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all shadow-xl">
        <a href="/download" wire:navigate class="flex flex-col gap-1 group">
          <p class="text-sm {{ $title === 'Download Area' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500 whitespace-nowrap">Download Area</p>
          <div class="h-[1px] w-full bg-slate-200"></div>
        </a>
        @foreach($web_links as $weblink)
          <a href="{{ $weblink->url }}" class="flex flex-col gap-1 group">
            <p class="text-sm text-slate-500 group-hover:text-blue-500">{{ $weblink->title }}</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
        @endforeach
      </div>
      <!-- Dropdown -->
    </div>
  </div>