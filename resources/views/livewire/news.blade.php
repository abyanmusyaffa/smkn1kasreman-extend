<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
  <livewire:components.title-left text="Berita" />
  <!-- news -->
  <!-- pinned -->
  @if($newsPinned->count() > 0)
  <article class="w-full bg-white rounded-2xl p-4 lg:px-32 lg:py-6">
    <div class="w-full f-carousel" id="newsCarousel">
      <div class="f-carousel__viewport">
      @foreach($newsPinned as $news)
        <livewire:components.carousel-article wire:key="{{ $news->id }}" :slug="$news->slug" :created_at="$news->created_at" :title="$news->title" :content="$news->content" :photo="$news->photo" :category="$news->category" />
      @endforeach
      </div>
    </div>
  </article>
  @endif
  <!-- pinned -->
  <!-- all news -->
  <aside data-aos="fade-up" class="flex flex-col gap-4 w-full justify-center p-2 lg:p-4 rounded-2xl bg-white">
      <livewire:components.paginate :onNews="true" >
  </aside>
  <!-- all news -->
  <!-- news -->

    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
        // slide achieve
        // const slidesAchieve = document.querySelectorAll("[data-slide-achievement]");
        // let currentSlideAchieve = 0;

        // function showNextSlideAchieve() {
        //     slidesAchieve[currentSlideAchieve].classList.add("hidden");

        //     currentSlideAchieve = (currentSlideAchieve + 1) % slidesAchieve.length;

        //     slidesAchieve[currentSlideAchieve].classList.remove("hidden");
        // }

        // setInterval(showNextSlideAchieve, 4000);
        // slide achieve

        // news carousel
        const newsContainer = document.getElementById("newsCarousel");
        const newsOptions = {
          infinite: true ,
          Autoplay: {
            showProgressbar: false,
          },
        };

        Carousel(newsContainer, newsOptions, { Dots , Arrows, Autoplay }).init();
        // news carousel
      });
    </script>
    @endscript
</div>