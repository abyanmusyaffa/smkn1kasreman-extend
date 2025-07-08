<a href="/{{ $category }}/{{ $slug }}" wire:navigate class="w-full group">
    {{-- <article class="flex w-full lg:flex-col rounded-2xl lg:pb-4 gap-2 lg:gap-12 bg-white lg:group-hover:scale-105 duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="lg:aspect-[4/3] lg:w-full w-1/3 aspect-square rounded-s-2xl lg:rounded-tr-2xl lg:rounded-bl-none bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-2/3 lg:w-full flex flex-col justify-between gap-1 lg:gap-2 items-start relative lg:px-4 py-2 lg:py-0">
          <h4 class="text-sm lg:text-xl text-slate-700 lg:text-center lg:h-[4lh] line-clamp-3 lg:line-clamp-4">{{ $title }}</h4>
          <div class="flex lg:flex-col {{ $category == 'news' ? 'bg-blue-600' : ( $category == 'announcement' ? 'bg-lime-600' : 'bg-purple-900') }} px-2 py-0.5 lg:py-1 rounded lg:rounded-lg lg:absolute -top-24 left-4 gap-1 lg:gap-0">
            <p class="font-semibold text-slate-50 text-xs lg:text-4xl">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('j') }}</p>
            <p class="text-slate-50 text-xs lg:text-sm">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('F') }}</p>
            <p class="text-slate-50 text-xs lg:text-sm">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('Y') }}</p>
          </div>
        </figcaption>
    </article> --}}
    <article class="flex w-full lg:flex-col border-2 lg:border-4 border-blue-100 rounded-2xl gap-2 bg-white lg:group-hover:scale-105 lg:group-hover:shadow-xl duration-500 transition-all">
      <figure style="background-image: url(/storage/{{ $photo }});" class="w-1/3 aspect-[4/3] lg:w-full rounded-s-2xl lg:rounded-b-none lg:rounded-t-2xl bg-cover bg-no-repeat bg-center"></figure>
      <figcaption class="w-2/3 lg:w-full flex flex-col gap-1 py-1 pr-1 lg:px-2 lg:pb-2 lg:items-center justify-between">
        <h4 class="text-sm lg:text-xl text-slate-700 lg:text-center h-[2lh] lg:h-[3lh] line-clamp-2 lg:line-clamp-3">{{ $title }}</h4>
        <div class="flex w-fit {{ $category === 'news' ? 'bg-green-100 text-green-800' : ( $category === 'announcement' ? 'bg-purple-100 text-purple-800' : 'bg-rose-100 text-rose-800' ) }} px-2 lg:px-4 rounded items-center gap-1">
            <span class="icon-[mdi--calendar-badge] text-xs lg:text-sm"></span>
            <p class="text-xs lg:text-base">{{ \Carbon\Carbon::parse($created_at)->translatedFormat('j F Y H:i') }}</p>
        </div>
      </figcaption>
    </article>
</a>