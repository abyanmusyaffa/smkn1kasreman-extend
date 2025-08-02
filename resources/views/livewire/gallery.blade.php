<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <livewire:components.title-left text="Galeri" span="Skanka" />
      <!-- galleries -->
    <article class="grid lg:grid-cols-4 w-full gap-4 lg:gap-6 items-center">
        @foreach($galleries as $gallery)
        <div data-fancybox="gallery" data-src="/storage/{{ $gallery['photo'] }}" data-caption="{{ $gallery['caption'] }}" class="w-full bg-white flex flex-col items-center rounded-2xl overflow-x-hidden gap-2 shadow-lg hover:scale-[1.02] transition-all duration-300">
            <figure class="bg-no-repeat bg-cover bg-center w-full aspect-video" style="background-image: url('/storage/{{ $gallery['photo'] }}')"></figure>
            <figcaption class="w-full flex justify-center">
                <h3 class="text-center text-lg text-slate-600 italic h-[2lh] line-clamp-2">{{ $gallery['caption'] }}</h3>
            </figcaption>
        </div>
        @endforeach
    </article>
    <!-- galleries -->

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