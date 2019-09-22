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

	// copy tinymce
	mix.copy(
            'resources/assets/js/tinymce',
            'public/assets/js/tinymce'
        );

	mix.styles(
	[
	    'bootstrap.min.css',
	    'font-awesome.min.css',
	    'animate.min.css',
	    'app.css',
	    'app.skins.css',
	    'angular-block-ui.css',
	    'sweetalert.css',
	    'ng-tags-input.min.css',
	    'ng-tags-input.bootstrap.min.css',
	    'owl.carousel.min.css',
	    'owl.theme.default.min.css',
	    'jquery.fancybox.min.css',
	    'jquery.auto-complete.css'
	], 'public/assets/css/app.css')

	// .version('public/assets/css/app.css');

	mix.styles(
	[
		'rtl/bootstrap.min.css',
		'rtl/app.css',
		'rtl/app.skins.css',

	], 'public/assets/css/rtl/app.css')



	mix.less(
		[
	    'common.less'
	], 'public/assets/css/common.css');


	mix.less(
		[
	    'common-rtl.less'
	], 'public/assets/css/rtl/common.css');
});


elixir(function(mix) {

	mix.scripts(
	[
	    'angular/tinymce.min.js',
	], 'public/assets/js/angular-tinymce.js')
	    
	// app.js
	mix.scripts(
	[
	    'jquery.min.js',
	    'tether.min.js',
	    'bootstrap.min.js',
	    'fastclick.js',
	    'underscore-min.js',
	    'sweetalert.min.js',
	    'chosen.min.js',
	    'jquery.auto-complete.min.js',
	    'jquery.ratings.js',
	    'readMoreFade.js',
	    'bootstrap-editable.min.js',
	    'angular/angular.min.js',
	    'angular/angular-route.min.js',
	    'angular/angular-animate.min.js',
	    'angular/angular-sanitize.min.js',
	    'angular/angular-chosen.min.js',
	    'angular/ng-tags-input.min.js',
	    'angular/ui-bootstrap-tpls-2.5.0.min.js',
	    'angular/angular-block-ui.min.js',
	    'angular/angular-addthis.min.js',
	    'owl.carousel.min.js',
	    'jquery.fancybox.min.js',
	    'main.js',
	], 'public/assets/js/app.js')
	
	// .version('public/assets/js/app.js');

	// helper.js
	mix.coffee([
	    'common/base.coffee'
	], 'public/assets/js/helper.js');


	// angular-modules.js
	mix.coffee([
	    'common/modules/*.coffee'
	], 'public/assets/js/angular-modules.js');


	// backendApp
	mix.coffee([
	    'backend/backendApp.coffee'
	], 'public/assets/js/backend/app.js');


	// Category
	mix.coffee([
	    'backend/category/*.coffee'
	], 'public/assets/js/backend/category.js');

	// Page
	mix.coffee([
	    'backend/page/*.coffee'
	], 'public/assets/js/backend/page.js');

	// General
	mix.coffee([
	    'backend/general/*.coffee'
	], 'public/assets/js/backend/general.js');

	mix.coffee([
	    'backend/ads/*.coffee'
	], 'public/assets/js/backend/ads.js');

	mix.coffee([
	    'backend/featuredApp/*.coffee'
	], 'public/assets/js/backend/featuredApp.js');

	mix.coffee([
	    'backend/user/*.coffee'
	], 'public/assets/js/backend/user.js');

	
	// Apps
	mix.coffee([
	    'backend/apps/*.coffee'
	], 'public/assets/js/backend/apps.js');


	// Submitted Apps
	mix.coffee([
	    'backend/submittedApp/*.coffee'
	], 'public/assets/js/backend/submittedApp.js');


	// FRONTEND START
	// frontendApp
	mix.coffee([
	    'frontend/frontendApp.coffee'
	], 'public/assets/js/frontend/app.js');

	mix.coffee([
	    'frontend/detailApp.coffee'
	], 'public/assets/js/frontend/detail.js');

	// Apps
	mix.coffee([
	    'frontend/apps/*.coffee'
	], 'public/assets/js/frontend/apps.js');


	mix.coffee([
    	'frontend/search/*.coffee'
	], 'public/assets/js/frontend/search.js');

});