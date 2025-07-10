<div class="flex flex-col lg:flex-row-reverse justify-between items-center w-full rounded-2xl gap-4 p-4 lg:px-24 lg:py-6 bg-white">
    <figure style="background-image: url(/storage/{{ $photo }});" class="bg-no-repeat bg-cover bg-center w-full lg:w-1/3 aspect-[4/3] h-auto rounded-2xl"></figure>
    <figcaption class="flex flex-col gap-4 w-full lg:w-1/2 items-center lg:items-start h-full lg:justify-between">
        <div class="flex flex-col gap-1 lg:gap-2 items-center lg:items-start">
            <div class="flex w-fit px-2 py-1 lg:px-4 rounded items-center gap-1 lg:gap-2 {{ $category === 'announcement' ? 'bg-purple-100 text-purple-800' : 'bg-rose-100 text-rose-800' }}">
                <span class="icon-[mdi--calendar-badge] text-sm lg:text-lg"></span>
                <p class="text-sm lg:text-lg whitespace-nowrap">{{ \Carbon\Carbon::parse($created_at)->translatedFormat('j F Y H:i') }}</p>
            </div>
            <h2 class="text-lg font-medium text-slate-700 lg:text-xl xl:text-2xl text-center lg:text-start h-fit max-h-[3lh] line-clamp-3 lg:max-h-[2lh] lg:line-clamp-2 xl:max-h-[3lh] xl:line-clamp-3">{{ $title }}</h2>
            <p class="text-sm lg:text-base text-center lg:text-start text-slate-700 h-[3lh] line-clamp-3 lg:h-[2lh] lg:line-clamp-2 xl:h-[3lh] xl:line-clamp-3">{{ $summary }}</p>
        </div>
        <livewire:components.more-button text="Selengkapnya" :href=" $category === 'announcement' ? 'announcement/' . $slug : 'enrollment/' . $slug "  />
    </figcaption>
</div>