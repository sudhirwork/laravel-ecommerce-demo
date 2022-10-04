const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const glob = require('glob')

function mixAssetsDir(query, cb) {
  ;(glob.sync('resources/' + query) || []).forEach(f => {
    f = f.replace(/[\\\/]+/g, '/')
    cb(f, f.replace('resources', 'public'))
  })
}


mixAssetsDir('js/store/*.js', (src, dest) => mix.scripts(src, dest))
mixAssetsDir('css/store/*.css', (src, dest) => mix.copy(src, dest))
mix.copyDirectory('resources/images', 'public/images')


mix.js('resources/js/app.js', 'public/js')
    // .js('node_modules/jquery/dist/jquery.min.js', 'public/js')
    // .js('resources/js/jquery.js', 'public/js')
    .js('resources/js/scripts.js', 'public/js')
    .js('resources/js/pnotify.min.js', 'public/js')
    // .js('resources/js/select2.full.min.js', 'public/js')
    .js('resources/js/clipboard.min.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/custom.scss', 'public/css')
    .sass('resources/sass/login.scss', 'public/css')
    .sass('resources/sass/pnotify.scss', 'public/css')
    .sass('resources/sass/select2.scss', 'public/css')
    .sass('resources/sass/quill.snow.scss', 'public/css')
    .sourceMaps();
