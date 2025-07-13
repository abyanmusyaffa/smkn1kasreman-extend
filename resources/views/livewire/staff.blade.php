<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
  {{-- organizational structure --}}
  @foreach($organizational_structures as $organizational_structure)
    {{-- <aside data-aos="fade-right" class="flex w-full flex-col lg:flex-row{{ $index === 0 ? '-reverse' : '' }}  gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
      <figcaption class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">{{ $organizational_structure->name }}</h2>
        <p class="lg:text-xl text-slate-800">{{ $organizational_structure->description }}</p>
      </figcaption>
      <figure class="w-full lg:w-3/5">
        <img class="w-full lg:h-auto" data-fancybox src="storage/{{ $organizational_structure->photo }}" alt="">
      </figure>
    </aside> --}}
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-center text="{{ $organizational_structure->name }}"/>
      <figcaption>
        <p class="text-center lg:text-xl text-slate-700 prose max-w-none">{{ $organizational_structure->description }}</p>
      </figcaption>
      <figure class="p-4 lg:p-6 bg-white rounded-lg lg:rounded-xl shadow-md">
        <img data-fancybox class="w-full lg:w-auto lg:h-[512px]" src="storage/{{ $organizational_structure->photo }}" alt="">
      </figure>
    </article>
  @endforeach
  {{-- organizational structure --}}    
  
    <!-- headmaster-->
    {{-- @if($headMaster->count() > 0)
      <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
          <livewire:components.title-left text="Kepala" span="Sekolah" />
        <div class="flex w-full justify-center">
          <livewire:components.card-staff :photo="$headMaster->photo" :name="$headMaster->name" :role="$headMaster->role" />
        </div>
      </article>
    @endif --}}
    <!-- headmaster-->
     
    <!-- vice-->
    {{-- @if($viceMasters)
    <aside data-aos="fade-up" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-right text="Wakil Kepala" span="Sekolah" />
      <div class="flex w-full lg:justify-between pb-1 gap-2 drag-to-scroll cursor-grab active:cursor-grabbing snap-x snap-mandatory overflow-x-scroll">
        @foreach($viceMasters as $viceMaster )
            <livewire:components.card-staff wire:key="{{ $viceMaster->id }}" :photo="$viceMaster->photo" :name="$viceMaster->name" :role="$viceMaster->role" />
        @endforeach
      </div>
    </aside>
    @endif --}}
    <!-- vice-->
     
    <!-- head of major-->
    {{-- @if($headsOfMajor)
    <aside data-aos="fade-up" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-left text="Kakomli" span="" />
      <div class="flex w-full lg:justify-between pb-1 gap-2 drag-to-scroll cursor-grab active:cursor-grabbing snap-x snap-mandatory overflow-x-scroll">
        @foreach($headsOfMajor as $headOfMajor )
            <livewire:components.card-staff wire:key="{{ $headOfMajor->id }}" :photo="$headOfMajor->photo" :name="$headOfMajor->name" :role="$headOfMajor->role" />
        @endforeach
      </div>
    </aside>
    @endif --}}
    <!-- head of major-->

    <!-- teacher-->
    @if($teachers)
    <aside data-aos="fade-right" class="flex w-full flex-col lg:flex-row-reverse gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
      <div class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">Daftar <span class="text-blue-600 font-semibold">Guru</span></h2>
        <p class="lg:text-xl text-slate-800">Guru-guru terbaik yang berdedikasi untuk pendidikan dan karakter siswa.</p>
      </div>
      <div class="w-full lg:w-3/5 f-carousel " id="teachersCarousel">
        <div class="f-carousel__viewport rounded-2xl grid-cols-2 sm:grid-cols-3 2xl:grid-cols-4">
          @foreach($teachers as $teacher )
              <livewire:components.card-staff wire:key="{{ $teacher->id }}" :photo="$teacher->photo" :name="$teacher->name" :role="$teacher->role" />
          @endforeach
        </div>
      </div>
    </aside>
    {{-- <aside data-aos="fade-up" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-center text="Guru" span="" />
      <div class="flex w-full lg:justify-between pb-1 gap-2 drag-to-scroll cursor-grab active:cursor-grabbing snap-x snap-mandatory overflow-x-scroll">
      </div>
    </aside> --}}
    @endif
    <!-- teacher-->

    <!-- staff-->
    @if($staff_members)
    <aside data-aos="fade-right" class="flex w-full flex-col lg:flex-row gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
      <div class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">Tenaga <br class="lg:hidden"><span class="text-blue-600 font-semibold">Kependidikan</span></h2>
        <p class="lg:text-xl text-slate-800">Tenaga kependidikan SMKN 1 Kasreman yang mendukung kelancaran operasional dan layanan administrasi sekolah.</p>
      </div>
      <div class="w-full lg:w-3/5 f-carousel " id="staffCarousel">
        <div class="f-carousel__viewport rounded-2xl grid-cols-2 sm:grid-cols-3 2xl:grid-cols-4">
          @foreach($staff_members as $staff )
            <livewire:components.card-staff wire:key="{{ $staff->id }}" :photo="$staff->photo" :name="$staff->name" :role="$staff->role" />
          @endforeach
        </div>
      </div>
    </aside>
    {{-- <aside data-aos="fade-up" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-center text="Tenaga Kependidikan" />
      <div class="flex w-full lg:justify-between pb-1 gap-2 drag-to-scroll cursor-grab active:cursor-grabbing snap-x snap-mandatory overflow-x-scroll">
        @foreach($staff_members as $staff )
            <livewire:components.card-staff wire:key="{{ $staff->id }}" :photo="$staff->photo" :name="$staff->name" :role="$staff->role" />
        @endforeach
      </div>
    </aside> --}}
    @endif
    <!-- staff-->

    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
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

        // teachers carousel
        const teachersContainer = document.getElementById("teachersCarousel");
        if (teachersContainer && !teachersContainer.dataset.initialized) {
          Carousel(teachersContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay }).init();
          teachersContainer.dataset.initialized = "true";
        }
        // teachers carousel

        // staff carousel
        const staffContainer = document.getElementById("staffCarousel");
        if (staffContainer && !staffContainer.dataset.initialized) {
          Carousel(staffContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay }).init();
          staffContainer.dataset.initialized = "true";
        }
        // staff carousel
      });
    </script>
    @endscript
</div>