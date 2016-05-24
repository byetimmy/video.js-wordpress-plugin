var gulp = require('gulp');
var zip = require('gulp-zip');
var clean = require('gulp-clean');


gulp.task('default', ['clean', 'build']);


gulp.task('build', ['copyfiles'], function() {
    return gulp.src('build/**/*')
        .pipe(zip('video-js-shortcode.zip'))
        .pipe(gulp.dest('dist'));
});


gulp.task('copyfiles', ['copywpfiles', 'copyvideojsfiles']);

gulp.task('copywpfiles', function() {
    return gulp.src('src/**/*')
        .pipe(gulp.dest('build'));
});

gulp.task('copyvideojsfiles', function() {
    return gulp.src(['node_modules/video.js/dist/**/*', '!node_modules/video.js/dist/**/*.zip'])
        .pipe(gulp.dest('build'));
});


gulp.task('clean', function (cb) {
	return gulp.src(['build', 'dist'], {read: false})
		.pipe(clean({force: true}));
});