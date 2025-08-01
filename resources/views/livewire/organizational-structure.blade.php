<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    {{-- organizational structure --}}
    @foreach($organizational_structures as $organizational_structure)
      {{-- <aside data-aos="fade-right" class="flex w-full flex-col lg:flex-row{{ $index === 0 ? '-reverse' : '' }}  gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
        <figcaption class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
          <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">{{ $organizational_structure->name }}</h2>
          <p class="lg:text-xl text-slate-800">{{ $organizational_structure->description }}</p>
        </figcaption>
        <figure class="w-full lg:w-3/5">
          <img class="w-full lg:h-auto" data-fancybox src="storage/{{ $organizational_structure->photo }}" alt="">
        </figure>
      </aside> --}}
      <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-center text="{{ $organizational_structure->name }}"/>
        <figcaption>
          <p class="text-center lg:text-xl text-slate-700 prose max-w-none">{{ $organizational_structure->description }}</p>
        </figcaption>
        <figure class="p-4 lg:p-6 bg-white rounded-lg lg:rounded-xl shadow-md">
          <img data-fancybox class="w-full lg:w-auto lg:h-[512px]" src="storage/{{ $organizational_structure->photo }}" alt="">
        </figure>
      </article>
    @endforeach
    {{-- organizational structure --}}

    @script
    <script>
    document.addEventListener("livewire:navigated", function () {
        // fancybox
        Fancybox.destroy(); // clear binding
        Fancybox.bind("[data-fancybox]", {
        Hash: false,
        hideScrollbar: false,
        parentEl: null,
        on: {
            init: (fancybox) => {
            scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            },
            destroy: (fancybox) => {
            setTimeout(() => {
                window.scrollTo(0, scrollPosition);
            }, 10);
            }
        }
        });
        // fancybox
    });
    </script>
    @endscript
</div>