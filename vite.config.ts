import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import compression from "vite-plugin-compression2";
import tailwind from "@tailwindcss/vite";
import elm from "vite-plugin-elm";

export default defineConfig({
  plugins: [
    tailwind(),
    elm(),
    laravel([
      "resources/js/app.js",
      "resources/css/app.css",
    ]),
    compression({
      algorithm: "brotliCompress",
      filename: "[path][base].br",
    }),
  ],
});
