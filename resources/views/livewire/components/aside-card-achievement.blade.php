<a href="/achievement/{{ $slug }}" wire:navigate class="w-full group">
    <article class="flex w-full border-2 border-blue-100 rounded-2xl gap-2 bg-white group-hover:scale-[1.02] group-hover:shadow-xl duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="min-w-[33.3333%] aspect-[4/3] rounded-s-2xl bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-2/3 flex flex-col gap-1 py-1 pr-1">
            <div class="flex w-fit bg-blue-100 px-2 rounded items-center gap-1">
                <span class="icon-[mingcute--medal-fill] text-xs text-blue-800"></span>
                <p class="text-blue-800 text-xs">{{ $rankings }}</p>
            </div>
            <h4 class="text-slate-700 text-sm lg:text-base h-[2lh] line-clamp-2 ">{{ $title }}</h4>
        </figcaption>
    </article>
</a>