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

// mix.postCss('src/styles.css', 'public/css/styles.css', [require('tailwindcss')]);

// mix.js('resources/js/app.js', 'public/js/scripts.js').extract(['axios', 'tom-select']);

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css/app.css', [require('tailwindcss')])
    .version();

// mix.ts('resources/js/tsx/brizy.tsx', 'public/js/tsx')
//     .react();

// mix.copyDirectory('modules/Web/Resources/Assets', 'public/vvveb').version();

/**
 * Material design icons
 */
mix.copy('node_modules/boxicons/fonts', 'public/vendor/boxicons/fonts');
mix.copy('node_modules/boxicons/css', 'public/vendor/boxicons/css');
