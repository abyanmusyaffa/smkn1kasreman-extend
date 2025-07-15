<div class="w-full flex bg-white h-fit rounded-3xl gap-4 hover:shadow-xl hover:scale-[1.02] transition-all duration-300 cursor-pointer">
    <figure data-fancybox data-src="/storage/{{ $photo }}" class="w-24 lg:w-32 shrink-0 aspect-[3/4] shadow-[16px_0px_16px_-8px_rgba(0,_0,_0,_0.35)] rounded-3xl bg-no-repeat bg-cover bg-center" style="background-image: url(/storage/{{ $photo }})"></figure>
    <figcaption wire:click="dispatch('open', { description: '{{ $description }}',  name: '{{ $name }}' })" class="flex flex-col w-full gap-1 p-1 justify-between">
        <div class="flex flex-col w-full">
            <div class="flex items-center text-xs lg:text-base gap-1 text-blue-800">
                <span class="icon-[mdi--calendar]"></span>
                <p class="font-medium">{{ \Carbon\Carbon::parse($start_date)->translatedFormat('j M ') }}{{ $end_date ? '- ' . \Carbon\Carbon::parse($end_date)->translatedFormat('j M Y') :  \Carbon\Carbon::parse($start_date)->translatedFormat('Y') }}</p>
            </div>
            <h3 class="text-slate-700 lg:text-xl font-medium max-h-[3lh] line-clamp-3">{{ $name }}</h3>
        </div>
        <div class="flex-col w-full">
            <div class="flex w-full text-xs lg:text-base gap-1 italic text-slate-500 items-center">
                <span class="icon-[mdi--location] shrink-0"></span>
                <p class="h-[1lh] line-clamp-1">{{ $location }}</p>
            </div>
            <div class="flex w-full text-xs lg:text-base gap-1 italic text-slate-500 items-center">
                <span class="icon-[mdi--clock] shrink-0"></span>
                <p>{{ \Carbon\Carbon::parse($start_time)->translatedFormat('H:i') }} - {{ $end_time ? \Carbon\Carbon::parse($end_time)->translatedFormat('H:i') : 'selesai' }}</p>
            </div>
        </div>
    </figcaption>  
</div>