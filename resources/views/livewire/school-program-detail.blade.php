{{-- @dd($schoolProgramDetail->articles) --}}
<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <livewire:components.title-left :text="$schoolProgramDetail->name" />
    <div class="flex flex-col lg:flex-row w-full gap-4 lg:gap-6" >
        <article class="flex flex-col bg-white rounded-2xl w-full p-4 lg:p-8" >
            <div id="rich-content" class="prose lg:prose-figure:w-2/3 lg:prose-figure:mx-auto w-full max-w-none">
                {!! $schoolProgramDetail->description !!}
            </div>
        </article>
        @if($schoolProgramDetail->galleries)
        <aside class="flex flex-col w-full lg:min-w-96 lg:max-w-96 gap-4 lg:gap-6" >
            <h3 class="text-xl font-semibold text-slate-800 text-center">Galeri</h3>
            <div class="w-full f-carousel" id="galleriesCarousel">
            <div class="f-carousel__viewport ">
                @foreach($schoolProgramDetail->galleries as $gallery)
                <div class="w-full f-carousel__slide !flex flex-col gap-2">
                    <figure data-fancybox="gallery" data-src="/storage/{{ $gallery['photo'] }}" data-caption="{{ $gallery['caption'] }}" class="f-carousel__slide w-full rounded-2xl aspect-[4/3] bg-no-repeat !bg-cover !bg-center" style="background-image: url('/storage/{{ $gallery['photo'] }}')"></figure>
                    <figcaption class="w-full items-center">
                        <p class="text-center text-slate-600">{{ $gallery['caption'] }}</p>
                    </figcaption>
                </div>
                @endforeach
            </div>
            </div>
        </aside>
        @endif
    </div>

    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
        // document.querySelectorAll(".attachment__caption").forEach(function (caption) {
        //     caption.remove();
        // });
  
        // Fancybox re-bind
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
  
        // Carousel: galleries
        const galleriesContainer = document.getElementById("galleriesCarousel");
        if (galleriesContainer && !galleriesContainer.dataset.initialized) {
          Carousel(galleriesContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay }).init();
          galleriesContainer.dataset.initialized = "true";
        }
  
        // Bind gallery image links (in case of dynamic HTML)
        const richContentContainers = document.querySelectorAll('#rich-content');
        richContentContainers.forEach(container => {
          const imageLinks = container.querySelectorAll('a > img');
          imageLinks.forEach(img => {
            const link = img.closest('a');
            if (link && !link.hasAttribute('data-fancybox')) {
              link.setAttribute('data-fancybox', '');
            }
          });
        });
      });
    </script>
    @endscript
  </div>