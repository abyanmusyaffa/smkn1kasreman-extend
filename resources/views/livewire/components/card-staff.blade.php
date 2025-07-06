{{-- <article class="flex flex-col items-center select-none">
    <img src="/storage/{{ $photo }}" class="h-[120px] lg:h-[172px]" alt="">
    <div class="flex flex-col text-center bg-blue-500 w-40 lg:w-60 px-2 py-0.5 lg:px-4 lg:py-1 rounded-lg">
        <p class="text-xs lg:text-lg font-medium text-slate-50 whitespace-nowrap">{{ $name }}</p>
        <p class="text-2xs lg:text-xs italic text-slate-200">{{ $role }}</p>
    </div>
</article> --}}
<div class="f-carousel__slide !flex !justify-center !items-center">
    <div class="flex flex-col w-[96%] lg:w-[98%]">
        <figure class="h-44 lg:h-64 w-full flex flex-col items-center justify-end rounded-t-3xl lg:border-4 border-2 border-b-0 border-blue-600 bg-cover bg-center bg-no-repeat" style="background-image: url(/storage/{{ $photo }})">
        </figure>
        <div class="w-full h-fit rounded-b-2xl bg-gradient-to-r from-blue-600 to-blue-700 px-2 py-1 text-center">
          <p class="text-slate-50 text-xs lg:text-sm h-[2lh]">{{ $name }}</p>
          <p class="text-slate-50 text-2xs lg:text-xs italic h-[1lh]">{{ $role }}</p>
        </div>
    </div>
</div>