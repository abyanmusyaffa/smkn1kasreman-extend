{{-- @dd($labWorkshops) --}}
<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-8 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    {{-- lab --}}
    @if($labWorkshops->where('type', 'lab')->isNotEmpty())
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-left text="Lab" />
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 w-full">
        @foreach($labWorkshops->where('type', 'lab') as $labWorkshop)
          <livewire:components.card-lab-workshop wire:key="{{ $labWorkshop->id }}" :photo="$labWorkshop->photo" :name="$labWorkshop->name" :description="$labWorkshop->description" :code="$labWorkshop->code" />
        @endforeach
      </div>
    </article>
    @endif
    {{-- lab --}}
  
    <!--workshop-->
    @if($labWorkshops->where('type', 'workshop')->isNotEmpty())
    <aside data-aos="fade-up" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-right text="Bengkel" />
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 w-full">
        @foreach($labWorkshops->where('type', 'workshop') as $labWorkshop)
            <livewire:components.card-lab-workshop wire:key="{{ $labWorkshop->id }}" :photo="$labWorkshop->photo" :name="$labWorkshop->name" :description="$labWorkshop->description" :code="$labWorkshop->code" />
        @endforeach
      </div>
    </aside>
    @endif
    <!-- workshop -->
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
      });
    </script>
    @endscript
</div>