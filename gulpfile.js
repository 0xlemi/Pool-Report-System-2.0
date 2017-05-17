process.env.DISABLE_NOTIFIER = true;
var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less', 'public/css/less.css')
    	.styles([
    		'bootstrap-table.css',
            'font-awesome.min.css',
    		'dropzone.css',
            'bootstrap-fileupload.css',
            'bootstrap-toggle.css',
            'bootstrap-clockpicker.css',
            'sweetalert.css',
        	'custom.css'
    	], 'public/css/main.css')
    	.browserify([
            'bootstrap-table.js',
            'bootstrap-fileupload.js',
            'bootstrap-clockpicker.js',
            'bootstrap-maxlenght.js',
            'bootstrap.js',
            'main.js'
        ])
        // Documentation Styles
        .sass([
            'theDocs/theDocs.scss',
            'theDocs/custom.css'
        ], 'public/css/docs.css')
    	.browserify(['libs/theDocs/theDocs.all.min.js', 'libs/theDocs/custom.js'], 'public/js/docs.js')
    	.version(['css/less.css', 'css/main.css', 'js/bundle.js', 'css/docs.css', 'js/docs.js']);
});
