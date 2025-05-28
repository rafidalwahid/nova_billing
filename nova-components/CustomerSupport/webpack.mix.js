let mix = require('laravel-mix')
let NovaExtension = require('laravel-nova-devtool')
let path = require('path')

mix.extend('nova', new NovaExtension())

mix
  .setPublicPath('dist')
  .js('resources/js/tool.js', 'js')
  .vue({ version: 3 })
  .postCss('resources/css/tool.css', 'css', [
    require('tailwindcss'),
    require('autoprefixer')
  ])
  .nova('billing/customer-support')
  .version()
  .options({
    processCssUrls: false
  })
  .webpackConfig({
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'resources/js'),
      },
    },
  })

// Development settings
if (mix.inProduction()) {
  mix.options({
    terser: {
      terserOptions: {
        compress: {
          drop_console: true,
        },
      },
    },
  })
} else {
  mix.sourceMaps()
}
