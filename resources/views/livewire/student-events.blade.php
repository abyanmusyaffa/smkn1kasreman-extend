<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <livewire:components.title-left text="Agenda" span="Siswa" />
    <!-- student events -->
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
      <livewire:components.paginate :onStudentEvents="true" />
    </article>
    {{-- <article class="grid lg:grid-cols-2 xl:grid-cols-3 w-full gap-4 lg:gap-6 items-center">
        @foreach($student_events as $student_event)
            <livewire:components.card-student-event wire:key="{{ $student_event->id }}" :id="$student_event->id" :name="$student_event->name" :photo="$student_event->photo" :description="$student_event->description" :start_date="$student_event->start_date" :end_date="$student_event->end_date" :start_time="$student_event->start_time" :end_time="$student_event->end_time" :location="$student_event->location" >
        @endforeach
    </article> --}}

    <livewire:components.modal-major >
    <!-- student events -->

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