{{-- @dd($student_regulation) --}}
<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <livewire:components.title-left text="Kalender" span="Akademik" />

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