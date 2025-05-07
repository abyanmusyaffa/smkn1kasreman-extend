<header>
    <nav class="w-full flex justify-between bg-gradient-to-r from-blue-500 to-blue-600 h-16 lg:h-24 px-4 lg:px-16 2xl:px-36 items-center fixed z-10">
      <!-- logo -->
      <a href="/" wire:navigate class="flex gap-2 2xl:gap-4 items-center">
        <img src="/storage/{{ $school->logo }}" class="w-9 lg:w-12 2xl:w-16" alt="logo-skanka" />
        <p class="font-medium text-slate-50 lg:text-lg 2xl:text-2xl">SMK N {{ $school->name }}</p>
      </a>
      <!-- logo -->

      <!-- menu web -->
      <div class="hidden lg:flex lg:gap-1 2xl:gap-4 items-center">
        <a href="/" wire:navigate class="flex flex-col gap-1 px-2 group">
          <p class="text-slate-50">Beranda</p>
          <div class="w-full h-0.5 {{ $title === 'Beranda' ? 'bg-slate-50' : 'bg-transparent' }} group-hover:bg-slate-50 transition-all" ... wire:current="bg-slate-50"></div>
        </a>
        <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
          <div class="flex gap-1 items-center">
            <p class="text-slate-50">{{ $school->alias }} Kita</p>
            <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
          </div>
          <div class="w-full h-0.5 bg-transparent"></div>
          <!-- Dropdown -->
          <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all">
            <a href="/about" wire:navigate class="flex flex-col gap-1 group">
              <p class="text-sm {{ $title === 'Tentang Sekolah' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500 whitespace-nowrap">Tentang Sekolah</p>
              <div class="h-[1px] w-full bg-slate-200"></div>
            </a>
            <a href="/staff" wire:navigate class="flex flex-col gap-1 group">
              <p class="text-sm {{ $title === 'GTK' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">GTK</p>
              <div class="h-[1px] w-full bg-slate-200"></div>
            </a>
            <a href="/achievement" wire:navigate class="flex flex-col gap-1 group">
              <p class="text-sm {{ $title === 'Prestasi' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Prestasi</p>
              <div class="h-[1px] w-full bg-slate-200"></div>
            </a>
            <a href="/partner" wire:navigate class="flex flex-col gap-1 group">
              <p class="text-sm {{ $title === 'Mitra DU/DI' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Mitra DU/DI</p>
              <div class="h-[1px] w-full bg-slate-200"></div>
            </a>
            <a href="/alumni" wire:navigate class="flex flex-col gap-1 group">
              <p class="text-sm {{ $title === 'Cerita Alumni' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Cerita Alumni</p>
              <div class="h-[1px] w-full bg-slate-200"></div>
            </a>
            <a href="/download" wire:navigate class="flex flex-col gap-1 group">
              <p class="text-sm {{ $title === 'Download Area' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Download Area</p>
              <div class="h-[1px] w-full bg-slate-200"></div>
            </a>
          </div>
          <!-- Dropdown -->
        </div>
        <a href="/major" wire:navigate class="flex flex-col gap-1 px-2 group">
          <p class="text-slate-50">Konsentrasi Keahlian</p>
          <div class="w-full h-0.5 {{ $title === 'Konsentrasi Keahlian' ? 'bg-slate-50' : 'bg-transparent' }} group-hover:bg-slate-50 transition-all"></div>
        </a>
        <a href="/extracurricular" wire:navigate class="flex flex-col gap-1 px-2 group">
          <p class="text-slate-50">Ekstrakurikuler</p>
          <div class="w-full h-0.5 {{ $title === 'Ekstrakurikuler' ? 'bg-slate-50' : 'bg-transparent' }} group-hover:bg-slate-50 transition-all"></div>
        </a>
        <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
          <div class="flex gap-1 items-center">
            <p class="text-slate-50">Informasi</p>
            <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
          </div>
          <div class="w-full h-0.5 bg-transparent"></div>
          <!-- Dropdown -->
          <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all">
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
              <p class="text-sm {{ $title === 'Bursa Kerja Khusus' ? 'text-blue-500' : 'text-slate-500' }} group-hover:text-blue-500">Bursa Kerja</p>
              <div class="h-[1px] w-full bg-slate-200"></div>
            </a>
          </div>
          <!-- Dropdown -->
        </div>
        <div class="flex flex-col gap-1 px-2 relative cursor-pointer group/dropdown">
          <div class="flex gap-1 items-center">
            <p class="text-slate-50">Web Link</p>
            <span class="icon-[mdi--chevron-down] text-2xl text-slate-50"></span>
          </div>
          <div class="w-full h-0.5 bg-transparent"></div>
          <!-- Dropdown -->
          <div class="flex-col px-4 py-2 gap-2 bg-slate-50 rounded-lg min-w-32 absolute top-[28px] hidden group-hover/dropdown:flex transition-all">
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
      <div class="flex-col items-center lg:hidden w-full min-h-[calc(100dvh-64px)] bg-gradient-to-b from-blue-500/70 to-blue-600/90 absolute right-full peer-checked:translate-x-full top-16 px-4 py-4 gap-2 flex transition-all duration-700 ">
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
            <a href="/staff" wire:navigate class="text-slate-50 whitespace-nowrap">GTK</a>
            <a href="/achievement" wire:navigate class="text-slate-50 whitespace-nowrap">Prestasi</a>
            <a href="/partner" wire:navigate class="text-slate-50 whitespace-nowrap">Mitra DU/DI</a>
            <a href="/alumni" wire:navigate class="text-slate-50 whitespace-nowrap">Cerita Alumni</a>
            <a href="/download" wire:navigate class="text-slate-50 whitespace-nowrap">Download Area</a>
          </div>
          <!-- dropdown -->
        </div>
        <a href="/major" wire:navigate class="font-medium text-slate-50 text-xl">Konsentrasi Keahlian</a>
        <a href="/extracurricular" wire:navigate class="font-medium text-slate-50 text-xl">Ekstrakurikuler</a>
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
            <a href="/jobfair" wire:navigate class="text-slate-50 whitespace-nowrap">Bursa Kerja</a>
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