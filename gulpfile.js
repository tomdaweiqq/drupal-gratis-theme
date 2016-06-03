// Include gulp
var gulp = require('gulp');

// Include plugins
var jshint = require('gulp-jshint'),
  plumber = require('gulp-plumber'),
  sass = require('gulp-sass'),
  spritesmith = require('gulp.spritesmith'),
  uglify = require('gulp-uglify'),
  concat = require('gulp-concat'),
  cssmin = require('gulp-cssmin'),
  rename = require('gulp-rename'),
  newer = require('gulp-newer'),
  imagemin = require('gulp-imagemin'),
  lr = require('tiny-lr'),
  server = lr(),
  runSequence = require('run-sequence'),
  stripCssComments = require('gulp-strip-css-comments'),
  sourcemaps = require('gulp-sourcemaps'),
  shell = require('gulp-shell'),
  concatCss = require('gulp-concat-css'),
  browserSync = require('browser-sync');

// Minify JS
gulp.task('scripts', function () {
  return gulp.src(['js/plugins.js', 'js-source/dolphinea.js'])
    .pipe(concat('vendor/dolphinea.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('js'))
    .pipe(browserSync.reload({stream: true}));
});

// Lint JS
gulp.task('lint', function () {
  return gulp.src('js/script.js')
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});

// Compile Sass
gulp.task('sass', function () {
  return gulp.src('css-source/**/*.scss')
    .pipe(plumber({
      errorHandler: function (err) {
        console.log(err);
        this.emit('end');
      }
    }))

    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'expanded'}))
    .pipe(sourcemaps.write('../maps', {
      includeContent: false,
      sourceRoot: '../css-source/*/**',
      mapSources: 'gulp../css-source/*/**',
      debug: true
    }))
    .pipe(gulp.dest('css'))
    .pipe(browserSync.reload({stream: true}));
});

// Sprites
gulp.task('sprite', function () {
  var spriteData = gulp.src('images-source/*.png').pipe(spritesmith(
    {
      retinaSrcFilter: 'images-source/*-2x.png',
      imgName: 'sprite.png',
      retinaImgName: 'sprite-2x.png',
      cssName: '../css-source/_sprite.scss',
      imgPath: '../images/sprite.png',
      retinaImgPath: '../images/sprite-2x.png'
    }
  ))
  spriteData.pipe(gulp.dest('images/'));
});

gulp.task('html', function () {
  gulp.src('./templates/**/*.html.twig')
});


gulp.task('browser-sync', ['sass', 'scripts'], function () {
  browserSync({
    logPrefix: 'Gratis Local site',
    host: 'gratisd8.dev',
    port: 3001,
    open: false,
    notify: true,
  });
});

// Watch Files For Changes.
gulp.task('watch', function () {
  gulp.watch('css-source/**/*.scss', ['sass', browserSync.reload]);
  gulp.watch('js-source/*.js', ['scripts', browserSync.reload]);
  gulp.watch('images-source/**/*', ['sprite', browserSync.reload]);
  gulp.watch('templates/**/*.html.twig', ['html', browserSync.reload]);
  gulp.watch('templates/*.html.twig').on('change', browserSync.reload);
});

// Define post tasks (minify and concatinate min).
gulp.task('postprocess', function () {
  return gulp.src(['css/materialize.css', 'css/mmenu.css', 'css/styles.css'])
    .pipe(sass())
    .pipe(stripCssComments())
    .pipe(concatCss("bundle.css"))
    .pipe(cssmin())
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('css/minicat'))
});

// Run the default Tasks.
gulp.task('default', function () {
  gulp.start('sass', 'scripts', 'html', 'sprite', 'browser-sync', 'watch');
});

// Run post task.
gulp.task('minicat', function () {
  gulp.start('postprocess');
});

