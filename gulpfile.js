var gulp = require('gulp'),
    gutil = require('gulp-util'),
    sass = require('gulp-sass'),
    header = require('gulp-header'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    browserSync = require('browser-sync'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    fs = require('fs');



// ----- Package.Json -----

var package = require('./package.json');

// ----- Environment Variables -----

var scss_path = './assets/scss/style.scss';
var js_watch = './assets/js/*.js';
var scss_watch = './assets/scss/*.scss';
var proxy = "localhost/blank2";

// ----- CSS Banner -----

var banner = {
    theme: '/*!\n' +
        ' * Theme Name: <%= package.name %> - <%= package.version %>\n' +
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


gulp.task('sass', gulp.series(function(done) {
    gulp.src(scss_path)
        .pipe(sourcemaps.init())
        .pipe(sass({ sourceComments: 'map' }))
        .on('error', gutil.log)
        .pipe(header(banner.theme, { package: package }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest("./"));
    done();
}));


gulp.task('js', gulp.series(function() {
    return gulp.src(['assets/js/vendor/*.js', 'src/js/*.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('theme.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))

        .pipe(gulp.dest('.'));
}))



gulp.task('serve', gulp.parallel(function() {

    browserSync.init({
        proxy: proxy
    });
}, function() {

    gulp.watch(scss_watch, gulp.series('sass'));
    gulp.watch(js_watch, gulp.series('js'));
    gulp.watch("**/*.php").on('change', browserSync.reload);

    gulp.watch("theme.js").on('change', browserSync.reload);
}));

gulp.task('default', gulp.series('sass', 'serve'));

gulp.task("components", gulp.series(function(done) {

    var watcher = gulp.watch('components/**/*.php', gulp.parallel('sass'));
    watcher.on('add', function(path, stats) {
        console.log('File ' + path + ' was added');
        fileName = path.replace(/^.*[\\\/]/, '').replace(/\.[^/.]+$/, "");
        console.log(fileName);
        filepath = 'scss/components/_' + fileName + '.scss';
        fs.access(filepath, (err) => {
            if (err) {
                // file/path is not visible to the calling process
                console.log(err.message);
                console.log(err.code);

                fs.writeFile(filepath, "//" + fileName + " component page", (err) => {
                    if (err) throw err;

                    console.log("The file was succesfully saved!");
                });

            }
        });

    });

    watcher.on('unlink', function(path) {
        console.log('File ' + path + ' was removed');
    });

}));