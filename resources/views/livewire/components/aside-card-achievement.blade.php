<a href="/achievement/{{ $slug }}" wire:navigate class="w-full group">
    <article class="flex w-full rounded-2xl gap-2 bg-white duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="w-1/3 aspect-square rounded-s-2xl bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-2/3 flex flex-col gap-1 py-2 pr-2 ">
            <div class="flex w-fit bg-blue-600 px-2 rounded">
                <p class="text-slate-50 text-xs ">{{ $rankings }}</p>
            </div>
            <h4 class="text-sm font-medium text-slate-700 h-[3lh] line-clamp-3 ">{{ $title }}</h4>
            <div class="flex gap-2 items-center mt-auto">
                <span class="icon-[mdi--calendar-badge] text-xs text-slate-600"></span>
                <p class="text-xs text-slate-600">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('j F Y') }}</p>
            </div>
        </figcaption>
    </article>
</a>