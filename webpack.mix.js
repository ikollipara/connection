const mix = require("laravel-mix");
require("laravel-mix-compress");
require("laravel-mix-imagemin");
require("laravel-mix-polyfill");
const nanocss = require("cssnano");
const pruneVar = require("postcss-prune-var");
const varCompress = require("postcss-variable-compress");
const purgeCssLaravel = require("postcss-purgecss-laravel");
const autoprefixer = require("autoprefixer");
const tailwindcss = require("tailwindcss");
const BundleAnalyzerPlugin =
  require("webpack-bundle-analyzer").BundleAnalyzerPlugin;

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
  .js("resources/js/app.js", "public/js")
  .css("resources/css/slim-select.css", "public/css/slim-select.css")
  .css("resources/css/animate.css", "public/css/animate.css")
  .sass("resources/scss/app.scss", "public/css/app.css", {}, [
    autoprefixer,
    tailwindcss,
    purgeCssLaravel({
      safelist: [/ss-*/],
    }),
    nanocss({
      preset: [
        "default",
        {
          discardComments: { removeAll: true },
          normalizeWhitespace: true,
        },
      ],
    }),
    pruneVar(),
    varCompress(),
  ])
  .webpackConfig((webpack) => {
    return {
      resolve: {
        extensions: [".*", ".wasm", ".mjs", ".js", ".jsx", ".json", ".css"],
      },
      plugins: [
        // new BundleAnalyzerPlugin(),
      ],
    };
  });

if (mix.inProduction()) {
  mix.version().compress({
    minRatio: 1,
  });
}
