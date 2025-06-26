<footer>
    <div class="grid lg:grid-cols-3 gap-6 w-full bg-gradient-to-r from-blue-500 to-blue-600 py-4 lg:py-6 px-4 lg:px-16 2xl:px-36">
      <!-- address -->
      <div class="flex flex-col w-full gap-4 lg:gap-6">
        <figure class="flex gap-4 *:h-14 lg:*:h-24">
          <img src="/storage/{{ $school->logo }}" alt="">
          <img src="/img/png/logo-provinsi-jawa-timur.png" alt="">
          <img src="/img/png/tut.png" alt="">
        </figure>
        <figcaption class="flex flex-col gap-1 lg:gap-2">
          <h2 class="font-medium text-xl lg:text-3xl text-slate-50">SMK Negeri {{ $school->name }}</h2>
          <p class="text-xs lg:text-xl text-slate-50">{{ $school->address }}</p>
        </figcaption>
        <div class="flex gap-2 lg:gap-4">
          @if( $school->url_instagram )
          <a href="{{ $school->url_instagram }}" target="_blank" class="size-6 lg:size-9 bg-slate-50 rounded-full grid place-items-center">
            <span class="icon-[mdi--instagram] lg:text-2xl text-blue-500"></span>
          </a>
          @endif
          @if( $school->url_facebook )
          <a href="{{ $school->url_facebook }}"  target="_blank"class="size-6 lg:size-9 bg-slate-50 rounded-full grid place-items-center">
            <span class="icon-[mdi--facebook] lg:text-2xl text-blue-500"></span>
          </a>
          @endif
          @if( $school->url_youtube )
          <a href="{{ $school->url_youtube }}" target="_blank" class="size-6 lg:size-9 bg-slate-50 rounded-full grid place-items-center">
            <span class="icon-[mdi--youtube] lg:text-2xl text-blue-500"></span>
          </a>
          @endif
          @if( $school->url_tiktok )
          <a href="{{ $school->url_tiktok }}" target="_blank" class="size-6 lg:size-9 bg-slate-50 rounded-full grid place-items-center">
            <span class="icon-[ic--baseline-tiktok] lg:text-2xl text-blue-500"></span>
          </a>
          @endif
        </div>
      </div>
      <!-- address -->

      <!-- contact -->
      <div class="flex flex-col w-full gap-2 lg:gap-4 lg:pl-[15%]">
        <h2 class="font-medium text-xl lg:text-3xl text-slate-50">Kontak</h2>
        <div class="flex flex-col w-full gap-1 lg:gap-2">
          <div class="flex w-full gap-2 items-center">
            <span class="icon-[mdi--telephone] text-slate-50 lg:text-2xl"></span>
            <p class="text-xs lg:text-xl text-slate-50">{{ $school->phone }}</p>
          </div>
          <div class="flex w-full gap-2 items-center">
            <span class="icon-[mdi--email] text-slate-50 lg:text-2xl"></span>
            <p class="text-xs lg:text-xl text-slate-50">{{ $school->email }}</p>
          </div>
          <iframe class="w-full h-36 lg:h-44 rounded-lg outline outline-blue-300" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7912.894690152071!2d111.49912496810691!3d-7.41564087171856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79c2b58c63a561%3A0xdb8cd4f5f83ff1a5!2sSMK%20NEGERI%201%20KASREMAN!5e0!3m2!1sen!2sid!4v1750687936965!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
      <!-- contact -->

      <!-- menu -->
      <div class="flex flex-col w-full gap-2 lg:gap-4 lg:pl-[35%]">
        <h2 class="font-medium text-xl lg:text-3xl text-slate-50">Menu Utama</h2>
        <div class="lg:flex lg:flex-col grid grid-cols-2 w-full gap-1 lg:gap-2">
          <a href="/about" wire:navigate class="text-xs lg:text-xl text-slate-50">Tentang Sekolah</a>
          <a href="/major" wire:navigate class="text-xs lg:text-xl text-slate-50">Program Keahlian</a>
          <a href="/extracurricular" wire:navigate class="text-xs lg:text-xl text-slate-50">Ekstrakurikuler</a>
          <a href="/news" wire:navigate class="text-xs lg:text-xl text-slate-50">Berita</a>
          <a href="/achievement" wire:navigate class="text-xs lg:text-xl text-slate-50">Prestasi</a>
          <a href="/enrollment" wire:navigate class="text-xs lg:text-xl text-slate-50">SPMB</a>
        </div>
      </div>
      <!-- menu -->

    </div>
    <div class="grid place-items-center w-full h-8 lg:h-12 bg-blue-700">
      <p class="text-slate-50 text-xs lg:text-lg">© 2025 IT SMKN {{ $school->name }}</p>
    </div>
  </footer>