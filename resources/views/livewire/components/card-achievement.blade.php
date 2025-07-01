<a href="/achievement/{{ $slug }}" wire:navigate class="w-full group">
    <article class="flex w-full lg:flex-col rounded-2xl gap-2 bg-white lg:group-hover:scale-105 duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="w-1/3 aspect-square lg:aspect-[4/3] lg:w-full rounded-s-2xl lg:rounded-b-none lg:rounded-t-2xl bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-2/3 lg:w-full flex flex-col gap-1 py-2 pr-2 lg:px-2 lg:pb-2 lg:items-center justify-between">
            <div class="flex w-fit bg-blue-600 px-2 lg:px-4 lg:pb- rounded">
                <p class="text-slate-50 text-xs lg:text-base">{{ $rankings }}</p>
            </div>
            <h4 class="text-sm lg:text-xl text-slate-700 lg:text-center h-[3lh] line-clamp-3 ">{{ $title }}</h4>
            <div class="flex gap-2 items-center">
                <span class="icon-[mdi--calendar-badge] text-xs lg:text-sm text-slate-600"></span>
                <p class="text-xs lg:text-sm text-slate-600">{{ \Carbon\Carbon::parse($created_at)->translatedFormat('j F Y') }}</p>
            </div>
        </figcaption>
    </article>
</a>