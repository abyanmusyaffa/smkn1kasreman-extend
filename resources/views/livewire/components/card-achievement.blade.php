<a href="/achievement/{{ $slug }}" wire:navigate class="w-full group">
    <article class="flex w-full lg:flex-col border-2 lg:border-4 border-blue-100 rounded-2xl gap-2 bg-white lg:group-hover:scale-105 lg:group-hover:shadow-xl duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="w-1/3 aspect-[4/3] lg:w-full rounded-s-2xl lg:rounded-b-none lg:rounded-t-2xl bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-2/3 lg:w-full flex flex-col gap-1 py-1 pr-1 lg:px-2 lg:pb-2 lg:items-center">
            <div class="flex w-fit bg-blue-100 px-2 lg:px-4 rounded items-center gap-1">
                <span class="icon-[mingcute--medal-fill] text-xs lg:text-sm text-blue-800"></span>
                <p class="text-blue-800 text-xs lg:text-base">{{ $rankings }}</p>
            </div>
            <h4 class="text-sm lg:text-xl text-slate-700 lg:text-center h-[2lh] lg:h-[3lh] line-clamp-2 lg:line-clamp-3">{{ $title }}</h4>
        </figcaption>
    </article>
</a>