<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <livewire:components.title-left text="Cerita" span="Alumni" />
    {{-- Video --}}
    @if($testimonialVideo->count() > 0)
    <aside data-aos="fade-up" class="flex flex-col gap-4 w-full justify-center rounded-2xl bg-white px-4 py-2 lg:py-4">
      <div class="w-full f-carousel" id="testimonialsCarousel">
        <div class="f-carousel__viewport lg:grid-cols-3 xl:grid-cols-4">
          @foreach($testimonialVideo as $testimonial)
            <livewire:components.card-testimonial-video wire:key="{{ $testimonial->id }}" :url="$testimonial->url" :name="$testimonial->alumnis->name" :passing_year="$testimonial->alumnis->passing_year" :position="$testimonial->position" :company="$testimonial->company" :photo="$testimonial->alumnis->photo" :rating="$testimonial->rating" >
          @endforeach
        </div>
      </div>
    </aside>
    @endif
    {{-- Video --}}

    <!-- alumni -->
    <article data-aos="fade-up" class="flex flex-col gap-4 w-full justify-center p-2 lg:p-4 rounded-2xl bg-white">
        <livewire:components.paginate :onTestimonials="true" />
    </article>
    <!-- alumni -->

    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
        // fancybox
        Fancybox.destroy(); 
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

        // testimonials carousel
        const testimonialsContainer = document.getElementById("testimonialsCarousel");
        if (testimonialsContainer && !testimonialsContainer.dataset.initialized) {
          Carousel(testimonialsContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay, Dots }).init();
          testimonialsContainer.dataset.initialized = "true";
        }
        // testimonials carousel
      });
    </script>
    @endscript
</div>