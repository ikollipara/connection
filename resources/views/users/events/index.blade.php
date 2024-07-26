<x-layout>
    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          headerToolbar: {
            left: 'dayGridMonth,timeGridWeek,listWeek',
            center: 'title'
          },
          editable: true,
          selectable: true,
          select: function(start){
          },
          eventClick: (info) => {
            if (info.event._def.extendedProps.was_created_by_user){
              window.location.href = route('users.events.edit', ['me', info.event.id]);
            }
            else{
              window.location.href = route('events.show', [info.event.id]);
            }
          },
          events: {{ Js::from($events->map(fn($event) => $event->toFullCalendar(auth()->user()))) }}
        });
        calendar.render();
      });
    
    </script>
    @endpush
    <x-hero class="is-primary">
        <h1 class="title">My Calendar</h1>
    </x-hero>

    <div id="calendar" style='margin-top: 20px' class="container"></div>
    
</x-layout>
