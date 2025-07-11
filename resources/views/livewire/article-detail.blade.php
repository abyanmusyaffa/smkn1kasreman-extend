{{-- @dd($articles) --}}
<div class="w-full flex flex-col lg:flex-row gap-6 lg:gap-8 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-slate-100">
    <article class="flex flex-col gap-4 w-full lg:w-2/3">
        <header class="flex flex-col gap-2 items-center">
            {{-- <a href="{{ url()->previous() }}" class="flex gap-1 lg:gap-2 items-center self-start">
                <span class="icon-[mdi--arrow-left]"></span>
                <p class="text-lg lg:text-xl font-medium">Kembali</p>
            </a> --}}
            <h2 class="font-semibold text-xl lg:text-4xl text-slate-700 text-center">{{ $articleDetail->title }}</h2>
            <div class="flex gap-2 items-center">
                <span class="text-sm lg:text-lg
                    @if($articleDetail->deadline) 
                        @if(\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($articleDetail->deadline)))
                            icon-[mdi--close-circle-outline] text-red-800
                        @else
                            icon-[mdi--clock-outline] text-blue-800
                        @endif
                    @else
                        icon-[mdi--calendar-badge] text-slate-600
                    @endif
                "></span>
                <p class="text-sm lg:text-lg whitespace-nowrap
                    @if($articleDetail->deadline) 
                        @if(\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($articleDetail->deadline)))
                            text-red-800
                        @else
                            text-blue-800
                        @endif
                    @else
                        text-slate-600
                    @endif
                ">
                    @if($articleDetail->deadline) 
                        @if(\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($articleDetail->deadline)))
                            Lowongan Ditutup
                        @else
                            {{ \Carbon\Carbon::parse($articleDetail->deadline)->diffForHumans() }}
                        @endif
                    @else
                        {{ \Carbon\Carbon::parse($articleDetail->created_at)->translatedFormat('j F Y H:i') }}
                    @endif
                    {{-- {{ $articleDetail->deadline ? \Carbon\Carbon::parse($articleDetail->deadline)->diffForHumans() : \Carbon\Carbon::parse($articleDetail->created_at)->translatedFormat('j F Y') }} --}}
                </p>
            </div>
            @if($articleDetail->deadline)
            <p class="text-xs lg:text-base italic text-slate-500">Lowongan ditutup {{ \Carbon\Carbon::parse($articleDetail->deadline)->translatedFormat('j F Y H:i') }} </p>
            @endif
            <img data-fancybox src="/storage/{{ $articleDetail->photo }}" class="w-5/6 lg:w-auto lg:h-80" alt="">
        </header>
        <div class="flex bg-white rounded-2xl p-4 lg:p-6">
            <div id="rich-content" class="prose lg:prose-figure:w-2/3 w-full max-w-none">
               {!! $articleDetail->content !!}
            </div>
        </div>
        <footer class="flex gap-2">
            @if($articleDetail->tags)
                <p class="text-slate-600  lg:text-lg ">Tag: </p>
                <div class="flex gap-2">
                        @foreach( $articleDetail->tags as $tag )
                            <p class="text-blue-600 text-sm lg:text-base outline-1 outline whitespace-nowrap outline-blue-600 py-[1px] lg:py-0.5 px-1 lg:px-2 rounded-lg">{{ $tag }}</p>
                        @endforeach
                </div>
            @elseif($articleDetail->industry)
                <p class="text-slate-600  lg:text-lg ">Bidang Industri: </p>
                <div class="flex gap-2">
                        @foreach( $articleDetail->industry as $item )
                            <p class="text-blue-600 text-sm lg:text-base outline-1 outline whitespace-nowrap outline-blue-600 py-[1px] lg:py-0.5 px-1 lg:px-2 rounded-lg">{{ $item }}</p>
                        @endforeach
                </div>
            @endif
        </footer>
    </article>
    <livewire:components.aside-article :articles="$articles" :achievements="$achievements" :jobfairs="$jobfairs" />

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
      });
    </script>
    @endscript
</div>
