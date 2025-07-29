<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <aside class="w-full flex flex-col lg:flex-row lg:justify-between items-center bg-white rounded-2xl p-4 lg:px-32 lg:py-6 gap-4">
        <figcaption class="flex flex-col gap-2 lg:gap-4 items-center lg:items-start">
            <h2 class="font-semibold text-slate-800 text-2xl lg:text-4xl text-center lg:text-start">{{ $businessUnitDetail->name }}</h2>
            <div class="w-fit flex gap-2">
                @foreach($businessUnitDetail->contacts as $contact)
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
        </figcaption>
        <figure class="grid w-full lg:w-1/3 grid-cols-2 grid-rows-2 gap-2">
            <div class="grid place-items-center w-full aspect-square rounded-2xl bg-blue-600">
                <img data-fancybox src="/storage/{{ $businessUnitDetail->logo }}" class="w-28 lg:32 xl:w-36" alt="">
            </div>
            @foreach(array_slice($businessUnitDetail->galleries, 0, 2) as $index => $item)
                <div data-fancybox data-src="/storage/{{ $item }}" style="background-image: url(/storage/{{ $item }});" class="bg-no-repeat bg-center bg-cover w-full {{ $loop->first ? ('aspect-square ' . ($index % 2 !== 0 ? 'lg:order-first' : '')) : 'col-span-2' }} rounded-2xl"></div>
            @endforeach
        </figure>
    </aside>
    <article class="w-full flex flex-col bg-white rounded-2xl p-4 lg:px-32 lg:py-6 ">
        <div id="rich-content" class="prose lg:prose-figure:w-2/3 lg:prose-figure:mx-auto w-full max-w-none">
            {!! $businessUnitDetail->description !!}
        </div>
    </article>
    <article class="w-full flex flex-col lg:flex-row lg:justify-between items-center bg-white rounded-2xl p-4 lg:px-32 lg:py-6 gap-6">
        <figure class="grid grid-cols-2 gap-1 w-full lg:w-1/3">
            @foreach(array_slice($businessUnitDetail->galleries, 2, 4) as $index => $item)
                <div data-fancybox="gallery" data-src="/storage/{{ $item }}" @class([
                    'bg-no-repeat bg-cover bg-center w-full aspect-square',
                    'rounded-ss-[50%] rounded-ee-[50%]' => $index === 0 || $index === 3,
                    'rounded-es-[50%] rounded-se-[50%]' => $index === 1 || $index === 2,
                ]) style="background-image: url('/storage/{{ $item }}')"></div>
            @endforeach
        </figure>
        <figcaption class="flex flex-col items-center w-full lg:w-2/5 gap-3 lg:gap-4">
            <div class="flex items-center gap-2 text-blue-800 text-xl lg:text-3xl">
                <span class="icon-[mingcute--service-fill]"></span>
                <h3 class="font-semibold">Layanan</h3>
            </div>
            <div class="w-full h-40 lg:h-56 xl:h-64 gap-2 f-carousel" id="servicesCarousel">
                <div class="f-carousel__viewport grid-rows-4 lg:grid-rows-4 xl:grid-rows-5">
                    @foreach($businessUnitDetail->services as $index => $item)
                    <div class="flex gap-2 items-center f-carousel__slide">
                        <div class="size-8 lg:size-10 shrink-0 bg-blue-800 rounded-full flex justify-center items-center">
                            <p class="font-semibold lg:text-lg text-slate-50 ">{{ $index+1 }}</p>
                        </div>
                        <p class="text-blue-800 font-medium lg:text-lg whitespace-nowrap">{{ $item['name'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </figcaption>
    </article>
    @if($businessUnitDetail->products)
    <article class="w-full flex flex-col bg-white rounded-2xl p-4 lg:px-32 lg:py-6 gap-4 items-center">
        <div class="flex items-center gap-2 text-blue-800 text-xl lg:text-3xl">
            <span class="icon-[mingcute--shopping-cart-2-line]"></span>
            <h3 class="font-semibold">Produk</h3>
        </div>
        <div class="w-full f-carousel" id="productsCarousel">
            <div class="f-carousel__viewport grid-cols-2 lg:grid-cols-6">
                @foreach($businessUnitDetail->products as $item)
                <div class="f-carousel__slide w-full flex justify-center items-center">
                    <div class="flex w-[96%] h-[98%] flex-col gap-2 items-center rounded-xl p-2 border border-blue-100">
                        <div class="w-full aspect-square bg-no-repeat bg-cover bg-center rounded-lg" style="background-image: url('/storage/{{ $item['photo'] }}')"></div>
                        <p class="text-sm text-center lg:text-lg text-slate-700 h-[2lh] line-clamp-2">{{ $item['name'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </article>
    @endif

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
  
        // Carousel: services
        const servicesContainer = document.getElementById("servicesCarousel");
        if (servicesContainer && !servicesContainer.dataset.initialized) {
          Carousel(servicesContainer, {
            vertical: true,
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Autoplay }).init();
          servicesContainer.dataset.initialized = "true";
        }

        // Carousel: products
        const productsContainer = document.getElementById("productsCarousel");
        if (productsContainer && !productsContainer.dataset.initialized) {
          Carousel(productsContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Autoplay }).init();
          productsContainer.dataset.initialized = "true";
        }
      });
    </script>
    @endscript
</div>