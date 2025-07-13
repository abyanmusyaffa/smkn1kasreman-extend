<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <livewire:components.title-left text="Praktek Kerja" span="Lapangan" />
    <!-- internship -->
    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6 w-full">
        <article class="flex flex-col bg-white rounded-2xl w-full p-4 lg:p-8">
            <div id="rich-content" class="prose lg:prose-figure:w-2/3 lg:prose-figure:mx-auto w-full max-w-none">
                {!! $internship->description !!}
            </div>
        </article>
        @if($internship->articles->count() > 0)
        <aside class="lg:min-w-96 lg:max-w-96 h-fit flex flex-col bg-white rounded-2xl w-full p-4 lg:p-8 gap-4 items-center lg:justify-between">
            <h3 class="text-xl font-semibold text-slate-800 text-center">Informasi</h3>
            <div class="w-full f-carousel" id="informationsCarousel">
              <div class="f-carousel__viewport rounded-2xl">
                @foreach($internship->articles as $article)
                  <livewire:components.card-article-home wire:key="{{ $article->id }}" :category="$article->category" :slug="$article->slug" :photo="$article->photo" :created_at="$article->created_at" :title="$article->title" />
                @endforeach
              </div>
            </div>
        </aside>
        @endif
    </div>
    <!-- internship -->
    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
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
        // const galleriesContainer = document.getElementById("galleriesCarousel");
        // if (galleriesContainer && !galleriesContainer.dataset.initialized) {
        //   Carousel(galleriesContainer, {
        //     infinite: true,
        //     Autoplay: { showProgressbar: false }
        //   }, { Arrows, Autoplay }).init();
        //   galleriesContainer.dataset.initialized = "true";
        // }
  
        // Carousel: informations
        const informationsContainer = document.getElementById("informationsCarousel");
        if (informationsContainer && !informationsContainer.dataset.initialized) {
          Carousel(informationsContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay }).init();
          informationsContainer.dataset.initialized = "true";
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