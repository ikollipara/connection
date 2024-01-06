const mix = require('laravel-mix');
require("laravel-mix-purgecss");
require("laravel-mix-compress");
require("laravel-mix-polyfill");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/scss/app.scss', 'public/css')
  .webpackConfig({
    resolve: {
      extensions: [".*",".wasm",".mjs",".js",".jsx",".json"]
    },
  })

if (mix.inProduction()) {
  mix.purgeCss()
  .polyfill()
  .compress({
    useBrotli: true,
  })
}
