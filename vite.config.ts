import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import compression from "vite-plugin-compression2";
import elm from "vite-plugin-elm";

export default defineConfig({
  plugins: [
    elm(),
    laravel([
      "resources/js/app.ts",
      "resources/css/app.css",
      "resources/css/slim-select.css",
      "resources/css/animate.css",
    ]),
    compression({
      algorithm: "brotliCompress",
      filename: "[path][base].br",
    }),
  ],
});
