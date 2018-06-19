var gulp = require('gulp'),
    gutil = require('gulp-util'),
    sass = require('gulp-sass'),
    connect = require('gulp-connect'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat');
var rename = require('gulp-rename');
var header = require('gulp-header');
var sourcemaps = require('gulp-sourcemaps');
var package = require('./package.json');
const zip = require('gulp-zip');
const autoprefixer = require('gulp-autoprefixer');
var browserSync = require('browser-sync').create();
var bump = require('gulp-bump');
var git = require('gulp-git');




gulp.task('log', function() { gutil.log("== MY LOG TASK ==") });


gulp.task('sass', gulp.series(function(done) {
    gulp.src('assets/scss/style.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({ sourceComments: 'map' }))
        .on('error', gutil.log)
        .pipe(header(banner.theme, { package: package }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest("./"))
        .pipe(browserSync.stream());;
    done();
}));

gulp.task('js', gulp.series(function() {
    return gulp.src(['assets/js/vendor/*.js', 'assets/js/animations/*.js', 'assets/js/*.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('theme.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))

        .pipe(gulp.dest('.'));
}))

gulp.task('watch', gulp.series(function() {
    gulp.watch('assets/scss/**/*.scss', gulp.series('sass'));


}));

// gulp.task('default', gulp.series('watch'));


// Remove pre-existing content from output and test folders
gulp.task('clean:dist', function() {

});



var banner = {
    full: '/*!\n' +
        ' * <%= package.name %> v<%= package.version %>: <%= package.description %>\n' +
        ' * (c) ' + new Date().getFullYear() + ' <%= package.author.name %>\n' +
        ' * MIT License\n' +
        ' * <%= package.repository.url %>\n' +
        ' * Open Source Credits: <%= package.openSource.credits %>\n' +
        ' */\n\n',
    min: '/*!' +
        ' <%= package.name %> v<%= package.version %>' +
        ' | (c) ' + new Date().getFullYear() + ' <%= package.author.name %>' +
        ' | <%= package.license %> License' +
        ' | <%= package.repository.url %>' +
        ' | Open Source Credits: <%= package.openSource.credits %>' +
        ' */\n',
    theme: '/*!\n' +
        ' * Theme Name: <%= package.name %>\n' +
        ' * Theme URI: <%= package.repository.url %>\n' +
        ' * GitHub Theme URI: <%= package.repository.url %>\n' +
        ' * Description: <%= package.description %>\n' +
        ' * Version: <%= package.version %>\n' +
        ' * Author: <%= package.author.name %>\n' +
        ' * Author URI: <%= package.author.url %>\n' +
        ' * License: <%= package.license %>\n' +
        ' * ' +
        ' */'
};



gulp.task('serve', gulp.parallel(function() {

    browserSync.init({
        proxy: "localhost/blank"
    });
}, function() {

    gulp.watch("assets/scss/**/*.scss", gulp.series('sass'));

    gulp.watch("assets/js/**/*.js", gulp.series('js'));

    gulp.watch("**/*.php").on('change', browserSync.reload);

    gulp.watch("theme.js").on('change', browserSync.reload);
}));

gulp.task('default', gulp.series('sass', 'serve'));