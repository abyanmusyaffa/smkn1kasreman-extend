<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-slate-100">
    <!-- achievement -->
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <!-- pinned -->
        @if($achievementsPinned->count() > 0)
        <div class="overflow-hidden w-full aspect-video lg:aspect-[21/9]">
            @foreach($achievementsPinned as $index => $achievementPinned)
              <livewire:components.carousel-achievement wire:key="{{ $achievementPinned->id }}" :slug="$achievementPinned->slug" :index="$index" :photo="$achievementPinned->photo" :rankings="$achievementPinned->rankings" :title="$achievementPinned->title" /> 
            @endforeach
        </div>
        @endif
        <!-- pinned -->
        <!-- all news -->
        <div data-aos="fade-up" class="flex flex-col gap-4 w-full justify-center">
          <livewire:components.title-left text="Prestasi" />
          
          <livewire:components.paginate :onAchievements="true" />
        </div>
        <!-- all news -->
    </article>
    <!-- achievement -->

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