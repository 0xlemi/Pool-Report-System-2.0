var elixir = require('laravel-elixir');

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
    mix.sass('app.scss', 'public/css/sass.css')
    	.less('app.less', 'public/css/less.css')
    	.styles([
    		'bootstrap-table.css',
    		'dropzone.css',
        	'app.css',
            'sweetalert.css',
        	'custom.css'
    	], 'public/css/main.css')
    	.browserify(['bootstrap-table.js', 'main.js'])
    	.version(['css/sass.css', 'css/less.css', 'css/main.css', 'js/bundle.js']);
});
