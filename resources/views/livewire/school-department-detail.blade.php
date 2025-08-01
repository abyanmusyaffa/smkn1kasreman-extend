{{-- @dd($schoolDepartmentDetail->articles) --}}
<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col lg:flex-row gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <div class="flex flex-col w-full lg:min-w-96 lg:max-w-96 gap-4 lg:gap-6">
      <aside class=" flex flex-col items-center w-full bg-white lg:h-fit rounded-2xl p-4 lg:p-8 gap-2 lg:gap-4">
        <div class="flex flex-col items-center">
            <p class="italic text-slate-500 text-sm lg:text-base">Unit Kerja</p>
            <h2 class="font-semibold text-2xl lg:text-3xl text-slate-700 text-center">{{ $schoolDepartmentDetail->name }}</h2>
        </div>
        <div class="w-fit flex gap-2">
            @foreach($schoolDepartmentDetail->contacts as $contact)
                <a href="{{ $contact['url'] }}" class="flex justify-center items-center size-6 lg:size-8 rounded-md bg-blue-800">
                    <span @class([
                        'text-sm lg:text-lg text-slate-50', 
                        'icon-[mingcute--whatsapp-fill]' => $contact['platform'] === 'whatsapp', 
                        'icon-[mingcute--mail-ai-fill]' => $contact['platform'] === 'email', 
                        ])>
                    </span>
                </a>
            @endforeach
        </div>
      </aside>
      <article class="lg:hidden flex flex-col bg-white rounded-2xl w-full lg:w-1/2 p-4 lg:p-8">
          <div id="rich-content" class="prose lg:prose-figure:w-2/3 lg:prose-figure:mx-auto w-full max-w-none">
              {!! $schoolDepartmentDetail->description !!}
          </div>
      </article>
      @if($schoolDepartmentDetail->staff)
      <article class="flex flex-col bg-white rounded-2xl w-full p-4 lg:p-8 gap-4 items-center lg:justify-between">
          <h3 class="text-xl font-semibold text-slate-800 text-center">Pengurus</h3>
          <div class="w-full f-carousel" id="staffCarousel">
            <div class="f-carousel__viewport rounded-2xl grid-cols-2 ">
              @foreach($schoolDepartmentDetail->staff as $staff )
                <livewire:components.card-staff-extracurricular  :photo="$staff['photo']" :name="$staff['name']" :role="$staff['role']" />
              @endforeach
            </div>
          </div>
      </article>
      @endif
      <article class=" flex flex-col bg-white rounded-2xl w-full p-4 lg:p-8 gap-4 items-center lg:justify-between">
        <h3 class="text-xl font-semibold text-slate-800 text-center">Galeri</h3>
        <div class="w-full f-carousel" id="galleriesCarousel">
          <div class="f-carousel__viewport ">
            @foreach($schoolDepartmentDetail->galleries as $gallery)
            <div class="w-full f-carousel__slide !flex flex-col gap-2">
                <figure data-fancybox="gallery" data-src="/storage/{{ $gallery['photo'] }}" data-caption="{{ $gallery['caption'] }}" class="f-carousel__slide w-full rounded-2xl aspect-[4/3] bg-no-repeat !bg-cover !bg-center" style="background-image: url('/storage/{{ $gallery['photo'] }}')"></figure>
                <figcaption class="w-full items-center">
                    <p class="text-center text-slate-600">{{ $gallery['caption'] }}</p>
                </figcaption>
            </div>
            @endforeach
          </div>
        </div>
      </article>
      @if($schoolDepartmentDetail->articles->count() > 0)
      <article class=" flex flex-col bg-white rounded-2xl w-full p-4 lg:p-8 gap-4 items-center lg:justify-between">
        <h3 class="text-xl font-semibold text-slate-800 text-center">Informasi</h3>
        <div class="w-full f-carousel" id="informationsCarousel">
          <div class="f-carousel__viewport rounded-2xl">
            @foreach($schoolDepartmentDetail->articles as $article)
              <livewire:components.card-article-home wire:key="{{ $article->id }}" :category="$article->category" :slug="$article->slug" :photo="$article->photo" :created_at="$article->created_at" :title="$article->title" />
            @endforeach
          </div>
        </div>
      </article>
      @endif
    </div>
    <div class="hidden lg:flex flex-col w-full gap-4 lg:gap-6">
      <article class="flex flex-col bg-white rounded-2xl w-full p-4 lg:p-8">
        <div id="rich-content" class="prose lg:prose-figure:w-2/3 lg:prose-figure:mx-auto w-full max-w-none">
            {!! $schoolDepartmentDetail->description !!}
        </div>
      </article>
    </div>

    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
        document.querySelectorAll(".attachment__caption").forEach(function (caption) {
            caption.remove();
        });
  
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
  
        // Carousel: staff
        const staffContainer = document.getElementById("staffCarousel");
        if (staffContainer && !staffContainer.dataset.initialized) {
          Carousel(staffContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay }).init();
          staffContainer.dataset.initialized = "true";
        }
  
        // Carousel: galleries
        const galleriesContainer = document.getElementById("galleriesCarousel");
        if (galleriesContainer && !galleriesContainer.dataset.initialized) {
          Carousel(galleriesContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay }).init();
          galleriesContainer.dataset.initialized = "true";
        }
  
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