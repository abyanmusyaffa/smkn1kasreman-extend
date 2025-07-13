<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
  <livewire:components.title-left text="Program" span="Keahlian" />
  <!-- major -->
  <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
    @foreach($majors as $index => $major)
      <livewire:components.card-major wire:key="{{ $major->id }}" :logo="$major->logo" :galleries="$major->galleries" :alias="$major->alias" :expertise_concentration="$major->expertise_concentration" :description="$major->description" :studyGroup="$major->study_group" :studyPeriod="$major->study_period" :totalStudents="$major->total_students" :index="$index" />
    @endforeach
  </article>

  <livewire:components.modal-major />
  <!-- major -->

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
      });
    </script>
    @endscript
  </div>