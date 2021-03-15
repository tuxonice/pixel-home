const mix = require('laravel-mix');

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

 /*
mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);
*/

mix.copy([
    'resources/plugins/fontawesome-free/css/all.min.css',
    'resources/css/adminlte.min.css',
    'resources/css/custom.css',
    'resources/css/daterangepicker.css'
], 'public/css');

mix.copy([
    'resources/plugins/jquery/jquery.min.js',
    'resources/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/js/adminlte.min.js',
    'resources/js/daterangepicker.js',
    'resources/js/moment.min.js',
], 'public/js');

mix.copyDirectory('resources/plugins/fontawesome-free/webfonts', 'public/webfonts');
mix.copyDirectory('resources/img', 'public/img');