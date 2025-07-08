<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <!-- achievement -->
    <livewire:components.title-left text="Prestasi" />
    <!-- pinned -->
    @if($achievementsPinned->count() > 0)
    <article class="w-full bg-white rounded-2xl p-4 lg:px-32 lg:py-6">
      <div class="w-full f-carousel" id="achievementsCarousel">
        <div class="f-carousel__viewport">
          @foreach($achievementsPinned as $index => $achievementPinned)
            <livewire:components.carousel-article wire:key="$achievementPinned->id" :photo="$achievementPinned->photo" :rankings="$achievementPinned->rankings" :title="$achievementPinned->title" :content="$achievementPinned->content" :slug="$achievementPinned->slug">
          @endforeach
        </div>
      </div>
    </article>
    @endif
    <!-- pinned -->

    <!-- all achievement -->
    <aside data-aos="fade-up" class="flex flex-col gap-4 w-full justify-center p-2 lg:p-4 rounded-2xl bg-white">
      <livewire:components.paginate :onAchievements="true" />
    </aside>
    <!-- all achievement -->
    <!-- achievement -->

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

        // achievements carousel
        const achievementsContainer = document.getElementById("achievementsCarousel");
        const achievementsOptions = {
          infinite: true ,
          Autoplay: {
            showProgressbar: false,
          },
        };

        Carousel(achievementsContainer, achievementsOptions, { Autoplay, Dots, Arrows }).init();
        // achievements carousel
      });
    </script>
    @endscript
</div>