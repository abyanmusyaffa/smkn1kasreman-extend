{{-- @dd($extracurricularDetail->contacts) --}}
<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col lg:flex-row gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    {{-- <livewire:components.title-left text="OSIS" /> --}}
    <!-- student council -->
    <aside class="flex flex-col items-center lg:w-1/4 gap-4 lg:gap-6">
        <div class="flex flex-col items-center w-full bg-white h-fit rounded-2xl p-4 lg:p-8 gap-2 lg:gap-4">
            <img data-fancybox src="/storage/{{ $extracurricularDetail->logo }}" class="w-1/3 lg:w-2/5 " alt="">
            <h2 class="font-semibold text-xl lg:text-2xl text-slate-700 text-center">{{ $extracurricularDetail->name }}</h2>
            <div class="w-fit flex gap-2">
                @foreach($extracurricularDetail->contacts as $contact)
                    <a href="{{ $contact['url'] }}" class="flex justify-center items-center size-6 lg:size-8 rounded-md bg-blue-800">
                        <span @class([
                            'text-sm lg:text-lg text-slate-50', 
                            'icon-[mingcute--whatsapp-fill]' => $contact['platform'] === 'whatsapp', 
                            'icon-[mingcute--mail-ai-fill]' => $contact['platform'] === 'email', 
                            'icon-[mingcute--ins-fill]' => $contact['platform'] === 'instagram', 
                            'icon-[mingcute--facebook-fill]' => $contact['platform'] === 'facebook', 
                            'icon-[mingcute--tiktok-fill]' => $contact['platform'] === 'tiktok', 
                            'icon-[mingcute--youtube-fill]' => $contact['platform'] === 'youtube', 
                            ])>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- <div class="flex flex-col items-center w-full bg-white h-fit rounded-2xl p-4 lg:p-8 gap-2 lg:gap-4">

        </div> --}}

    </aside>
    <article class="flex flex-col gap-4 lg:gap-6 items-center w-full lg:w-3/4">
        <div class="flex flex-col bg-white rounded-2xl w-full p-4 lg:p-8">
            <div id="rich-content" class="prose lg:prose-figure:w-2/3 lg:prose-figure:mx-auto w-full max-w-none">
                {!! $extracurricularDetail->description !!}
            </div>
        </div>

        <div class="flex flex-col bg-white rounded-2xl w-full p-4 lg:py-8 lg:px-20 lg:flex-row gap-4 items-center lg:justify-between">
            <div class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/2 text-center lg:text-start">
              <h2 class="text-xl lg:text-4xl font-medium text-slate-800">Pengurus <br><span class="font-semibold">{{ $extracurricularDetail->name }}</span></h2>
              {{-- <p class="lg:text-xl text-slate-800">Tenaga kependidikan SMKN 1 Kasreman yang mendukung kelancaran operasional dan layanan administrasi sekolah.</p> --}}
            </div>
            <div class="w-full lg:min-w-[340px] lg:max-w-[340px] f-carousel" id="staffCarousel">
              <div class="f-carousel__viewport rounded-2xl grid-cols-2 ">
                @foreach($extracurricularDetail->staff as $staff )
                  <livewire:components.card-staff-extracurricular  :photo="$staff['photo']" :name="$staff['name']" :role="$staff['role']" />
                @endforeach
              </div>
            </div>
        </div>
        {{-- <aside data-aos="fade-right" class="flex w-full flex-col lg:flex-row gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
        </aside> --}}
    </article>
    <!-- student council -->
    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
        const richContentContainers = document.querySelectorAll('#rich-content');

        richContentContainers.forEach(container => {
            const imageLinks = container.querySelectorAll('a > img');

            imageLinks.forEach(img => {
                const link = img.closest('a');
                if (link && !link.hasAttribute('data-fancybox')) {
                link.setAttribute('data-fancybox', 'gallery');
                }
            });
        });

        // fancybox
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

        // staff carousel
        const staffContainer = document.getElementById("staffCarousel");
        const staffOptions = {
          infinite: true ,
          Autoplay: {
            showProgressbar: false,
          },
        };

        Carousel(staffContainer, staffOptions, { Arrows, Autoplay }).init();
        // staff carousel
      });
    </script>
    @endscript
</div>