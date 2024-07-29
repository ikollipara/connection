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
          editable: false,
          selectable: true,
          eventClick: (info) => {
            if (info.event._def.extendedProps.was_created_by_user) {
              window.location.href = route('users.events.edit', ['me', info.event.id]);
            } else {
              window.location.href = route('events.show', [info.event.id]);
            }
          },
          events: {{ Js::from($events->map(fn($event) => $event->toFullCalendar(auth()->user()))) }}
        });
        calendar.render();
      });
    </script>
  @endpush
  <main class="tw-grid tw-grid-cols-[1fr_0.25fr] tw-gap-2 tw-mx-3 tw-mt-2 tw-max-h-[50vh]">
    <div id="calendar"></div>
    <div class="tw-border-gray-300 tw-border tw-border-solid tw-rounded tw-p-3">
      <p class="content">
        @isset($user)
          This is your calendar for conneCTION. Click on an event to edit the event. Use the button below to download your
          calendar and import into your calendar app.
        @else
          This is the calendar for conneCTION. If you are interested in an event, click on it and
          choose to attend. Use one of the action buttons below to subscribe to the calendar.
        @endisset
      </p>
      <a class="button is-dark"
         href="{{ route('events.ical', 'me') }}">Download Calendar</a>
    </div>
  </main>
