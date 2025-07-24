<div class="f-carousel__slide flex w-full justify-center items-center p-2">
    <div class="flex flex-col w-full rounded-xl gap-2 p-2 lg:p-4 shadow-md">
        <a href="https://www.youtube.com/watch?v={{ $video_id }}" data-fancybox class="relative w-full aspect-video rounded-xl overflow-hidden outline-none focus:outline-none group">
            <img src="https://img.youtube.com/vi/{{ $video_id }}/hqdefault.jpg" alt="Video thumbnail" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
            <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                <span class="icon-[mdi--play-circle] text-white text-6xl drop-shadow-lg"></span>
            </div>
        </a>
        <div class="flex flex-col w-full items-center justify-between h-32">
            <div class="w-full flex flex-col gap-1">
                <h5 class="text-slate-800 font-semibold">{{ $name }}</h5>
                <p class="text-xs text-slate-600 italic">{{ $position }} - {{ $company }}</p>
            </div>
            <div class="w-full flex justify-between items-center">
                <div class="flex items-center gap-2 text-blue-800 font-semibold lg:text-xl bg-blue-100 px-2 rounded-lg">
                    <span class="icon-[mdi--star]"></span>
                    <p>{{ $rating }}</p>
                </div>
                <div class="flex gap-2 text-sm text-slate-600 italic items-center">
                    <span class="icon-[mdi--graduation-cap]"></span>
                    <p class="">Alumni {{ $passing_year }}</p>
                </div>
            </div>
        </div>
    </div>
</div>