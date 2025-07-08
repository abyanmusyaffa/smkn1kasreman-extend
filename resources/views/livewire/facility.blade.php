<div class="w-full overflow-hidden lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    {{-- map --}}
    @if($schoolMap)
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-left text="Denah" span="Sekolah" />
      <figure class="p-4 lg:p-6 bg-white rounded-lg lg:rounded-xl shadow-md flex justify-center lg:w-fit">
        <img data-fancybox src="/storage/{{ $schoolMap }}" alt="Denah SMKN 1 Kasreman" class="w-full lg:w-auto lg:h-[512px]">
      </figure>
    </article>
    @endif
    {{-- map --}}
  
    <!--infra-->
    @if($infraFacilities->count() !== 0)
    <aside data-aos="fade-up" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-right text="Sarana" span="Infrastruktur" />
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 w-full">
        @foreach($infraFacilities as $infraFacility)
            <livewire:components.card-facility wire:key="{{ $infraFacility->id }}" :name="$infraFacility->name" :photo="$infraFacility->photo" />
        @endforeach
      </div>
    </aside>
    @endif
    <!-- infra -->

    <!-- learn -->
    @if($learnFacilities->count() !== 0)
    <aside data-aos="fade-up" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-left text="Sarana" span="Pembelajaran" />
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 w-full">
        @foreach($learnFacilities as $learnFacility)
            <livewire:components.card-facility wire:key="{{ $learnFacility->id }}" :name="$learnFacility->name" :photo="$learnFacility->photo" />
        @endforeach
      </div>
    </aside>
    @endif
    <!-- learn -->

    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
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