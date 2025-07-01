<a href="/{{ $category }}/{{ $slug }}" wire:navigate class="f-carousel__slide !flex !flex-col !items-center">
  <article class="flex flex-col rounded-2xl border-2 lg:border-4 border-blue-600 w-full lg:w-[96%] p-2 lg:p-4 gap-2 lg:gap-4">
    <figure style="background-image: url(/storage/{{ $photo }});" class="aspect-[4/3] w-full rounded-xl bg-cover bg-no-repeat bg-center"></figure>
    <figcaption class="w-full flex flex-col gap-2 lg:gap-4 items-center">
      {{-- <div class="flex flex-col {{ $category == 'news' ? 'bg-blue-600' : ( $category == 'announcement' ? 'bg-lime-600' : 'bg-purple-900') }} px-2 py-1 rounded-lg absolute -top-24 left-4">
        <p class="font-semibold text-slate-50 text-4xl">{{ \Carbon\Carbon::parse($created_at)->translatedFormat('j') }}</p>
        <p class="text-slate-50 text-sm">{{ \Carbon\Carbon::parse($created_at)->translatedFormat('F') }}</p>
        <p class="text-slate-50 text-sm">{{ \Carbon\Carbon::parse($created_at)->translatedFormat('Y') }}</p>
      </div> --}}
      <h4 class="text-sm lg:text-xl text-slate-700 text-center h-[3lh] line-clamp-3">{{ $title }}</h4>
      <div class="flex gap-2 items-center">
        <span class="icon-[mdi--calendar-badge] text-xs lg:text-sm text-blue-600"></span>
        <p class="text-xs lg:text-sm text-blue-600">{{ \Carbon\Carbon::parse($created_at)->translatedFormat('j F Y H:i') }}</p>
      </div>
    </figcaption>
  </article>
</a>
{{-- <a href="/{{ $category }}/{{ $slug }}" wire:navigate class="min-w-[100%] max-w-[100%] lg:w-full group f-carousel__slide">
    <article class="flex w-full flex-col rounded-2xl pb-4 gap-12 bg-white lg:group-hover:scale-105 duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="aspect-[4/3] w-full rounded-t-2xl bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-full flex flex-col gap-1 lg:gap-2 items-center relative px-4">
          <div class="flex flex-col {{ $category == 'news' ? 'bg-blue-600' : ( $category == 'announcement' ? 'bg-lime-600' : 'bg-purple-900') }} px-2 py-1 rounded-lg absolute -top-24 left-4">
            <p class="font-semibold text-slate-50 text-4xl">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('j') }}</p>
            <p class="text-slate-50 text-sm">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('F') }}</p>
            <p class="text-slate-50 text-sm">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('Y') }}</p>
          </div>
          <h4 class="text-lg lg:text-xl text-slate-700 text-center h-[4lh] line-clamp-4">{{ $title }}</h4>
        </figcaption>
    </article>
</a> --}}