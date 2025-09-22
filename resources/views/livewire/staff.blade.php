<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
   {{-- @dd($head_master) --}}
    <!-- headmaster-->
    @if($head_master)
    <aside data-aos="fade-right" class="flex w-full flex-col lg:flex-row gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
      <div class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">Kepala <span class="text-blue-600 font-semibold">Sekolah</span></h2>
        <p class="lg:text-xl text-slate-800">Pemimpin utama yang menuntun SMKN 1 Kasreman menuju pendidikan yang berkualitas dan berkarakter.</p>
      </div>
      <div class="w-full lg:w-3/5 flex justify-center">
        <div class="flex flex-col w-1/2 sm:w-1/3 2xl:w-1/4">
          <figure data-fancybox="gallery" data-src="/storage/{{ $head_master->staff->photo }}" data-caption="{{ $head_master->staff->name }} | {{ $head_master->role }}" class="h-44 lg:h-64 w-full rounded-t-3xl lg:border-4 border-2 border-b-0 border-blue-600 bg-cover bg-center bg-no-repeat" style="background-image: url(/storage/{{ $head_master->staff->photo }})">
          </figure>
          <div class="w-full h-fit rounded-b-2xl bg-gradient-to-r from-blue-600 to-blue-700 px-2 py-1 text-center">
            <p class="text-slate-50 text-xs lg:text-sm h-[2lh]">{{ $head_master->staff->name }}</p>
            <p class="text-slate-50 text-2xs lg:text-xs italic h-[1lh]">{{ $head_master->role }}</p>
          </div>
        </div>
      </div>
    </aside>
    @endif
    <!-- headmaster-->
     
    <!-- vice-->
    @if($vice_masters)
    <aside data-aos="fade-right" class="flex w-full flex-col lg:flex-row-reverse gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
      <div class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">Wakil <br><span class="text-blue-600 font-semibold">Kepala Sekolah</span></h2>
        <p class="lg:text-xl text-slate-800">Mendampingi kepala sekolah dalam mewujudkan lingkungan belajar yang unggul dan harmonis.</p>
      </div>
      <div class="w-full lg:w-3/5 f-carousel " id="viceMastersCarousel">
        <div class="f-carousel__viewport rounded-2xl grid-cols-2 sm:grid-cols-3 2xl:grid-cols-4">
          @foreach($vice_masters as $vice_master )
              <livewire:components.card-staff wire:key="{{ $vice_master->id }}" :photo="$vice_master->staff->photo" :name="$vice_master->staff->name" :role="$vice_master->role" />
          @endforeach
        </div>
      </div>
    </aside>
    @endif
    <!-- vice-->
     
    <!-- head of major-->
    @if($head_of_majors)
    <aside data-aos="fade-right" class="flex w-full flex-col lg:flex-row gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
      <div class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">Kepala <br><span class="text-blue-600 font-semibold">Program Keahlian</span></h2>
        <p class="lg:text-xl text-slate-800">Pemimpin jurusan yang visioner, memastikan keahlian siswa berkembang sesuai bidangnya.</p>
      </div>
      <div class="w-full lg:w-3/5 f-carousel " id="headOfMajorsCarousel">
        <div class="f-carousel__viewport rounded-2xl grid-cols-2 sm:grid-cols-3 2xl:grid-cols-4">
          @foreach($head_of_majors as $head_of_major )
              <livewire:components.card-staff wire:key="{{ $head_of_major->id }}" :photo="$head_of_major->staff->photo" :name="$head_of_major->staff->name" :role="$head_of_major->role" />
          @endforeach
        </div>
      </div>
    </aside>
    @endif
    <!-- head of major-->

    <!-- teacher-->
    @if($teachers)
    <aside data-aos="fade-right" class="flex w-full flex-col lg:flex-row-reverse gap-4 items-center lg:justify-between rounded-2xl bg-white p-4 lg:py-6 lg:px-16">
      <div class="flex flex-col gap-2 lg:gap-4 w-full lg:w-1/3 text-center lg:text-start">
        <h2 class="text-2xl lg:text-5xl font-medium text-blue-600">Guru</span></h2>
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

        // viceMasters carousel
        const viceMastersContainer = document.getElementById("viceMastersCarousel");
        if (viceMastersContainer && !viceMastersContainer.dataset.initialized) {
          Carousel(viceMastersContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay }).init();
          viceMastersContainer.dataset.initialized = "true";
        }
        // viceMasters carousel

        // headOfMajors carousel
        const headOfMajorsContainer = document.getElementById("headOfMajorsCarousel");
        if (headOfMajorsContainer && !headOfMajorsContainer.dataset.initialized) {
          Carousel(headOfMajorsContainer, {
            infinite: true,
            Autoplay: { showProgressbar: false }
          }, { Arrows, Autoplay }).init();
          headOfMajorsContainer.dataset.initialized = "true";
        }
        // headOfMajors carousel

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