<div class="bg-white flex flex-col rounded-2xl overflow-x-hidden shadow-xl hover:scale-[1.02] transition-all duration-300">
    <figure data-fancybox data-src="/storage/{{ $photo }}" class="bg-no-repeat bg-cover bg-center w-full aspect-video" style="background-image: url('/storage/{{ $photo }}')"></figure>
    <figcaption class="w-full flex flex-col p-4 gap-2">
        <div class="flex items-center text-sm gap-1 text-blue-800 w-full">
            <span class="icon-[mdi--calendar]"></span>
            <p class="font-medium">{{ \Carbon\Carbon::parse($start_date)->translatedFormat('j M') }}{{ $end_date ? ' - ' . \Carbon\Carbon::parse($end_date)->translatedFormat('j M Y') : ' ' . \Carbon\Carbon::parse($start_date)->translatedFormat('Y') }} / {{ \Carbon\Carbon::parse($start_time)->translatedFormat('H:i') }} - {{ $end_time ? \Carbon\Carbon::parse($end_time)->translatedFormat('H:i') : 'selesai' }}</p>
        </div>
        <h3 class="text-lg leading-5 font-medium text-slate-700  h-[3lh] line-clamp-3">{{ $name }}</h3>
        <div class="flex flex-col w-full">
            <div class="flex gap-2 items-center text-sm text-slate-700">
                <span class="icon-[mdi--handshake] shrink-0"></span>
                <p class="h-[1lh] line-clamp-1">{{ $organizer }}</p>
            </div>
            <div class="flex gap-2 items-center text-sm text-slate-700">
                <span class="icon-[mdi--user-supervisor] shrink-0"></span>
                <p class="h-[1lh] line-clamp-1">{{ $participants }}</p>
            </div>
            <div class="flex gap-2 items-center text-sm text-slate-700">
                <span class="icon-[mdi--location] shrink-0"></span>
                <p class="h-[1lh] line-clamp-1">{{ $location }}</p>
            </div>
        </div>
        <div class="w-full flex gap-2 justify-end">
            <button wire:click="dispatch('open', { description: '{{ $description }}',  name: '{{ $name }}', url: '{{ $url }}' })" class="text-slate-600 text-xs flex gap-0.5 items-center">
                <p>Selengkapnya</p>
                <span class="icon-[mdi--chevron-down]"></span>
            </button>
            <a href="{{ $url }}" target="_blank" class="rounded-lg bg-green-500 py-1 px-4 text-slate-50 w-fit self-end transition-all duration-200 hover:bg-green-600">
                <p>Daftar</p>
            </a>
        </div>
    </figcaption>
</div>
