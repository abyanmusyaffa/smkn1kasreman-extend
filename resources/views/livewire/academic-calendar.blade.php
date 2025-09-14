{{-- @dd($student_regulation) --}}
<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-4 lg:gap-6 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-gradient-to-r from-slate-50 to-slate-100">
    <livewire:components.title-left text="Kalender" span="Akademik" />

    <article class="bg-white w-full p-4 flex flex-col gap-6 rounded-xl">
      <div id='calendar'></div>
    </article>
    @script
    <script>
      document.addEventListener("livewire:navigated", function () {
        let calendarEl = document.getElementById('calendar');
        let calendar = new Calendar(calendarEl, {
          plugins: [ dayGridPlugin, timeGridPlugin, listPlugin ],
          initialView: window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth',
          locale: 'id',
          locales: [idLocale],
          events: @json($events),
          eventDidMount: function(info) {
              if (info.event.extendedProps.description) {
                  info.el.setAttribute("title", info.event.extendedProps.description);
              }
          },
          headerToolbar: {
            left: window.innerWidth < 768 ? 'prev,next' : 'prev,next today',
            center: 'title',
            right: window.innerWidth < 768 ? '' : 'dayGridMonth,listWeek'
          }
        });
        calendar.render();
      });
    </script>
    @endscript
</div>