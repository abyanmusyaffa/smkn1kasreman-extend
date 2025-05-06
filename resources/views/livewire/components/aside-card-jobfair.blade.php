<a href="/jobfair/{{ $slug }}" wire:navigate class="w-full group">
    <article class="flex w-full rounded-2xl gap-2 bg-white duration-500 transition-all">
        <figure style="background-image: url(/storage/{{ $photo }});" class="w-1/3 aspect-square rounded-s-2xl bg-cover bg-no-repeat bg-center"></figure>
        <figcaption class="w-2/3 flex flex-col gap-2 py-2 pr-2 justify-between">
            <h4 class="text-sm font-medium text-slate-700 line-clamp-3">{{ $title }}</h4>
            <div class="flex gap-1 items-center">
                <span class=" {{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'icon-[mdi--close-circle-outline] text-red-800' : 'icon-[mdi--clock-outline] text-blue-800' }} "></span>
                <p class="text-sm {{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'text-red-800' : 'text-blue-800' }}">{{ \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($deadline)) ? 'Lowongan Ditutup' : \Carbon\Carbon::parse($deadline)->diffForHumans() }}</p>
            </div>
        </figcaption>
    </article>
</a>