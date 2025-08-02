{{-- @dd($galleries) --}}
<div class="{{ $announcement_text ? 'pt-20 lg:pt-32' : 'pt-16 lg:pt-24' }} w-full overflow-hidden lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4  pb-9 lg:px-16 2xl:px-36  lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <!-- hero -->
    <figure class="relative flex w-full mt-8">
      {{-- running text announ --}}
      @if($announcement_text)
      <a href="/{{ $announcement_text->category }}/{{ $announcement_text->slug }}" wire:navigate class="announ-container flex w-full h-6 lg:h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl absolute -top-10 lg:-top-12 overflow-hidden gap-8">
        <div class="h-full w-fit flex bg-blue-500 justify-center items-center px-3 absolute z-[1] gap-2">
          <p class="hidden lg:block text-slate-50 text-sm font-semibold">Pengumuman</p><span class="icon-[mdi--loudspeaker] text-slate-50 text-xl lg:text-2xl"></span>
        </div>
        <div class="w-full f-carousel" id="announCarousel">
          <div class="f-carousel__viewport" id="announViewport">
            <div class="f-carousel__slide !min-w-fit lg:!w-fit !h-full !px-2 !flex !flex-col !justify-center">
              <p class="text-sm whitespace-nowrap text-slate-50">{{ $announcement_text->title }}</p>
            </div>
          </div>
        </div>
      </a>
      @endif
      {{-- running text announ --}}

      <div class="w-full relative overflow-hidden h-[480px] lg:h-[560px]">
        <!-- slideshow -->
        @foreach($school->hero_photos as $index => $hero)
          <div data-slide-hero="{{ $index+1 }}" style="background-image: url(/storage/{{ $hero }})" class="w-full absolute inset-0 {{ $loop->first ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-[2s] h-[480px] lg:h-[560px] rounded-2xl bg-center bg-cover bg-no-repeat"></div>
        @endforeach
      </div>

      <div class="absolute flex w-full h-[480px] lg:h-[560px] rounded-2xl bg-gradient-to-t from-slate-900 to-white/0 justify-center px-4 py-6 lg:py-9 items-end">
        <!-- welcome text -->
        <figcaption class="flex flex-col text-center w-full gap-2">
          <p class="text-xs lg:text-2xl text-slate-50">Selamat Datang di Website Resmi,</p>
          <h1 class="text-4xl font-semibold text-slate-50 lg:text-7xl lg:leading-[108px]">SMK Negeri {{ $school->name }}</h1>
          <p class="text-slate-50 text-xs lg:text-2xl">"{{ $school->motto }}"</p>
        </figcaption>
        <!-- welcome text -->
      </div>
    </figure>
    <!-- hero -->

    <!-- summary -->
    <article class="flex w-full flex-col gap-4 lg:gap-6 text-center items-center">
      <figure class="flex gap-4 lg:gap-6 items-center justify-center">
        <img src="/img/svg/smk bisa.svg" class="h-8 lg:h-14" alt="smk-bisa" />
        <img src="/img/svg/vokasi.svg" class="h-12 lg:h-24" alt="vokasi" />
      </figure>
      <p class="lg:text-xl text-slate-700 line-clamp-[15] lg:line-clamp-5">
        {{ $summary  }}
      </p>
      <livewire:components.more-button text="Selengkapnya" href="/about" />
      <!-- running partners -->
      <figure class="flex flex-col gap-2 lg:gap-4 items-center w-full">
        <h3 data-aos="fade-left" class="text-xl lg:text-3xl font-medium text-slate-800">Mitra DU/DI</h3>
        <p class="lg:text-xl text-slate-700 lg:w-3/5">
          SMKN {{ $school->name }} bekerja sama dengan berbagai mitra DU/DI untuk mendukung pembelajaran siswa dan membuka peluang karir di dunia kerja.
        </p>
        <div class="w-full f-carousel " id="partnersCarousel">
          <div class="f-carousel__viewport" id="partnersViewport">
            @foreach($partners as $partner)
              <div class="f-carousel__slide !w-fit !px-6">
                <img class="h-12 object-contain" src="/storage/{{ $partner }}" alt="" />
              </div>
            @endforeach
          </div>
        </div>
        {{-- <div class="logo-container flex w-full overflow-x-hidden">
          <div class="logo-animation flex *:object-contain *:h-12 gap-9 lg:gap-12 items-center flex-shrink-0 animate-partners-scroll pe-9 lg:pe-12">
            @foreach($partners as $partner)
              <img src="/storage/{{ $partner }}" alt="" />
            @endforeach
          </div>
        </div> --}}
      </figure>
      <!-- running partners -->
    </article>
    <!-- summary -->

    {{-- welcome video --}}
    @if($welcome_video_id)
    <aside class="flex w-full flex-col lg:flex-row-reverse gap-4 items-center lg:justify-between rounded-xl bg-white p-4 lg:py-6 lg:px-16">
      {{-- <livewire:components.title-left text="Sambutan" span="Kepala Sekolah" /> --}}
      <div data-aos="fade-left" class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">Sambutan <br><span class="text-blue-600 font-semibold">Kepala Sekolah</span></h2>
        <p class="lg:text-xl text-blue-600">- {{ $head_master }} -</p>
      </div>
      <iframe class="w-full lg:w-3/5 aspect-video rounded-xl" src="https://www.youtube.com/embed/{{ $welcome_video_id }}?si=Hifffx7NdQLbAi2f&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </aside>
    @endif
    {{-- welcome video --}}
    {{-- <iframe src="https://drive.google.com/file/d/1rrR_C9i-HYwslJYkXcJtLns_pzA7dZx_/preview" width="640" height="480" allow="autoplay"></iframe> --}}

    <!-- major -->
    <aside class="flex rounded-2xl bg-blue-600 w-full p-4 lg:py-6 lg:px-16 flex-col lg:flex-row lg:justify-between items-center gap-4">
      <div data-aos="fade-right" class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-slate-50">Program <br class="hidden lg:block"> Keahlian</h2>
        <p class="lg:text-xl text-slate-100">Beberapa program keahlian di SMKN {{ $school->name }} dirancang untuk mengantarkan siswa meraih kesuksesan di masa depan.</p>
      </div>
      <div class="grid grid-cols-12 w-full lg:w-3/5 gap-2 lg:gap-4">
        @foreach($majors as $major)
          <livewire:components.card-major-home wire:key="{{ $major->id }}" :alias="$major->alias" :colSpan="$loop->first ? 'lg:col-span-7' : ($loop->last ? 'lg:col-span-7' : 'lg:col-span-5')" :logo="$major->logo" :expertise_concentration="$major->expertise_concentration" />
        @endforeach
      </div>
    </aside>
    <!-- major -->

    <!-- news -->
    @if($articles->count() > 0)
    <aside class="flex w-full flex-col lg:flex-row-reverse gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
      {{-- <livewire:components.title-left text="Sambutan" span="Kepala Sekolah" /> --}}
      <div data-aos="fade-left" class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">Skanka <span class="text-blue-600 font-semibold">Terkini</span></h2>
        <p class="lg:text-xl text-blue-600">- {{ \Carbon\Carbon::parse($latest_article)->translatedFormat('j F Y H:i') }} -</p>
      </div>
      <div class="w-full lg:w-3/5 f-carousel" id="newsCarousel">
        <div class="f-carousel__viewport rounded-2xl lg:grid-cols-2 lg:justify-start">
          @foreach($articles as $index => $article)
            <livewire:components.card-article-home wire:key="{{ $article->id }}" :category="$article->category" :slug="$article->slug" :photo="$article->photo" :created_at="$article->created_at" :title="$article->title" :index="$index" />
          @endforeach
        </div>
      </div>
      {{-- <iframe class="w-full lg:w-3/5 aspect-video rounded-xl" src="https://www.youtube.com/embed/{{ $welcome_video_id }}?si=Hifffx7NdQLbAi2f&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> --}}
    </aside>
    @endif
    <!-- news -->

    <!-- achievement -->
    @if($achievements->count() > 0)
    <aside class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-left text="Prestasi" span="Kita" />
      <div class="grid lg:grid-cols-4 gap-4">
        @foreach($achievements as $achievement)
          <livewire:components.card-achievement wire:key="{{ $achievement->id }}" :slug="$achievement->slug" :photo="$achievement->photo" :rankings="$achievement->rankings" :title="$achievement->title" :created_at="$achievement->created_at" /> 
        @endforeach
      </div>
      <footer>
        <livewire:components.more-button text="Prestasi Lainya" href="/achievement" />
      </footer>
    </aside>
    @endif
    <!-- achievement -->

    <!-- gallery -->
    <aside class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-right text="Galeri" :span="$school->alias" />
      <figure class="grid grid-cols-2 lg:grid-cols-3 grid-rows-6 lg:grid-rows-3 w-full gap-2 lg:gap-4">
        {{-- <iframe class="w-full aspect-video lg:h-full lg:aspect-auto rounded-2xl col-span-2 row-span-2" src="https://www.youtube.com/embed/{{ $video_id }}?si=Hifffx7NdQLbAi2f&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> --}}
        @foreach($galleries as $index => $galerry)
          <div data-fancybox="gallery" data-src="/storage/{{ $galerry['photo'] }}" data-prevent-scroll="true" data-type="image" style="background-image: url(/storage/{{ $galerry['photo'] }});" 
            @class([
                'w-full aspect-video rounded-2xl bg-center bg-no-repeat bg-cover', 
                'col-span-2 row-span-2' => $index === 0 || $index === 3,
                'lg:col-span-2 lg:row-span-2 lg:h-full lg:aspect-auto' => $index === 0,
                'lg:col-span-1 lg:row-span-1' => $index === 3,
              ])>
          </div>
        @endforeach
      </figure>
    </aside>
    <!-- gallery -->

    <!-- alumni story -->
    {{-- @if($testimonials->count() > 0)
    <aside data-aos="fade-left" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-left text="Cerita" span="Alumni" />
      <div class="drag-to-scroll flex gap-4 w-full cursor-grab active:cursor-grabbing snap-x snap-mandatory overflow-x-scroll pt-10 lg:pt-14 p-2">
        @foreach($testimonials as $testimonial)
          <livewire:components.card-testimonial-home wire:key="{{ $testimonial->id }}" :photo="$testimonial->alumnis->photo" :name="$testimonial->alumnis->name" :passing_year="$testimonial->alumnis->passing_year" :position="$testimonial->position" :company="$testimonial->company" :content="$testimonial->content" :rating="$testimonial->rating" />
        @endforeach
      </div>
      <footer>
        <livewire:components.more-button text="Cerita Lainya" href="/alumni" />
      </footer>
    </aside>
    @endif --}}
    <!-- alumni story -->

    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
        // slide hero
        const slidesHero = document.querySelectorAll("[data-slide-hero]");
        let currentSlideHero = 0;

        function showNextSlideHero() {
            slidesHero[currentSlideHero].classList.add("opacity-0");

            currentSlideHero = (currentSlideHero + 1) % slidesHero.length;

            slidesHero[currentSlideHero].classList.remove("opacity-0");
        }

        setInterval(showNextSlideHero, 4000);
        // slide hero

        // announ animation
        const announViewport = document.getElementById("announViewport");

        if (announViewport) {
          const slides = announViewport.querySelectorAll(".f-carousel__slide");

          for (let i = 0; i < 6; i++) {
            slides.forEach(slide => {
              const clone = slide.cloneNode(true);
              announViewport.appendChild(clone);
            });
          }
        }
        // announ animation

        // logo animation
        const partnersViewport = document.getElementById("partnersViewport");

        if (partnersViewport) {
          const slides = partnersViewport.querySelectorAll(".f-carousel__slide");

          for (let i = 0; i < 2; i++) {
            slides.forEach(slide => {
              const clone = slide.cloneNode(true);
              partnersViewport.appendChild(clone);
            });
          }
        }
        // logo animation

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

        // news carousel
        const newsContainer = document.getElementById("newsCarousel");
        if (newsContainer && !newsContainer.dataset.initialized) {
          Carousel(newsContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay, Dots }).init();
          newsContainer.dataset.initialized = "true";
        }
        // news carousel

        // partners carousel
        const partnersContainer = document.getElementById("partnersCarousel");
        const partnersOptions = {
          infinite: true ,
          Autoscroll: {
            speedOnHover: 1
          },
        };

        Carousel(partnersContainer, partnersOptions, { Autoscroll }).init();
        // partners carousel

        // announ carousel
        const announContainer = document.getElementById("announCarousel");
        const announOptions = {
          infinite: true ,
          Autoscroll: {
            speedOnHover: 1
          },
        };

        Carousel(announContainer, announOptions, { Autoscroll }).init();
        // announ carousel
      });
    </script>
    @endscript
</div>