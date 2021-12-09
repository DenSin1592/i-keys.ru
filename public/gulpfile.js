const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const cleanCSS = require('gulp-clean-css');
const watch = require('gulp-watch');

gulp.task('sass', function() {
    return gulp.src('html/scss/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS())
        .pipe(gulp.dest('html/css/'));
});

gulp.task('watch', () => {
    gulp.watch('html/scss/**/*.scss', gulp.parallel('sass'));
});

gulp.task('default', gulp.series(['sass']));
