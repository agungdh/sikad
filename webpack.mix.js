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

mix.js('resources/js/menu.js', 'compiled/js');
mix.js('resources/js/dosen.js', 'compiled/js');
mix.js('resources/js/matkul.js', 'compiled/js');
mix.js('resources/js/jadwal.js', 'compiled/js');

mix.version();
mix.disableNotifications();
mix.extract(['axios','lodash','vue','sweetalert2','vue-loading-overlay', '@deveodk/vue-toastr', 'vue-select']);