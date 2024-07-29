import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel([
      "resources/js/app.js",
      "resources/css/slim-select.css",
      "resources/css/animate.css",
      "resources/scss/app.scss",
    ]),
  ],
});
