const mix = require('laravel-mix')
require('vuetifyjs-mix-extension')
const LiveReloadPlugin = require('webpack-livereload-plugin')

var webpackConfig = {
    plugins: [
        // new VuetifyLoaderPlugin({
        //     options: {}
        // }),
        // new CaseSensitivePathsPlugin(),
        new LiveReloadPlugin(),
    ]
}

mix.webpackConfig( webpackConfig );

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

mix.js('resources/js/app.js', 'public/js').vuetify()
    .sass('resources/sass/app.scss', 'public/css')