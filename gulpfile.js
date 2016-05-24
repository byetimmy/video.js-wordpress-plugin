var gulp = require('gulp');
var zip = require('gulp-zip');
var clean = require('gulp-clean');


gulp.task('default', ['clean', 'copywpfiles', 'copyvideojsfiles'], () => {
    return gulp.src('build/**/*')
        .pipe(zip('video-js-plugin.zip'))
        .pipe(gulp.dest('dist'));
});


gulp.task('copywpfiles', () => {
    return gulp.src('src/**/*')
        .pipe(gulp.dest('build'));
});


gulp.task('copyvideojsfiles', () => {
    return gulp.src('node_modules/video.js/dist/**/*')
        .pipe(gulp.dest('build'));
});


gulp.task('clean', function () {
	return gulp.src(['build', 'dist'], {read: false})
		.pipe(clean());
});