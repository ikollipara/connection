//------------------------------
// File:        app.ts
// Author:      Ian Kollipara
// Created:     2025-09-30
// Description: Main Entrypoint for the application
//------------------------------

import { Application } from "@hotwired/stimulus";

window.Stimulus = Application.start();


document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll("[data-select]").forEach((el) => {
    import("slim-select").then(({ default: SlimSelect }) => {
      const openPosition = el.getAttribute("data-select-open-position") ?? "auto";
      new SlimSelect({
        select: el,
        settings: {
          openPosition
        }
      })
    })
  })
});
