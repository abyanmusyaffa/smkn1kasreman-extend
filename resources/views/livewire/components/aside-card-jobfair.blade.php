<a href="/jobfair/{{ $slug }}" wire:navigate class="w-full group">
    <article class="flex w-full border-2 border-blue-100 rounded-2xl gap-2 bg-white group-hover:scale-[1.02] group-hover:shadow-lg duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="min-w-[33.33333%] aspect-square rounded-s-2xl bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-2/3 flex flex-col gap-2 py-1 pr-1 justify-between">
            <h4 class="text-sm lg:text-base text-slate-700 h-[3lh] line-clamp-3 ">{{ $title }}</h4>
            <div class="flex w-fit px-1 py-0.5 rounded items-center gap-1 {{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'bg-red-100' : 'bg-blue-100' }}">
                <span class=" {{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'icon-[mdi--close-circle-outline] text-red-800' : 'icon-[mdi--clock-outline] text-blue-800' }} text-sm"></span>
                <p class="text-xs {{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'text-red-800' : 'text-blue-800' }}">{{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'Lowongan Ditutup' : \Carbon\Carbon::parse($deadline)->diffForHumans() }}</p>
            </div>
        </figcaption>
    </article>
</a>