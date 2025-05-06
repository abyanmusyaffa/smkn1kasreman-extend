<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-slate-100">
    <!-- news -->
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <!-- pinned -->
        @if($newsPinned->count() > 0)
        <div class="overflow-hidden w-full aspect-video lg:aspect-[21/9]">
          @foreach($newsPinned as $news)
              <livewire:components.carousel-news wire:key="{{ $news->id }}" :slug="$news->slug" :createdAt="$news->created_at" :title="$news->title" :content="$news->content" :photo="$news->photo" />
          @endforeach
        </div>
        @endif
        <!-- pinned -->

        <!-- all news -->
        <div data-aos="fade-up" class="flex flex-col gap-4 w-full justify-center">
          <livewire:components.title-left text="Berita" />

          <livewire:components.paginate :onNews="true" />
        </div>
        <!-- all news -->
    </article>
    <!-- news -->

    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
        // slide achieve
        const slidesAchieve = document.querySelectorAll("[data-slide-achievement]");
        let currentSlideAchieve = 0;

        function showNextSlideAchieve() {
            slidesAchieve[currentSlideAchieve].classList.add("hidden");

            currentSlideAchieve = (currentSlideAchieve + 1) % slidesAchieve.length;

            slidesAchieve[currentSlideAchieve].classList.remove("hidden");
        }

        setInterval(showNextSlideAchieve, 4000);
        // slide achieve
      });
    </script>
    @endscript
</div>