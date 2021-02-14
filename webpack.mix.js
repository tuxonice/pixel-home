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

mix.copy('resources/img/', 'public/img');
mix.copy('resources/js/init-alpine.js', 'public/js');
mix.copy('resources/js/charts-pie.js', 'public/js');
mix.copy('resources/js/charts-lines.js', 'public/js');
mix.copy('resources/js/charts-bars.js', 'public/js');
mix.copy('resources/js/focus-trap.js', 'public/js');
mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);
