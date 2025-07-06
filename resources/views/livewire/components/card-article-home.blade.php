<a href="/{{ $category }}/{{ $slug }}" wire:navigate class="f-carousel__slide !flex !flex-col !items-center">
  <article class="flex flex-col rounded-2xl border-2 lg:border-4 bg-white border-blue-100 w-full lg:w-[96%] p-2 lg:p-4 gap-2 lg:gap-4">
    <figure style="background-image: url(/storage/{{ $photo }});" class="aspect-[4/3] w-full rounded-xl bg-cover bg-no-repeat bg-center"></figure>
    <figcaption class="w-full flex flex-col gap-2 lg:gap-4 items-center">
      <h4 class="text-sm lg:text-xl text-slate-700 text-center h-[3lh] line-clamp-3">{{ $title }}</h4>
      <div class="flex gap-2 items-center bg-blue-100 px-2 py-1 rounded-2xl">
        <span class="icon-[mdi--calendar-badge] text-xs lg:text-sm text-blue-800"></span>
        <p class="text-xs lg:text-sm text-blue-800">{{ \Carbon\Carbon::parse($created_at)->translatedFormat('j F Y H:i') }}</p>
      </div>
    </figcaption>
  </article>
</a>