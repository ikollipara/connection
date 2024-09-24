import typography from "@tailwindcss/typography";
import flowbite from "flowbite/plugin";
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.{css,js}",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {},
  plugins: [typography, flowbite],
  corePlugins: {
    preflight: true,
  },
};
