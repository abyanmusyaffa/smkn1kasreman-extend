<article data-aos="fade-up" class="flex w-full flex-col p-4 gap-2 lg:gap-4 bg-white rounded-2xl">
    <header class="flex w-full gap-2 lg:gap-4 items-center">
        <figure style="background-image: url({{ strpos($photo, 'alumnis-tracer') !== false ? 'http://tracer-smkn1kasreman.test/' : '' }}/storage/{{ $photo }});" class="bg-no-repeat bg-cover bg-center rounded-full size-14 lg:size-16"></figure>
        {{-- <figure style="background-image: url({{ strpos($photo, 'alumnis-tracer') !== false ? 'https://tracer.smkn1kasreman.site/' : '' }}/storage/{{ $photo }});" class="bg-no-repeat bg-cover bg-center rounded-full size-14 lg:size-16"></figure> --}}
        <figcaption>
            <h5 class="text-xs lg:text-base text-slate-700 inline">{{ $name }}</h5>
            <p class="inline text-2xs lg:text-xs text-slate-600">/ Alumni {{ $passing_year }}</p>
            <p class="text-2xs lg:text-xs text-slate-600">{{ $position }}</p>
            <p class="text-2xs lg:text-xs font-medium text-slate-700">{{ $company }}</p>
        </figcaption>
    </header>
    <p class="text-xs lg:text-base text-slate-700 h-[11lh] lg:h-[9lh] line-clamp-[11] lg:line-clamp-[9]">{{ $content }}</p>
    <footer class="flex w-full justify-center gap-1 lg:gap-2">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= $rating)
                {{-- Bintang solid --}}
                <span class="icon-[mdi--star] lg:text-xl"></span>
            @else
                {{-- Bintang outline --}}
                <span class="icon-[mdi--star-outline] lg:text-xl"></span>
            @endif
        @endfor
    </footer>
</article>