var gulp = require("gulp");
var sass = require('gulp-sass')(require('sass'));
var browserSync = require('browser-sync').create();

var log = require('fancy-log');

var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var compass = require('compass-importer');

var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

// Specific Task
function gulpSass() {
    return gulp.src('resources/sass/css.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed',
			importer: compass
		}).on('error', sass.logError))
		.pipe(autoprefixer({
			overrideBrowserslist: ['> 1%', 'last 2 versions', 'firefox >= 4', 'safari 7', 'safari 8', 'IE 9', 'IE 10', 'IE 11'] 
		}))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('./resources/css/'))
		.on('end', function() { log('SCSS compilado...') })
}
gulp.task(gulpSass);

// Specific Task
function gulpUglify() {
   return gulp.src('resources/js/js.js')
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('resources/js'))
		.pipe(uglify())
		.pipe(gulp.dest('resources/js'))
		.on('end', function() { log('JS minificado...') })
}
gulp.task(gulpUglify);

// Specific Task
function gulpUglifyMenu() {
	return gulp.src('resources/js/menu.js')
		 .pipe(rename({ suffix: '.min' }))
		 .pipe(gulp.dest('resources/js'))
		 .pipe(uglify())
		 .pipe(gulp.dest('resources/js'))
		 .on('end', function() { log('Menu minificado...') })
 }
 gulp.task(gulpUglifyMenu);
 

// Specific Task
function gulpUglifyGerarData() {
	return gulp.src('resources/js/gerarData.js')
		 .pipe(rename({ suffix: '.min' }))
		 .pipe(gulp.dest('resources/js'))
		 .pipe(uglify())
		 .pipe(gulp.dest('resources/js'))
		 .on('end', function() { log('gerarData minificado...') })
 }
 gulp.task(gulpUglifyGerarData);
 

// Specific Task
function gulpUglifyGerarHorarios() {
	return gulp.src('resources/js/gerarHorarios.js')
		 .pipe(rename({ suffix: '.min' }))
		 .pipe(gulp.dest('resources/js'))
		 .pipe(uglify())
		 .pipe(gulp.dest('resources/js'))
		 .on('end', function() { log('gerarHorarios minificado...') })
 }
 gulp.task(gulpUglifyGerarHorarios);
 
 // Specific Task
function gulpUglifyGerarRelatorio() {
	return gulp.src('resources/js/gerarRelatorio.js')
		 .pipe(rename({ suffix: '.min' }))
		 .pipe(gulp.dest('resources/js'))
		 .pipe(uglify())
		 .pipe(gulp.dest('resources/js'))
		 .on('end', function() { log('gerarRelatorio minificado...') })
 }
 gulp.task(gulpUglifyGerarRelatorio);

// Specific Task
function gulpUglifyMostrarHorarios() {
	return gulp.src('resources/js/mostrarHorarios.js')
		 .pipe(rename({ suffix: '.min' }))
		 .pipe(gulp.dest('resources/js'))
		 .pipe(uglify())
		 .pipe(gulp.dest('resources/js'))
		 .on('end', function() { log('mostrarHorarios minificado...') })
 }
 gulp.task(gulpUglifyMostrarHorarios);


 // Specific Task
function gulpUglifyRelatorioDespesa() {
	return gulp.src('resources/js/gerarRelatorioDespesa.js')
		 .pipe(rename({ suffix: '.min' }))
		 .pipe(gulp.dest('resources/js'))
		 .pipe(uglify())
		 .pipe(gulp.dest('resources/js'))
		 .on('end', function() { log('gerarRelatorioDespesa minificado...') })
 }
 gulp.task(gulpUglifyRelatorioDespesa);

//WATCHERS
gulp.task('watch', () => {
	gulp.watch('resources/sass/**/*.scss', gulp.series(gulpSass));
	gulp.watch('resources/js/js.js', gulp.series(gulpUglify));
	gulp.watch('resources/js/menu.js', gulp.series(gulpUglifyMenu));
	gulp.watch('resources/js/gerarData.js', gulp.series(gulpUglifyGerarData));
	gulp.watch('resources/js/gerarHorarios.js', gulp.series(gulpUglifyGerarHorarios));
	gulp.watch('resources/js/gerarRelatorio.js', gulp.series(gulpUglifyGerarRelatorio));
	gulp.watch('resources/js/mostrarHorarios.js', gulp.series(gulpUglifyMostrarHorarios));
	gulp.watch('resources/js/gerarRelatorioDespesa.js', gulp.series(gulpUglifyRelatorioDespesa));
});



// Run multiple tasks
gulp.task('start', gulp.series(gulpSass, gulpUglify, gulpUglifyMenu, gulpUglifyGerarData, gulpUglifyGerarHorarios, gulpUglifyGerarRelatorio, gulpUglifyMostrarHorarios, gulpUglifyRelatorioDespesa));