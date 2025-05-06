<a href="/news/{{ $slug }}" wire:navigate class="">
    <article data-slide-achievement="1" class="size-full relative">
        <figcaption class="bg-gradient-to-t lg:bg-gradient-to-r from-slate-900 to-white/0 size-full flex absolute rounded-2xl">
          <div class="flex w-full lg:w-2/3 lg:flex-col items-end lg:items-start p-4 gap-4 lg:py-12 lg:px-20">
            <div class="flex flex-col bg-blue-600 p-1 lg:px-2 lg:py-1 rounded-lg text-center min-w-16 lg:min-w-24">
              <p class="font-semibold text-slate-50 text-2xl lg:text-4xl">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('j') }}</p>
              <p class="text-slate-50 text-2xs lg:text-sm">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('F') }}</p>
              <p class="text-slate-50 text-2xs lg:text-sm">{{ \Carbon\Carbon::parse($createdAt)->translatedFormat('Y') }}</p>
            </div>
            <div class="flex flex-col lg:gap-4">
                <h3 class="lg:text-5xl font-medium text-slate-50 text-start line-clamp-3">{{ $title }}</h3>
                <p class="hidden lg:text-xl text-slate-50 lg:line-clamp-3">{{ $summary }}</p>
            </div>
            <livewire:components.more-button text="Selengkapnya" :href="url('/news/' . $slug)" elemen="div" flex="hidden lg:flex lg:mt-auto" />
          </div>
        </figcaption>
        <figure class="size-full bg-no-repeat bg-center bg-cover rounded-2xl" style="background-image: url(/storage/{{ $photo }});"></figure>
    </article>
</a>