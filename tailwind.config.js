/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
  theme: {
    extend: {},
  },
  plugins: [require("@tailwindcss/typography")],
  prefix: "tw-",
  corePlugins: {
    preflight: false,
  },
  important: true,
};
