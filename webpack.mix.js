const mix = require('laravel-mix');
const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer');
require("laravel-mix-purgecss");
require("laravel-mix-compress");
require("laravel-mix-imagemin");
require("laravel-mix-polyfill");
const BundleAnalyer = require("webpack-bundle-analyzer").BundleAnalyzerPlugin;

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
  .css('resources/css/app.css', 'public/css')
  .webpackConfig(webpack => {
    return {
      resolve: {
        extensions: [".*",".wasm",".mjs",".js",".jsx",".json", ".css"]
      },
      plugins: [
        // new BundleAnalyzerPlugin(),
      ]
    }
  })
  .imagemin("images/*", { context: "resources" })


if (mix.inProduction()) {
  mix
  .polyfill()
  .version()
  .purgeCss({
  safelist: [/ss-*/],
  })
}
