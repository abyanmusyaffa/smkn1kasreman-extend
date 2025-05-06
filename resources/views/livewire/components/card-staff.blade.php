<article class="flex flex-col items-center select-none">
    <img src="/storage/{{ $photo }}" class="h-[120px] lg:h-[172px]" alt="">
    <div class="flex flex-col text-center bg-blue-500 w-40 lg:w-60 px-2 py-0.5 lg:px-4 lg:py-1 rounded-lg">
        <p class="text-xs lg:text-lg font-medium text-slate-50 whitespace-nowrap">{{ $name }}</p>
        <p class="text-2xs lg:text-xs italic text-slate-200">{{ $role }}</p>
    </div>
</article>