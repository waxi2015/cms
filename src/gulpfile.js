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
	mix.copy('node_modules/font-awesome', 'public/libs/font-awesome');
	mix.copy('resources/assets/admin/svg', 'public/svg/admin');
	mix.copy('resources/assets/admin/favicon', 'public/favicon/admin');
	mix.copy('resources/assets/admin/images', 'public/images/admin');

	// Repeater js 

	mix.scripts([
		'../libs/repeater/js/jquery.wax.repeater.js'
	], 'public/js/repeater.js')

	// Form js

	mix.scripts([
		'../libs/form/js/form.js',
		'../libs/form/js/jquery.waxis.form.js',
		'../libs/form/js/jquery.waxis.counter.js',
		'../libs/form/libs/form-validation-io/js/formValidation.popular.min.js',
		'../libs/form/libs/form-validation-io/js/framework/bootstrap.min.js',
		'../libs/form/libs/bootstrap-select/js/bootstrap-select.min.js',
		'../libs/form/libs/bootstrap-switch/bootstrap-switch.min.js',
		'../libs/form/libs/bootstrap-slider/bootstrap-slider.js',
		'../libs/form/libs/typeahead/bloodhound.min.js',
		'../libs/form/libs/typeahead/typeahead.jquery.min.js',
		'../libs/form/libs/handlebars/handlebars-v3.0.3.js',
		'../libs/form/libs/dropzone/dropzone.js',
		'../libs/form/libs/serialize-object/jquery.serialize-object.min.js',
		'../libs/form/libs/fancybox/jquery.fancybox.js',
	], 'public/js/form.js');

	// Admin js 

	mix.scripts([
		'../admin/libs/pace/pace.min.js',
		'../admin/libs/toastr/toastr.min.js',
		'../admin/libs/perfect-scrollbar/js/min/perfect-scrollbar.jquery.min.js',
		'../admin/libs/side-bar/js/classie.js',
		'../admin/libs/side-bar/js/sidebar-effects.js',
		'../admin/libs/metis-menu/jquery.metisMenu.js',
		'../admin/js/cms.js',
	], 'public/js/admin/cms.js');

	// Form styles 

	mix.sass([
		'../libs/form/sass/form.scss',
	], 'resources/assets/libs/form/css/form.css');

	mix.styles([
		'../libs/form/libs/dropzone/dropzone.css',
		'../libs/form/libs/typeahead/typeahead.css',
		'../libs/form/libs/bootstrap-slider/bootstrap-slider.css',
		'../libs/form/libs/bootstrap-switch/bootstrap-switch.css',
		'../libs/form/libs/bootstrap-select/css/bootstrap-select.css',
		'../libs/form/libs/form-validation-io/css/formValidation.css',
		'../libs/form/libs/fancybox/jquery.fancybox.css',
		'../libs/form/css/form.css',
	], 'public/css/form.css');

	// Admin styles 

    mix.sass([
    	'../admin/sass/theme.scss'
    ], 'resources/assets/admin/css/theme.css');

    mix.styles([
    	'../admin/libs/pace/pace.css',
    	'../admin/libs/toastr/toastr.css',
    	'../admin/libs/perfect-scrollbar/css/perfect-scrollbar.css',
    	'../admin/libs/metis-menu/metisMenu.css',
    	'../admin/libs/side-bar/css/sidebar.css',
    	'../admin/css/theme.css'
    ], 'public/css/admin/theme.css');

    // App styles 

    mix.sass([
    	'theme.scss'
    ], 'public/css/theme.css');

    // Editor styles 

    mix.sass([
    	'editor/content.scss'
    ], 'public/css/editor/content.css');

	mix.scripts([
		'../../../node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js'
	], 'public/libs/bootstrap/bootstrap.min.js')
});
