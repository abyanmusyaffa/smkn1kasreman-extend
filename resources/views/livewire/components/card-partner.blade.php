<article data-aos="fade-up" class="flex w-full p-2 gap-4 lg:p-6 lg:gap-6 rounded-2xl bg-white min-h-28 lg:min-h-52">
    <img src="/storage/{{ $logo }}" class="w-20 lg:w-40 object-contain" alt="">
    <div class="flex flex-col">
        <h4 class="text-slate-800 text-xs lg:text-2xl font-medium">{{ $name }}</h4>
        <p class="text-slate-600 text-2xs lg:text-base line-clamp-2 lg:line-clamp-3">{{ $address }}</p>
        <div class="flex flex-wrap w-full gap-2 mt-auto">
            @foreach( $industry as $item )
            <p class="text-blue-600 text-2xs lg:text-xs outline-1 outline whitespace-nowrap outline-blue-600 py-[1px] lg:py-0.5 px-1 lg:px-2 rounded-lg">{{ $item }}</p>
            @endforeach
        </div>
    </div>
</article>