<div class="flex flex-col lg:flex-row-reverse justify-between lg:items-center w-full rounded-2xl gap-4 p-4 lg:px-24 lg:py-6 bg-white">
    <figure style="background-image: url(/storage/{{ $photo }});" class="bg-no-repeat bg-cover bg-center w-full lg:w-1/3 aspect-square rounded-2xl"></figure>
    <figcaption class="flex flex-col gap-11 lg:gap-16 w-full lg:w-1/2">
        <div class="flex flex-col gap-1 lg:gap-2">
            <div class="flex gap-2 items-center">
                <span class="icon-[mdi--calendar-badge] text-sm lg:text-lg text-slate-600"></span>
                <p class="text-sm lg:text-lg text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('j F Y') }}</p>
            </div>
            <h2 class="text-2xl lg:text-4xl font-medium text-slate-800 line-clamp-3">{{ $title }}</h2>
            <p class="text-sm lg:text-base text-slate-700 line-clamp-5 lg:line-clamp-3">{{ $summary }}</p>
        </div>
        <livewire:components.more-button text="Selengkapnya" :href="url('/announcement/' . $slug)"  />
    </figcaption>
</div>