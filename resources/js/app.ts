import "./bootstrap";
import "flowbite";
import { Datepicker } from "flowbite";
import Alpine from "alpinejs";
import editor from "./editor";
import slimSelect from "./slim-select";
import filepond from "./filepond";
import calendar from "./calendar";

window.Alpine = Alpine;
Alpine.data("editor", editor);
Alpine.data("slimSelect", slimSelect);
Alpine.data("filepond", filepond);
Alpine.data("calendar", calendar);

Alpine.start();

window.flowbiteDatePicker = Datepicker;

// Global event listeners
document.addEventListener("content-removed", (event) => {
    // @ts-ignore
    event.target?.classList.add("animate__animated", "animate__fadeOut");
  setTimeout(() => {
    // @ts-ignore
    event.target?.remove();
  }, 500);
});
