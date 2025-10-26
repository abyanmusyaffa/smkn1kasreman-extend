<div class="w-full overflow-hidden lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <!-- welcome text-->
    @if($school->welcome_text != null)
    <article class="flex w-full flex-col rounded-2xl outline-4 outline outline-slate-200 p-4 lg:p-6 gap-2 lg:gap-6">
      <div class="flex flex-col lg:flex-row items-center lg:justify-between w-full gap-4">
        <div class="flex flex-col lg:min-w-48 min-w-36">
            <figure data-fancybox data-src="/storage/{{ $head_master->staff->photo }}" class="h-44 lg:h-64 w-full flex flex-col items-center justify-end rounded-t-3xl lg:border-4 border-2 border-b-0 border-blue-600 bg-cover bg-center bg-no-repeat" style="background-image: url(/storage/{{ $head_master->staff->photo }})">
            </figure>
            <div class="w-full h-fit rounded-b-2xl bg-gradient-to-r from-blue-600 to-blue-700 px-2 py-1 text-center">
              <p class="text-slate-50 text-xs lg:text-sm">{{ $head_master->staff->name }}</p>
              <p class="text-slate-50 text-2xs lg:text-xs italic">{{ $head_master->role }}</p>
            </div>
        </div>
        <p class="text-sm lg:text-base italic text-slate-700 text-center lg:w-4/5">“{{ $school->welcome_text }}”</p>
      </div>
    </article>
     {{-- <article class="flex flex-col lg:flex-row-reverse items-center gap-4 lg:gap-12 lg:px-24">
      <figure>
      </figure>
      <figcaption>
      </figcaption>
     </article> --}}
    @endif
    <!-- welcome text-->

    <!-- profile -->
    <aside class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-left text="Profil" span="Sekolah" />
      <div class="flex flex-col w-full items-center gap-4 lg:gap-9">
        <figure class="flex gap-4 lg:gap-11 items-center">
          <img src="/img/svg/smk bisa.svg" class="h-6 lg:h-12" alt="">
          <img src="/storage/{{ $school->logo }}" class="h-12 lg:h-28" alt="">
          <img src="/img/svg/vokasi.svg" class="h-8 lg:h-16" alt="">
        </figure>
        <iframe class="w-full lg:w-2/5 aspect-video rounded-xl" src="https://www.youtube.com/embed/{{ $profile_video_id }}?si=Hifffx7NdQLbAi2f&amp;controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <article data-aos="fade-up" class="text-justify lg:text-xl text-slate-700 prose max-w-none">{!! $school->description !!}</article>
        <div data-aos="fade-up" class="counter-container grid grid-cols-2 lg:grid-cols-5 gap-2 w-full">
          <div class="flex flex-col items-center w-full bg-blue-600 p-2 rounded-lg lg:rounded-2xl text-slate-50">
            <span class="icon-[mdi--people-outline] text-5xl lg:text-[80px]"></span>
            <p class="counters text-5xl font-semibold" data-count="{{ $total_staff }}">0</p>
            <p class="text-sm text-center lg:text-lg font-medium">Tenaga Kependidikan</p>
          </div>
          <div class="flex flex-col items-center w-full bg-blue-600 p-2 rounded-lg lg:rounded-2xl text-slate-50">
            <span class="icon-[mdi--user-outline] text-5xl lg:text-[80px]"></span>
            <p class="counters text-5xl font-semibold" data-count="{{ $total_teachers }}">0</p>
            <p class="text-sm text-center lg:text-lg font-medium">Guru</p>
          </div>
          <div class="flex flex-col lg:order-first col-span-2 lg:col-span-1 items-center w-full bg-blue-600 p-2 rounded-lg lg:rounded-2xl text-slate-50">
            <span class="icon-[ph--student] text-5xl lg:text-[80px]"></span>
            <p class="counters text-5xl font-semibold" data-count="{{ $total_students }}">0</p>
            <p class="text-sm text-center lg:text-lg font-medium">Siswa</p>
          </div>
          <div class="flex flex-col items-center w-full bg-blue-600 p-2 rounded-lg lg:rounded-2xl text-slate-50">
            <span class="icon-[mdi--graduation-cap-outline] text-5xl lg:text-[80px]"></span>
            <p class="counters text-5xl font-semibold" data-count="{{ $total_majors }}">0</p>
            <p class="text-sm text-center lg:text-lg font-medium">Konsentrasi Keahlian</p>
          </div>
          <div class="flex flex-col items-center w-full bg-blue-600 p-2 rounded-lg lg:rounded-2xl text-slate-50">
            <span class="icon-[mdi--tennis-ball-outline] text-5xl lg:text-[80px]"></span>
            <p class="counters text-5xl font-semibold" data-count="{{ $total_extracurriculars }}">0</p>
            <p class="text-sm text-center lg:text-lg font-medium">Ekstrakurikuler</p>
          </div>
        </div>
        <article class="flex w-full flex-col rounded-2xl outline-4 outline outline-slate-200 p-4 lg:p-6 gap-2 lg:gap-6">
          <header class="flex items-center gap-4 lg:gap-6">
            <div class="w-full h-1 bg-slate-200 rounded-sm"></div>
            <p class="text-xl lg:text-3xl font-medium text-salte-800 whitespace-nowrap">Visi & Misi</p>
            <div class="w-full h-1 bg-slate-200 rounded-sm"></div>
          </header>
          <div class="flex flex-col lg:flex-row gap-6">
            <div data-aos="fade-right" class="flex flex-col w-full gap-2 lg:gap-4">
              <p class="text-lg lg:text-2xl font-medium text-center">Visi</p>
              <article class="prose prose-sm lg:prose-lg text-center prose-slate">{!! $school->vision !!}</article>
            </div>
            <div class="w-1 min-h-[100%] bg-slate-200 rounded-sm hidden lg:block"></div>
            <div data-aos="fade-left" class="flex flex-col w-full gap-2 lg:gap-4">
              <p class="text-lg lg:text-2xl font-medium text-center">Misi</p>
              <article class="prose prose-sm lg:prose-lg prose-slate">{!! $school->mission !!}</article>
            </div>
          </div>
        </article>
      </div>
    </aside>
    <!-- profile -->

    @script
    <script>
      document.addEventListener("livewire:navigated", function() {
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

        // counter
        let activated = false;
        const container = document.querySelector(".counter-container");
        const counters = document.querySelectorAll(".counters");

        if (!container || counters.length === 0) {
          console.warn('Counter elements tidak ditemukan');
          return;
        }

        function animateCounter(counter, target) {
          let current = 0;
          const duration = 2000;
          const stepTime = 20; 
          const steps = duration / stepTime;
          const increment = target / steps;

          const timer = setInterval(() => {
            current += increment;
            
            if (current >= target) {
              clearInterval(timer);
              counter.textContent = Math.round(target);
            } else {
              counter.textContent = Math.round(current);
            }
          }, stepTime);
        }

        // function resetCounters() {
        //   counters.forEach(counter => {
        //     counter.textContent = '0';
        //   });
        //   activated = false;
        // }

        let ticking = false;

        window.addEventListener("scroll", () => {
          if (!ticking) {
            window.requestAnimationFrame(() => {
              const triggerPoint = container.offsetTop - (window.innerHeight * 1);

              if (window.scrollY > triggerPoint && !activated) {
                counters.forEach(counter => {
                  const target = parseInt(counter.dataset.count) || 0;
                  animateCounter(counter, target);
                });
                activated = true;
              } 
              // Reset jika scroll ke atas jauh
              // else if (window.scrollY < triggerPoint - 300) {
              //   resetCounters();
              // }
              
              ticking = false;
            });
            
            ticking = true;
          }
        });

        window.dispatchEvent(new Event('scroll'));
      });      
    </script>
    @endscript
</div>