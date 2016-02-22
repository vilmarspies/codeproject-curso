var elixir = require('laravel-elixir'),
	liveReload = require('gulp-livereload'),
	clean = require('rimraf'),
	gulp = require('gulp');


configCode = {
	assets_path: './resources/assets',
	build_path: './public/build/assets'
};

configCode.bower_path = configCode.assets_path + '/../bower_components';

configCode.build_path_js = configCode.build_path +'/js';
configCode.build_vendor_path_js = configCode.build_path_js + '/vendor';
configCode.vendor_path_js = [
	configCode.bower_path + '/jquery/dist/jquery.min.js',
	configCode.bower_path + '/bootstrap/dist/js/bootstrap.min.js',
	configCode.bower_path + '/angular/angular.min.js',
	configCode.bower_path + '/angular-route/angular-route.min.js',
	configCode.bower_path + '/angular-resource/angular-resource.min.js',
	configCode.bower_path + '/angular-animate/angular-animate.min.js',
	configCode.bower_path + '/angular-messages/angular-messages.min.js',
	configCode.bower_path + '/angular-bootstrap/ui-bootstrap-tpls.min.js',
	configCode.bower_path + '/angular-strap/dist/modules/navbar.min.js',
	configCode.bower_path + '/angular-cookies/angular-cookies.min.js',
	configCode.bower_path + '/query-string/query-string.js',
	configCode.bower_path + '/angular-oauth2/dist/angular-oauth2.min.js',
	configCode.bower_path + '/ng-file-upload/ng-file-upload.min.js',
	configCode.bower_path + '/angular-http-auth/src/http-auth-interceptor.js',
	configCode.bower_path + '/angularUtils-pagination/dirPagination.js',
	configCode.bower_path + '/moment/min/moment-with-locales.min.js',
	configCode.bower_path + '/lodash/dist/lodash.min.js',
	configCode.bower_path + '/pusher/dist/pusher.min.js',
	configCode.bower_path + '/pusher-angular/lib/pusher-angular.min.js',
	configCode.bower_path + '/angular-ui-notification/dist/angular-ui-notification.min.js',

];

configCode.build_path_css = configCode.build_path+'/css';
configCode.build_vendor_path_css = configCode.build_path_css + '/vendor';
configCode.vendor_path_css = [
	configCode.bower_path + '/bootstrap/dist/css/bootstrap.min.css',
	configCode.bower_path + '/bootstrap/dist/css/bootstrap-theme.min.css',
	configCode.bower_path + '/font-awesome/css/font-awesome.min.css',
	configCode.bower_path + '/angular-ui-notification/dist/angular-ui-notification.min.css',
];

configCode.build_path_html = configCode.build_path + '/views';
configCode.build_path_fonts = configCode.build_path + '/fonts';
configCode.build_path_images = configCode.build_path + '/images';

gulp.task('copy-fonts', function(){
	gulp.src([configCode.assets_path + '/fonts/**/*'])
		.pipe(gulp.dest(configCode.build_path_fonts))
		.pipe(liveReload());
});

gulp.task('copy-fonts-default', function(){
	gulp.src([configCode.assets_path + '/fonts/**/*'])
		.pipe(gulp.dest(configCode.build_path_fonts))
		.pipe(liveReload());
});

gulp.task('copy-images',function() {
	gulp.src([configCode.assets_path + '/images/**/*'])
		.pipe(gulp.dest(configCode.build_path_images))
		.pipe(liveReload());
});

gulp.task('copy-html',function(){
	gulp.src([configCode.assets_path + '/js/views/**/*.html'])
		.pipe(gulp.dest(configCode.build_path_html))
		.pipe(liveReload());
});

gulp.task('copy-styles',function(){
	gulp.src([configCode.assets_path + '/css/**/*.css'])
		.pipe(gulp.dest(configCode.build_path_css))
		.pipe(liveReload());

	gulp.src(configCode.vendor_path_css)
		.pipe(gulp.dest(configCode.build_vendor_path_css))
		.pipe(liveReload());
});

gulp.task('copy-scripts', function(){
	gulp.src([configCode.assets_path + '/js/**/*.js'])
		.pipe(gulp.dest(configCode.build_path_js))
		.pipe(liveReload());

	gulp.src(configCode.vendor_path_js)
		.pipe(gulp.dest(configCode.build_vendor_path_js))
		.pipe(liveReload());
});

gulp.task('clear-build-folder', function(){
	clean.sync(configCode.build_path);
});

gulp.task('default',['clear-build-folder'],function() {
	gulp.start('copy-html', 'copy-fonts','copy-images');
	elixir(function(mix){
		mix.styles(configCode.vendor_path_css.concat([configCode.assets_path + '/css/**/*.css']),
				'public/assets/css/all.css', configCode.assets_path);
		mix.scripts(configCode.vendor_path_js.concat([configCode.assets_path + '/js/**/*.js']),
				'public/assets/js/all.js', configCode.assets_path);
		
		// Copy FONTS
	    mix.copy(configCode.bower_path + '/bootstrap/fonts', 'public/assets/fonts/')
	    	.copy(configCode.bower_path + '/font-awesome/fonts', 'public/assets/fonts/');

		mix.version(['/assets/css/all.css', '/assets/js/all.js']);
	});
});

gulp.task('watch-dev',['clear-build-folder'], function(){
	liveReload.listen();
	gulp.start('copy-styles','copy-scripts', 'copy-html', 'copy-fonts','copy-images');
	gulp.watch(configCode.assets_path + '/**', ['copy-styles','copy-scripts', 'copy-html']);
});

