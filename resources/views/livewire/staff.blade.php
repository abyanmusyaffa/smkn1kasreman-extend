<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-white">
  {{-- organizational structure --}}
  @foreach($organizational_structures as $organizational_structure)
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.title-center text="{{ $organizational_structure->name }}"/>
      <figcaption>
        <p class="text-center lg:text-xl text-slate-700 prose max-w-none">{{ $organizational_structure->description }}</p>
      </figcaption>
      <figure>
        <img class="w-full lg:w-auto lg:h-[512px]" src="storage/{{ $organizational_structure->photo }}" alt="">
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
    <aside data-aos="fade-up" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-center text="Guru" span="" />
      <div class="flex w-full lg:justify-between pb-1 gap-2 drag-to-scroll cursor-grab active:cursor-grabbing snap-x snap-mandatory overflow-x-scroll">
        @foreach($teachers as $teacher )
            <livewire:components.card-staff wire:key="{{ $teacher->id }}" :photo="$teacher->photo" :name="$teacher->name" :role="$teacher->role" />
        @endforeach
      </div>
    </aside>
    @endif
    <!-- teacher-->

    <!-- staff-->
    @if($staffMembers)
    <aside data-aos="fade-up" class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-center text="Tenaga Kependidikan" />
      <div class="flex w-full lg:justify-between pb-1 gap-2 drag-to-scroll cursor-grab active:cursor-grabbing snap-x snap-mandatory overflow-x-scroll">
        @foreach($staffMembers as $staff )
            <livewire:components.card-staff wire:key="{{ $staff->id }}" :photo="$staff->photo" :name="$staff->name" :role="$staff->role" />
        @endforeach
      </div>
    </aside>
    @endif
    <!-- staff-->

    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
        // drag to scroll alumni
        let mouseDown = false;
        let startX, scrollLeft;

        const sliders = document.querySelectorAll(".drag-to-scroll");

        const startDragging = (e, slider) => {
            mouseDown = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        };

        const stopDragging = () => {
            mouseDown = false;
        };

        const move = (e, slider) => {
            e.preventDefault();
            if (!mouseDown) {
                return;
            }
            const x = e.pageX - slider.offsetLeft;
            const scroll = x - startX;
            slider.scrollLeft = scrollLeft - scroll;
        };

        sliders.forEach((slider) => {
            if (slider) {
                slider.addEventListener("mousemove", (e) => move(e, slider), false);
                slider.addEventListener(
                    "mousedown",
                    (e) => startDragging(e, slider),
                    false
                );
                slider.addEventListener("mouseup", stopDragging, false);
                slider.addEventListener("mouseleave", stopDragging, false);
            }
        });
        // drag to scroll alumni
      });
    </script>
    @endscript
</div>