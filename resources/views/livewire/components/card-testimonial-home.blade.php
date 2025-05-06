<article class="flex min-w-[100%] lg:min-w-[33.333333%] lg:max-w-[33.333333%] flex-col gap-2 lg:gap-4 p-2 lg:p-4 pt-12 lg:pt-16 shadow-skanka rounded-2xl relative bg-slate-50 transition-all duration-300">
    <figure style="background-image: url({{ strpos($photo, 'alumnis-tracer') !== false ? 'http://tracer-smkn1kasreman.test/' : '' }}/storage/{{ $photo }});" class="size-20 lg:size-28 rounded-full outline outline-4 outline-slate-50 bg-cover bg-no-repeat bg-center absolute -top-10 lg:-top-14 right-1/2 translate-x-1/2"></figure>
    {{-- <figure style="background-image: url({{ strpos($photo, 'alumnis-tracer') !== false ? 'https://tracer.smkn1kasreman.site/' : '' }}/storage/{{ $photo }});" class="size-20 lg:size-28 rounded-full outline outline-4 outline-slate-50 bg-cover bg-no-repeat bg-center absolute -top-10 lg:-top-14 right-1/2 translate-x-1/2"></figure> --}}
    <figcaption class="flex flex-col w-full text-center">
      <div class="flex w-full gap-1 items-center justify-center">
        <p class="text-sm lg:text-base text-slate-700">{{ $name }}</p>
        <p class="text-2xs lg:text-xs text-slate-600">/ Alumni {{ $passing_year }}</p>
      </div>
      <p class="text-2xs lg:text-xs text-slate-600">{{ $position }} - {{ $company }}</p>
    </figcaption>
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