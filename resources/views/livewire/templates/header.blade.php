{{-- @dd($title) --}}
<header>
  <nav class="w-full flex justify-between bg-gradient-to-r from-blue-500 to-blue-700 h-16 lg:h-24 px-4 lg:px-16 2xl:px-36 items-center fixed z-30">
    <!-- logo -->
    <a href="/" wire:navigate class="flex gap-2 2xl:gap-4 items-center">
      <img src="/storage/{{ $school->logo }}" class="w-9 lg:w-12 2xl:w-16" alt="logo-skanka" />
      <p class="font-medium text-slate-50 lg:text-lg 2xl:text-2xl">SMKN {{ $school->name }}</p>
    </a>
    <!-- logo -->

    <!-- menu web -->
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
          <a href="/staff" wire:navigate class="flex flex-col gap-1 group">
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
          {{-- <a href="/download" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Download Area' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Download Area</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a> --}}
        </div>
        <!-- Dropdown -->
      </div>

      <a href="/major" wire:navigate class="flex flex-col gap-1 px-2 group">
        <p class="text-slate-50 whitespace-nowrap">Program Keahlian</p>
        <div class="w-full h-0.5 {{ $title === 'Program Keahlian' ? 'bg-slate-50' : 'bg-transparent' }} group-hover:bg-slate-50 transition-all"></div>
      </a>

      <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
        <div class="flex gap-1 items-center">
          <p class="text-slate-50">Unit Kerja</p>
          <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
        </div>
        <div class="w-full h-0.5 bg-transparent"></div>
        <!-- Dropdown -->
        <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all shadow-xl">
          
          <div class="flex flex-col gap-1 group group/dropside relative">
            <div class="flex gap-1 items-center text-sm {{ $title === 'Kurikulum' || $title === 'kalender Akademik' || $title === 'Jadwal Pelajaran' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">
              <p>Kurikulum</p>
              <span class="icon-[mdi--chevron-right]"></span>
            </div>
            <div class="h-[1px] w-full bg-slate-200"></div>
            <div class="w-64 h-fit rounded-lg absolute left-20 -top-4 bg-transparent hidden group-hover/dropside:flex ps-12 py-4 transition-all ">
              <div class="size-fit flex flex-col px-4 py-2 gap-2 rounded-lg bg-slate-50 shadow-xl">
                <a href="/" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Kurikulum' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Profil</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                <a href="/" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Kalender Akademik' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Kalender Akademik</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                <a href="/" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Jadwal Pelajaran' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Jadwal Pelajaran</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
              </div>
            </div>
          </div>

          <div class="flex flex-col gap-1 group group/dropside relative">
            <div class="flex gap-1 items-center text-sm {{ $title === 'Kesiswaan' || $title === $osis_name || $title === 'Ekstrakurikuler' || $title === 'Agenda Siswa' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">
              <p>Kesiswaan</p>
              <span class="icon-[mdi--chevron-right]"></span>
            </div>
            <div class="h-[1px] w-full bg-slate-200"></div>
            <div class="w-64 h-fit rounded-lg absolute left-20 -top-4 bg-transparent hidden group-hover/dropside:flex ps-12 py-4 transition-all">
              <div class="size-fit flex flex-col px-4 py-2 gap-2 rounded-lg bg-slate-50 shadow-xl">
                <a href="/" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Kesiswaan' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Profil</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                <a href="/e/{{ $osis_slug }}" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === $osis_name ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">OSIS</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                <a href="/extracurricular" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Ekstrakurikuler' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Ekstrakurikuler</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                <a href="/student-event" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Agenda Siswa' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Agenda Siswa</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
              </div>
            </div>
          </div>
          
          <div class="flex flex-col gap-1 group group/dropside relative">
            <div class="flex gap-1 items-center text-sm {{ $title === 'Humas' || $title === 'Praktek Kerja Lapangan' || $title === 'Mitra DU/DI' || $title === 'Cerita Alumni' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">
              <p>Humas</p>
              <span class="icon-[mdi--chevron-right]"></span>
            </div>
            <div class="h-[1px] w-full bg-slate-200"></div>
            <div class="w-64 h-fit rounded-lg absolute left-20 -top-4 bg-transparent hidden group-hover/dropside:flex ps-12 py-4 transition-all">
              <div class="size-fit flex flex-col px-4 py-2 gap-2 rounded-lg bg-slate-50 shadow-xl">
                <a href="/" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Humas' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Profil</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                <a href="/internship" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Praktek Kerja Lapangan'  ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">PKL</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                <a href="/partner" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Mitra DU/DI' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Mitra DU/DI</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
                <a href="/alumni" wire:navigate class="flex flex-col gap-1 group/active">
                  <p class="text-sm whitespace-nowrap {{ $title === 'Cerita Alumni' ? 'text-blue-500' : 'text-slate-500' }} group-hover/active:text-blue-500">Cerita Alumni</p>
                  <div class="h-[1px] w-full bg-slate-200"></div>
                </a>
              </div>
            </div>
          </div>
          <a href="/" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Sarpras' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Sarpras</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'BK / BP' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">BK / BP</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Perpustakaan' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Perpustakaan</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Tata Usaha' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Tata Usaha</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
        </div>
        <!-- Dropdown -->
      </div>

      {{-- <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
        <div class="flex gap-1 items-center">
          <p class="text-slate-50">Kesiswaan</p>
          <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
        </div>
        <div class="w-full h-0.5 bg-transparent"></div>
        <!-- Dropdown -->
        <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all">
          <a href="/e/{{ $osis_slug }}" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'OSIS' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">OSIS</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/extracurricular" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Ekstrakurikuler' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Ekstrakurikuler</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/student-events" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Agenda Siswa' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Agenda Siswa</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
        </div>
        <!-- Dropdown -->
      </div> --}}


      {{-- <a href="/extracurricular" wire:navigate class="flex flex-col gap-1 px-2 group">
        <p class="text-slate-50">Ekstrakurikuler</p>
        <div class="w-full h-0.5 {{ $title === 'Ekstrakurikuler' ? 'bg-slate-50' : 'bg-transparent' }} group-hover:bg-slate-50 transition-all"></div>
      </a> --}}
      {{-- <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
        <div class="flex gap-1 items-center">
          <p class="text-slate-50">Kehumasan</p>
          <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
        </div>
        <div class="w-full h-0.5 bg-transparent"></div>
        <!-- Dropdown -->
        <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all">
          <a href="/internship" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Praktek Kerja Lapangan' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">PKL</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/partner" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Mitra DU/DI' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Mitra DU/DI</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/jobfair" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Bursa Kerja Khusus' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Bursa Kerja</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/alumni" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Cerita Alumni' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Cerita Alumni</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
        </div>
        <!-- Dropdown -->
      </div> --}}

      <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
        <div class="flex gap-1 items-center">
          <p class="text-slate-50 whitespace-nowrap">Program Sekolah</p>
          <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
        </div>
        <div class="w-full h-0.5 bg-transparent"></div>
        <!-- Dropdown -->
        <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all shadow-xl">
          <a href="/teaching-factory" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Teaching Factory' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Teaching Factory</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/business-unit" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'UPJ' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">UPJ</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/training" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Pelatihan' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Pelatihan</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
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
          <a href="/enrollment" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Informasi SPMB' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">SPMB</p>
            <div class="h-[1px] w-full bg-slate-200"></div>
          </a>
          <a href="/jobfair" wire:navigate class="flex flex-col gap-1 group">
            <p class="text-sm {{ $title === 'Bursa Kerja Khusus' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">BKK</p>
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
          @foreach($webLinks as $weblink)
            <a href="{{ $weblink->url }}" class="flex flex-col gap-1 group">
              <p class="text-sm text-slate-500 group-hover:text-blue-500">{{ $weblink->title }}</p>
              <div class="h-[1px] w-full bg-slate-200"></div>
            </a>
          @endforeach
        </div>
        <!-- Dropdown -->
      </div>
    </div>
    <!-- menu web -->

    <!-- btn menu -->
    <input type="checkbox" class="peer hidden" id="dropdown-menu"/>
    <label for="dropdown-menu" class="lg:hidden hidden peer-checked:block cursor-pointer">
      <span class="icon-[mdi--close] text-3xl text-slate-50"></span>
    </label>
    <label for="dropdown-menu" class="lg:hidden peer-checked:hidden cursor-pointer">
      <span class="icon-[mdi--hamburger-menu] text-3xl text-slate-50"></span>
    </label>
    <!-- btn menu -->

    <!-- menu mobile -->
    {{-- <div class="flex-col items-center lg:hidden w-full min-h-[calc(100dvh-64px)] bg-gradient-to-b from-blue-500/70 to-blue-700/90 absolute right-full peer-checked:translate-x-full top-16 px-4 py-4 gap-2 flex transition-all duration-700"> --}}
    <div class="flex-col items-center lg:hidden w-full min-h-[calc(100dvh-64px)] bg-gradient-to-b from-blue-500/70 to-blue-700/90 absolute right-full translate-x-full top-16 px-4 py-4 gap-2 flex transition-all duration-700">
      
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
          <a href="/staff" wire:navigate class="text-slate-50 whitespace-nowrap">Struktur Organisasi</a>
          <a href="/staff" wire:navigate class="text-slate-50 whitespace-nowrap">GTK</a>
          <a href="/achievement" wire:navigate class="text-slate-50 whitespace-nowrap">Prestasi</a>
          <a href="/facility" wire:navigate class="text-slate-50 whitespace-nowrap">Sarana Prasarana</a>
          <a href="/gallery" wire:navigate class="text-slate-50 whitespace-nowrap">Galeri</a>
        </div>
        <!-- dropdown -->
      </div>

      <a href="/major" wire:navigate class="font-medium text-slate-50 text-xl">Program Keahlian</a>

      {{-- <a href="/extracurricular" wire:navigate class="font-medium text-slate-50 text-xl">Ekstrakurikuler</a> --}}

      <div class="flex flex-col w-full">
        <input type="checkbox" class="peer hidden" id="unit-menu" />
        <label for="unit-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
          <p class="font-medium text-slate-50 text-xl whitespace-nowrap">Unit Kerja</p>
          <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
        </label>
        <!-- dropdown -->
        <div class="flex-col w-full gap-2 rounded-lg items-center hidden peer-checked:flex transition-all py-2" id="dropdownMenu">
          <div class="w-full flex flex-col">
            <input type="checkbox" class="peer hidden" id="kurikulum-menu" />
            <label for="kurikulum-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
              <p class="text-slate-50 text-lg whitespace-nowrap">Kurikulum</p>
              <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
            </label>
            <div class="w-full flex-col items-center hidden peer-checked:flex transition-all duration-500">
              <a href="/" wire:navigate class="text-slate-50 whitespace-nowrap">Profil</a>
              <a href="/" wire:navigate class="text-slate-50 whitespace-nowrap">Kalender Akademik</a>
              <a href="/" wire:navigate class="text-slate-50 whitespace-nowrap">Jadwal Pelajaran</a>
            </div>
          </div>
          <div class="w-full flex flex-col">
            <input type="checkbox" class="peer hidden" id="kesiswaan-menu" />
            <label for="kesiswaan-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
              <p class="text-slate-50 text-lg whitespace-nowrap">Kesiswaan</p>
              <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
            </label>
            <div class="w-full flex-col items-center hidden peer-checked:flex transition-all duration-500">
              <a href="/" wire:navigate class="text-slate-50 whitespace-nowrap">Profil</a>
              <a href="/e/{{ $osis_slug }}" wire:navigate class="text-slate-50 whitespace-nowrap">OSIS</a>
              <a href="/extracurricular" wire:navigate class="text-slate-50 whitespace-nowrap">Ekstrakurikuler</a>
              <a href="/student-events" wire:navigate class="text-slate-50 whitespace-nowrap">Agenda Siswa</a>
            </div>
          </div>
          <div class="w-full flex flex-col">
            <input type="checkbox" class="peer hidden" id="humas-menu" />
            <label for="humas-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
              <p class="text-slate-50 text-lg whitespace-nowrap">Humas</p>
              <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
            </label>
            <div class="w-full flex-col items-center hidden peer-checked:flex transition-all duration-500">
              <a href="/" wire:navigate class="text-slate-50 whitespace-nowrap">Profil</a>
              <a href="/internship" wire:navigate class="text-slate-50 whitespace-nowrap">PKL</a>
              <a href="/partner" wire:navigate class="text-slate-50 whitespace-nowrap">Mitra DU/DI</a>
              <a href="/alumni" wire:navigate class="text-slate-50 whitespace-nowrap">Cerita Alumni</a>
            </div>
          </div>
          <a href="/" wire:navigate class="text-slate-50 text-lg whitespace-nowrap">Sarpras</a>
          <a href="/" wire:navigate class="text-slate-50 text-lg whitespace-nowrap">BK / BP</a>
          <a href="/" wire:navigate class="text-slate-50 text-lg whitespace-nowrap">Perpustakaan</a>
          <a href="/" wire:navigate class="text-slate-50 text-lg whitespace-nowrap">Tata Usaha</a>
        </div>
        <!-- dropdown -->
      </div>

      {{-- <div class="flex flex-col w-full">
        <input type="checkbox" class="peer hidden" id="kesiswaan-menu" />
        <label for="kesiswaan-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
          <p class="font-medium text-slate-50 text-xl whitespace-nowrap">Kesiswaan</p>
          <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
        </label>
        <!-- dropdown -->
        <div class="flex-col w-full gap-2 rounded-lg items-center hidden peer-checked:flex transition-all py-2" id="dropdownMenu">
          <a href="/e/{{ $osis_slug }}" wire:navigate class="text-slate-50 whitespace-nowrap">OSIS</a>
          <a href="/extracurricular" wire:navigate class="text-slate-50 whitespace-nowrap">Ekstrakurikuler</a>
          <a href="/student-events" wire:navigate class="text-slate-50 whitespace-nowrap">Agenda Siswa</a>
        </div>
        <!-- dropdown -->
      </div> --}}

      {{-- <div class="flex flex-col w-full">
        <input type="checkbox" class="peer hidden" id="kehumasan-menu" />
        <label for="kehumasan-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
          <p class="font-medium text-slate-50 text-xl whitespace-nowrap">Kehumasan</p>
          <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
        </label>
        <!-- dropdown -->
        <div class="flex-col w-full gap-2 rounded-lg items-center hidden peer-checked:flex transition-all py-2" id="dropdownMenu">
          <a href="/internship" wire:navigate class="text-slate-50 whitespace-nowrap">PKL</a>
          <a href="/partner" wire:navigate class="text-slate-50 whitespace-nowrap">Mitra DU/DI</a>
          <a href="/alumni" wire:navigate class="text-slate-50 whitespace-nowrap">Cerita Alumni</a>
        </div>
        <!-- dropdown -->
      </div> --}}

      <div class="flex flex-col w-full">
        <input type="checkbox" class="peer hidden" id="program-sekolah-menu" />
        <label for="program-sekolah-menu" class="flex gap-1 items-center justify-center" id="dropdownBtn">
          <p class="font-medium text-slate-50 text-xl whitespace-nowrap">Program Sekolah</p>
          <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
        </label>

        <!-- dropdown -->
        <div class="flex-col w-full gap-2 rounded-lg items-center hidden peer-checked:flex transition-all py-2" id="dropdownMenu">
          <a href="/teaching-factory" wire:navigate class="text-slate-50 whitespace-nowrap">Teaching Factory</a>
          <a href="/business-unit" wire:navigate class="text-slate-50 whitespace-nowrap">UPJ</a>
          <a href="/training" wire:navigate class="text-slate-50 whitespace-nowrap">Pelatihan</a>
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
          <a href="/enrollment" wire:navigate class="text-slate-50 whitespace-nowrap">SPMB</a>
          <a href="/jobfair" wire:navigate class="text-slate-50 whitespace-nowrap">BKK</a>
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
          @foreach($webLinks as $weblink)
            <a href="{{ $weblink->url }}" class="text-slate-50 whitespace-nowrap">{{ $weblink->title }}</a>
          @endforeach
        </div>
        <!-- dropdown -->
      </div>
    </div>
    <!-- menu mobile -->
  </nav>
  </header>