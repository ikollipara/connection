require("./bootstrap");

import Alpine from "alpinejs";
import editor from "./editor";
import slimSelect from "./slim-select";
import filepond from "./filepond";

window.Alpine = Alpine;
Alpine.data("editor", editor);
Alpine.data("slimSelect", slimSelect);
Alpine.data("filepond", filepond);

Alpine.start();

// Global event listeners
document.addEventListener("content-removed", (event) => {
  event.target.classList.add("animate__animated", "animate__fadeOut");
  setTimeout(() => {
    event.target.remove();
  }, 500);
});
