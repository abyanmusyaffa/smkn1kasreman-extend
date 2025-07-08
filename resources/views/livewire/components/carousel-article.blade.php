<div class="f-carousel__slide w-full flex flex-col lg:flex-row gap-4 lg:gap-8 justify-between">
    <figure class="w-full lg:w-2/5 aspect-[4/3] h-auto bg-no-repeat bg-center bg-cover rounded-xl" style="background-image: url(/storage/{{ $photo }})"></figure>
    <figcaption class="flex w-full lg:w-3/5 flex-col items-center lg:items-start lg:justify-between gap-2">
      <div class="flex flex-col gap-2 items-center lg:items-start">
        <div class="{{ $created_at ? 'bg-green-100' : 'bg-blue-100' }} flex w-fit px-2 py-1 lg:px-4 rounded items-center gap-1 lg:gap-2">
          <span class="{{ $created_at ? 'icon-[mdi--calendar-badge] text-green-800' : 'icon-[mingcute--medal-fill] text-blue-800' }} lg:text-sm "></span>
          <p class="{{ $created_at ? 'text-green-800' : 'text-blue-800' }} text-xs lg:text-base">{{ $rankings ?? \Carbon\Carbon::parse($created_at)->translatedFormat('j F Y H:i') }}</p>
        </div>
        <h2 class="text-lg font-medium text-slate-700 lg:text-xl xl:text-2xl text-center lg:text-start h-[3lh] line-clamp-3 lg:max-h-[2lh] lg:h-fit lg:line-clamp-2 xl:max-h-[3lh] xl:h-fit xl:line-clamp-3">{{ $title }}</h2>
        <p class="hidden text-slate-600 lg:inline xl:h-[4lh] xl:line-clamp-4 lg:h-[2lh] lg:line-clamp-2">{{ $summary }}</p>
      </div>
      <livewire:components.more-button text="Selengkapnya" :href=" $category === 'news' ? 'news/' . $slug : 'achievement/' . $slug "  >
    </figcaption>
</div>