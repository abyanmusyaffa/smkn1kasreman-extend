<article data-aos="fade-up" id="{{ strtolower($alias) }}" class="flex w-full flex-col {{ $index % 2 !== 0 ? 'lg:flex-row' : 'lg:flex-row-reverse'}} items-center lg:justify-between rounded-2xl bg-white p-4 gap-4 lg:px-24 lg:py-6">
    <figure class="grid w-full lg:w-1/3 grid-cols-2 grid-rows-2 gap-2">
        <div class="grid place-items-center w-full aspect-square rounded-2xl bg-blue-600">
            <img data-fancybox src="/storage/{{ $logo }}" class="w-28 lg:w-36" alt="">
        </div>
        @foreach($galleries as $item)
        <div data-fancybox data-src="/storage/{{ $item }}" style="background-image: url(/storage/{{ $item }});" class="bg-no-repeat bg-center bg-cover w-full {{ $loop->first ? ('aspect-square ' . ($index % 2 !== 0 ? 'lg:order-first' : '')) : 'col-span-2' }} rounded-2xl"></div>
        @endforeach
    </figure>
    <figcaption class="text-center lg:text-start w-full lg:w-1/2 flex flex-col gap-8 lg:gap-14 items-center {{ $index % 2 !== 0 ? 'lg:items-end' : 'lg:items-start'}}">
        <div class="flex flex-col gap-2 lg:gap-4">
            <div class="flex flex-col items-center {{ $index % 2 !== 0 ? 'lg:items-end lg:text-end' : 'lg:items-start lg:text-start'}} ">
                <div class="flex items-center gap-2">
                    <div class="h-0.5 w-6 bg-slate-700"></div>
                    <p class="font-medium text-sm lg:text-base text-slate-700">{{ $alias }}</p>
                    <div class="h-0.5 w-6 bg-slate-700"></div>
                </div>
                <h3 class="font-semibold text-2xl lg:text-4xl text-slate-800">{{ $expertise_concentration }}</h3>
            </div>
            <p class="text-sm lg:text-base line-clamp-[8] lg:line-clamp-4 text-slate-700  {{ $index % 2 !== 0 ? 'lg:text-end' : 'lg:text-start'}}">{{ $summary }}</p>
            <div class="flex w-full justify-between">
                <div class="flex flex-col lg:flex-row gap-1 lg:gap-2 items-center">
                    <div class="size-7 lg:size-11 rounded-lg bg-blue-400 grid place-items-center">
                        <span class="icon-[mdi--group] text-slate-50 lg:text-2xl"></span>
                    </div>
                    <p class="text-slate-800 text-sm lg:text-xl font-medium">{{ $studyGroup }} Rombel</p>
                </div>
                <div class="flex flex-col lg:flex-row gap-1 lg:gap-2 items-center">
                    <div class="size-7 lg:size-11 rounded-lg bg-blue-400 grid place-items-center">
                        <span class="icon-[mdi--clock-outline] text-slate-50 lg:text-2xl"></span>
                    </div>
                    <p class="text-slate-800 text-sm lg:text-xl font-medium">{{ $studyPeriod }} Tahun Belajar</p>
                </div>
                <div class="flex flex-col lg:flex-row gap-1 lg:gap-2 items-center">
                    <div class="size-7 lg:size-11 rounded-lg bg-blue-400 grid place-items-center">
                        <span class="icon-[ph--student] text-slate-50 lg:text-2xl"></span>
                    </div>
                    <p class="text-slate-800 text-sm lg:text-xl font-medium">{{ $totalStudents }} Siswa</p>
                </div>
            </div>
        </div>
        <livewire:components.more-button text="Selengkapnya" :href=" '/m/' . strtolower($alias)"  >
    </figcaption>
</article>  