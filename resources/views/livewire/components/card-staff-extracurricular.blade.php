<div class="f-carousel__slide !flex !justify-center !items-center">
    <div class="flex flex-col w-[96%] lg:w-[98%]">
        <figure data-fancybox="gallery" data-src="/storage/{{ $photo }}" data-caption="{{ $name }} | {{ $role }}" class="h-44 lg:h-48 w-full rounded-t-3xl lg:border-4 border-2 border-b-0 border-blue-600 bg-cover bg-center bg-no-repeat" style="background-image: url(/storage/{{ $photo }})">
        </figure>
        <div class="w-full h-fit rounded-b-2xl bg-gradient-to-r from-blue-600 to-blue-700 px-2 py-1 text-center">
          <p class="text-slate-50 text-xs lg:text-sm h-[2lh] line-clamp-2">{{ $name }}</p>
          <p class="text-slate-50 text-2xs lg:text-xs italic h-[1lh] line-clamp-1">{{ $role }}</p>
        </div>
    </div>
</div>