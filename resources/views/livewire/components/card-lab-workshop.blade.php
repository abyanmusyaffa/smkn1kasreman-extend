<div data-aos="fade-up" class="flex w-full lg:flex-row flex-col items-center bg-white rounded-xl overflow-x-hidden gap-1 lg:gap-0">
    <figure data-fancybox data-src='/storage/{{ $photo }}' data-caption="{{ $name }} | {{ $description }}" class="aspect-[4/3] w-full lg:w-1/3 shrink-0 bg-cover bg-center bg-no-repeat" style="background-image: url('storage/{{ $photo }}')"></figure>
    <figcaption class="flex w-full p-2 lg:p-4 flex-col gap-1 justify-between h-full">
        <div class="flex justify-between lg:justify-normal lg:flex-col w-full gap-1 items-center lg:items-start">
            <h3 class="font-medium text-slate-800 lg:text-xl">{{ $name }}</h3>
            <div class="flex shrink-0 px-2 outline outline-1 rounded outline-blue-200 w-fit h-fit">
                <p class="text-xs text-blue-800 font-medium">{{ $code }}</p>
            </div>
        </div>
        <p class="text-xs lg:text-sm text-slate-600">{{ $description }}</p>
    </figcaption>
</div>