import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import compression from "vite-plugin-compression2";

export default defineConfig({
  plugins: [
    laravel([
      "resources/js/app.js",
      "resources/css/slim-select.css",
      "resources/css/animate.css",
      "resources/scss/app.scss",
    ]),
    compression({
      algorithm: "brotliCompress",
      filename: "[path][base].br",
    }),
  ],
});
