<a href="/jobfair/{{ $slug }}" wire:navigate class="w-full group">
    <article class="flex w-full lg:flex-col rounded-2xl gap-2 bg-white lg:group-hover:scale-105 duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="w-1/3 aspect-square lg:aspect-[4/3] lg:w-full rounded-s-2xl lg:rounded-b-none lg:rounded-t-2xl bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-2/3 lg:w-full flex flex-col gap-2 py-2 pr-2 lg:px-2 lg:pb-2 lg:items-center justify-between">
            <h4 class="text-sm lg:text-xl text-slate-700 lg:text-center h-[3lh] line-clamp-3 ">{{ $title }}</h4>
            <div class="flex gap-1 items-center">
                <span class=" {{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'icon-[mdi--close-circle-outline] text-red-800' : 'icon-[mdi--clock-outline] text-blue-800' }} text-sm lg:text-base"></span>
                <p class="text-xs lg:text-sm {{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'text-red-800' : 'text-blue-800' }}">{{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'Lowongan Ditutup' : \Carbon\Carbon::parse($deadline)->diffForHumans() }}</p>
            </div>
        </figcaption>
    </article>
</a>