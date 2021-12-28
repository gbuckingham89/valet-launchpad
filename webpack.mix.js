const del = require('del');
const cssImport = require('postcss-import')
const cssNested = require('postcss-nested')
const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

/*----------------------------------------------*
 *------------------- SETUP --------------------*
 *----------------------------------------------*/
if(mix.inProduction()) {
    console.log('# Deleting build directories');
    del([
        './public/assets/build/',
    ]);
}

console.log('# Building assets');

if(!mix.inProduction()) {
    mix.sourceMaps();
}

mix.version();

/*--------------------------------------------*
 *------------------- APP --------------------*
 *--------------------------------------------*/
mix.js('resources/js/app.js', 'assets/build/app.js');
mix.postCss('resources/css/_app.css', 'assets/build/app.css', [
    cssImport(),
    cssNested(),
    tailwindcss('./tailwind.config.js'),
]);
