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
const replace = require('gulp-replace');
const postcss = require('gulp-postcss');
const discardComments = require('postcss-discard-comments');

/* ---------------------------------
   Single source of truth: WP header
----------------------------------- */
const THEME_HEADER = [
  '/*',
  'Theme Name:      The Zahra Trust 2.1.0',
  'Theme URI:       https://zahratrust.com',
  'Description:     The Zahra Trust is a child theme of Kadence, created by ChildTheme-Generator.com',
  'Author:          Rashid Ali',
  'Author URI:      https://w3plus.ca',
  'Template:        kadence',
  'Version:         1.0.0',
  'Text Domain:     the-zahra-trust',
  '*/'
].join('\n');

// Paths
const paths = {
  scss: {
    // compile component/page scss that are NOT partials and NOT style.scss
    src: ['src/scss/**/*.scss', '!src/scss/style.scss', '!src/scss/**/_*.scss'],
    dest: 'dist/css'
  },
  rootScss: {
    src: 'src/scss/style.scss',
    dest: './' // WP needs style.css in theme root
  },
  // OPTIONAL: extra SCSS files you also want compiled to the theme root (no header)
  extraRootFiles: [
    'src/scss/temp.scss',
  ],
  js: {
    src: 'src/js/**/*.js',
    dest: 'dist/js'
  },
  watch: {
    php: ['**/*.php', '!node_modules/**'],
    html: ['**/*.html', '!node_modules/**']
  }
};

// Clean dist folder
function clean() {
  return del(['dist']);
}

// Lint JS
function lintJs() {
  return src(paths.js.src)
    .pipe(plumber({ errorHandler: notify.onError({ title: 'ESLint Error', message: '<%= error.message %>' }) }))
    .pipe(eslint())
    .pipe(eslint.format());
}

// Compile component SCSS into /dist/css (no WP header here)
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

/**
 * Compile ONLY style.scss to theme root and guarantee:
 * - remove all comments (kills stray /*! ...   from partials)
 * - remove any existing @charset
 * - prepend exactly one @charset + THEME_HEADER
 */
function compileRootScss() {
  return src(paths.rootScss.src)
    .pipe(plumber({ errorHandler: notify.onError({ title: 'SCSS Error', message: '<%= error.message %>' }) }))
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError))
    .pipe(autoprefixer({ cascade: false }))

    // Remove ALL comments so no duplicate headers survive.
    .pipe(postcss([ discardComments({ removeAll: true }) ]))

    // Remove any existing @charset (we’ll add our own).
    .pipe(replace(/^\s*@charset\s+["'][^"']+["'];\s*/im, ''))

    // Defensive: remove any leftover theme header fragments.
    .pipe(replace(/\/\*!?\s*['"]?Theme Name:[\s\S]*?\*\//g, ''))

    // Prepend one clean charset + header at file start.
    .pipe(replace(/^/, '@charset "UTF-8";\n' + THEME_HEADER + '\n'))

    .pipe(sourcemaps.write('.'))
    .pipe(dest(paths.rootScss.dest))
    .pipe(browserSync.stream());
}

// OPTIONAL: compile extra SCSS files straight to theme root (no header injected)
function compileExtraRootScss() {
  if (!paths.extraRootFiles.length) return Promise.resolve();
  return src(paths.extraRootFiles)
    .pipe(plumber({ errorHandler: notify.onError({ title: 'SCSS Error', message: '<%= error.message %>' }) }))
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: 'expanded' }).on('error', sass.logError))
    .pipe(autoprefixer({ cascade: false }))
    // do NOT strip comments or inject header here
    .pipe(sourcemaps.write('.'))
    .pipe(dest(paths.rootScss.dest))
    .pipe(browserSync.stream());
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

// Dev server
function serve() {
  browserSync.init({
    proxy: 'https://zahratrustusa.local',
    open: true,
    notify: false
  });

  // Component/page SCSS -> dist/css
  watch(['src/scss/**/*.scss', '!src/scss/style.scss', '!src/scss/**/_*.scss'], compileScss);

  // Root style.scss -> ./style.css
  watch('src/scss/style.scss', compileRootScss);

  // temp.scss (and other extraRootFiles) -> ./temp.css
  watch('src/scss/temp.scss', compileExtraRootScss);
  if (paths.extraRootFiles.length) {
    watch(paths.extraRootFiles, compileExtraRootScss);
  }

  // If partials change, rebuild everything that could depend on them
  watch('src/scss/**/_*.scss', parallel(compileScss, compileRootScss, compileExtraRootScss));

  watch(paths.watch.php).on('change', browserSync.reload);
  watch(paths.watch.html).on('change', browserSync.reload);
}


// Build + default
const build = series(
  clean,
  parallel(
    compileScss,
    compileRootScss,
    compileExtraRootScss,
    series(lintJs, compileJs)
  )
);
const dev = series(build, serve);

exports.clean = clean;
exports.lint = lintJs;
exports.styles = compileScss;
exports.rootStyles = compileRootScss;
exports.extraRootStyles = compileExtraRootScss;
exports.scripts = compileJs;
exports.build = build;
exports.default = dev;
