const header = require('gulp-header');
const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const del = require('del');
const autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();
const eslint = require('gulp-eslint');
const plumber = require('gulp-plumber');
const notify = require('gulp-notify');

// Theme header for root CSS
const themeHeader = [
  '/*!',
  'Theme Name:      The Zahra Trust 2.1.0',
  'Theme URI:       https://zahratrust.com',
  'Description:     The Zahra Trust is a child theme of Kadence, created by ChildTheme-Generator.com',
  'Author:          Rashid Ali',
  'Author URI:      https://w3plus.ca',
  'Template:        kadence',
  'Version:         1.0.0',
  'Text Domain:     the-zahra-trust',
  '*/',
  ''
].join('\n');

// Paths
const paths = {
  scss: {
    src: 'src/scss/**/*.scss',
    dest: './'
  },
  rootScss: {
    src: 'src/scss/style.scss',
    dest: './'
  },
  js: {
    src: 'src/js/**/*.js',
    dest: 'dist/js'
  }
};

// Clean dist folder
function clean() {
  return del(['dist']);
}

// Lint JS (errors no longer break the stream)
function lintJs() {
  return src(paths.js.src)
    .pipe(plumber({ errorHandler: notify.onError({ title: 'ESLint Error', message: '<%= error.message %>' }) }))
    .pipe(eslint())
    .pipe(eslint.format());
}

// Compile component SCSS into CSS
function compileScss() {
  return src(paths.scss.src)
    .pipe(plumber({ errorHandler: notify.onError({ title: 'SCSS Error', message: '<%= error.message %>' }) }))
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError))
    .pipe(autoprefixer({ cascade: false }))
    .pipe(sourcemaps.write('.'))
    .pipe(dest(paths.scss.dest))
    .pipe(browserSync.stream());
}

// Compile root SCSS (with theme header)
function compileRootScss() {
  return src(paths.rootScss.src)
    .pipe(plumber({ errorHandler: notify.onError({ title: 'SCSS Error', message: '<%= error.message %>' }) }))
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError))
    .pipe(header(themeHeader))
    .pipe(sourcemaps.write('.'))
    .pipe(dest(paths.rootScss.dest));
}

// Concatenate & minify JS
function compileJs() {
  return src(paths.js.src, { sourcemaps: true })
    .pipe(plumber({ errorHandler: notify.onError({ title: 'JS Compile Error', message: '<%= error.message %>' }) }))
    .pipe(concat('app.min.js'))
    .pipe(uglify())
    .pipe(dest(paths.js.dest, { sourcemaps: '.' }))
    .pipe(browserSync.stream());
}

// Serve with BrowserSync
function serve() {
  browserSync.init({
    proxy: 'https://zahratrustusa.local',
    open: true,
    notify: false
  });

  watch(paths.scss.src, compileScss);
  watch(paths.rootScss.src, compileRootScss);
  watch(paths.js.src, series(lintJs, compileJs));
  watch('*.html').on('change', browserSync.reload);
}

// Build and default tasks
const build = series(
  clean,
  parallel(
    compileScss,
    compileRootScss,
    series(lintJs, compileJs)
  )
);
const dev = series(build, serve);

// Export tasks
exports.clean = clean;
exports.lint = lintJs;
exports.styles = compileScss;
exports.rootStyles = compileRootScss;
exports.scripts = compileJs;
exports.build = build;
exports.default = dev;
