const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const del = require('del');

gulp.task('styles', () => {
    return gulp.src('html/scss/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('html/css/'));
});

gulp.task('clean', () => {
    return del([
        'html/css/style.css',
    ]);
});

gulp.task('watch', () => {
    gulp.watch('html/scss/style.scss', (done) => {
        gulp.series(['clean', 'styles'])(done);
    });
});

gulp.task('default', gulp.series(['clean', 'styles']));
