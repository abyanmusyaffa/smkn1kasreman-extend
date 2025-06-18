<a href="/{{ $category }}/{{ $slug }}" wire:navigate class="w-full group">
    <article class="flex w-full rounded-2xl gap-2 bg-white duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="w-1/3 aspect-square rounded-s-2xl bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-2/3 flex flex-col justify-between gap-1 items-start relative py-2">
          <h4 class="text-sm font-medium text-slate-700 line-clamp-3">{{ $title }}</h4>
          <div class="flex {{ $category == 'news' ? 'bg-blue-600' : ( $category == 'announcement' ? 'bg-lime-600' : 'bg-purple-900') }} px-2 py-0.5 rounded gap-1">
            <p class="font-semibold text-slate-50 text-xs">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('j') }}</p>
            <p class="text-slate-50 text-xs">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('F') }}</p>
            <p class="text-slate-50 text-xs">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('Y') }}</p>
          </div>
        </figcaption>
    </article>
</a>