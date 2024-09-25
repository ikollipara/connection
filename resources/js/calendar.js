/**------------------------------------------------------------
 * calendar.js
 * Ian Kollipara
 *
 * Description: This file contains the JavaScript code for the
 * calendar page. It is responsible for rendering the calendar
 * and handling the user's interactions with it.
 *------------------------------------------------------------**/

import { Calendar } from "@fullcalendar/core";

export default ({ user = null }) => ({
  init() {
    Promise.allSettled([
      import("@fullcalendar/daygrid"),
      import("@fullcalendar/timegrid"),
      import("@fullcalendar/list"),
      import("@fullcalendar/icalendar"),
    ]).then(
      ([
        { default: dayGridPlugin },
        { default: timeGridPlugin },
        { default: listViewPlugin },
        { default: iCalPlugin },
      ]) => {
        this.calendar = new Calendar(this.$el, {
          plugins: [dayGridPlugin, timeGridPlugin, iCalPlugin, listViewPlugin],
          initialView: window.innerWidth > 768 ? "dayGridMonth" : "listWeek",
          headerToolbar:
            window.innerWidth > 768
              ? {
                  left: "prev,next today",
                  center: "title",
                  right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
                }
              : {
                  left: "prev",
                  center: "title",
                  right: "next",
                },
          height: "80dvh",
          editable: false,
          selectable: true,
          handleWindowResize: true,
          windowResize: ({ view }) => {
            if (window.innerWidth < 768) {
              view.calendar.changeView("listWeek");
              view.calendar.setOption("height", "auto");
              view.calendar.setOption("headerToolbar", {
                left: "prev",
                center: "title",
                right: "next",
              });
            } else {
              view.calendar.changeView("dayGridMonth");
              view.calendar.setOption("height", "80dvh");
              view.calendar.setOption("headerToolbar", {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
              });
            }
          },
          events: {
            format: "ics",
            url: route("events.ical", { user }),
          },
        });
        this.$nextTick(() => this.calendar.render());
      },
    );
  },
  destroy() {
    this.calendar.destroy();
  },
});
