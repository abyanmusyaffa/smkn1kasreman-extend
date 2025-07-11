<a href="/{{ $category }}/{{ $slug }}" wire:navigate class="w-full group">
  <article class="flex w-full border-2 border-blue-100 rounded-2xl gap-2 bg-white group-hover:scale-[1.02] group-hover:shadow-lg duration-500 transition-all">
    <figure style="background-image: url(/storage/{{ $photo }});" class="min-w-[33.3333%] aspect-[4/3] rounded-s-2xl bg-cover bg-no-repeat bg-center"></figure>
    <figcaption class="w-2/3 flex flex-col gap-1 py-1 pr-1 justify-between">
      <h4 class="text-sm lg:text-base text-slate-700 h-[2lh] line-clamp-2">{{ $title }}</h4>
      <div class="flex w-fit {{ $category === 'news' ? 'bg-green-100 text-green-800' : ( $category === 'announcement' ? 'bg-purple-100 text-purple-800' : 'bg-rose-100 text-rose-800' ) }} px-2 py-0.5 rounded items-center gap-1">
          <span class="icon-[mdi--calendar-badge] text-xs"></span>
          <p class="text-xs">{{ \Carbon\Carbon::parse($created_at)->translatedFormat('j F Y H:i') }}</p>
      </div>
    </figcaption>
  </article>
</a>