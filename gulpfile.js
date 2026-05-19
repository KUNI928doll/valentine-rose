"use strict";
const { src, dest, series, watch, lastRun, parallel } = require("gulp");
const replace = require('gulp-replace');
const rename = require('gulp-rename');
const changed = require('gulp-changed');
const fs = require('fs');
const del = require("del");
require('date-utils');

/* sass */
const sass = require('gulp-sass')(require('sass'));
const plumber = require("gulp-plumber");
const notify = require("gulp-notify");
const sassGlob = require("gulp-sass-glob-use-forward");
const mqpacker = require("css-mqpacker");
const purgecss = require('gulp-purgecss');
const sortCSSmq = require('sort-css-media-queries');
const gulpStylelint = require("gulp-stylelint");
const postcss = require("gulp-postcss");
const cssdeclsort = require("css-declaration-sorter");
const header = require("gulp-header");
const cssmin = require("gulp-cssmin");
const autoprefixer = require("autoprefixer");

/* html */
const htmlbeautify = require("gulp-html-beautify");

/* js */
const concat = require("gulp-concat");
const order = require("gulp-order");
const uglify = require("gulp-uglify");
const saveLicense = require('uglify-save-license');

/* imagemin */
const imagemin = require("gulp-imagemin");
const imageminPngquant = require("imagemin-pngquant");
const imageminMozjpeg = require("imagemin-mozjpeg");
const imageminSvgo = require("imagemin-svgo");

/* webp */
const webp = require('gulp-webp');

/* browser-sync */
const browserSync = require("browser-sync").create();


/********************* 設定 **********************/
const cssStyle = 'expanded';
const isCssMap = false;
const isJsCompressed = false;
const isJsMap = false;

const PATHS = {
  html: {
    src: "./**/!(_)*.html",
    watch: "./**/!(_)*.html",
    dest: ".",
  },
  styles: {
    src: "./scss/**/*.{scss,css}",
    cssSrc: "./scss/**/*.css",
    dest: "./css/",
    map: "./css/map/",
  },
  js: {
    src: "./js/*.js",
    dest: "./js/",
    map: "./js/map/",
  },
  image: {
    src: ["./images/**/!(_)*.{jpg,jpeg,png,gif,svg,ico,webp}"],
    webpSrc: ["./images/**/!(_)*.{jpg,jpeg,png,gif,ico}"],
    dest: "./images/",
  },
};
/********************* 設定ここまで **********************/


function errorHandler(err, stats) {
  if (err || (stats && stats.compilation.errors.length > 0)) {
    const error = err || stats.compilation.errors[0].error;
    notify.onError({ message: "<%= error.message %>" })(error);
    this.emit("end");
  }
}

// style===========================================
const TARGET_BROWSERS = [
  '> 0.5%',
  'last 2 versions',
  'ios >= 8',
  'Android >= 5',
];
const sassFunc = () => {
  return src(PATHS.styles.src, { sourcemaps: isCssMap, base: null })
    .pipe(plumber({ errorHandler: errorHandler }))
    .pipe(sassGlob())
    .pipe(sass.sync({
      includePaths: ['node_modules', 'scss'],
      outputStyle: cssStyle,
    }))
    .pipe(postcss([
      mqpacker({ sort: sortCSSmq }),
      cssdeclsort({ order: "concentric-css" }),
      autoprefixer(TARGET_BROWSERS),
    ]))
    .pipe(replace(/@charset "UTF-8";/g, ''))
    .pipe(header('@charset "UTF-8";\n\n'))
    .pipe(dest(PATHS.styles.dest, { sourcemaps: (isCssMap ? "./map" : false) }))
    .pipe(browserSync.stream());
};

// scripts===========================================
const jsFunc = () => {
  return src([PATHS.js.src], { sourcemaps: isJsMap })
    .pipe(plumber({ errorHandler: errorHandler }))
    .pipe(uglify({
      keep_fnames: !isJsCompressed,
      mangle: isJsCompressed,
      compress: isJsCompressed,
      output: {
        comments: saveLicense,
        beautify: !isJsCompressed,
        indent_level: 2,
      }
    }))
    .pipe(dest(PATHS.js.dest, { sourcemaps: isJsMap ? "./map" : false }))
    .pipe(browserSync.reload({ stream: true }));
};

// image===========================================
const imageminOption = [
  imageminPngquant({ quality: [0.7, 0.9] }),
  imageminMozjpeg({ quality: 80 }),
  imageminSvgo({
    plugins: [
      { removeViewBox: false },
      { removeAttrs: { attrs: ['id', 'data-name'] } },
      { removeMetadata: false },
      { removeUnknownsAndDefaults: false },
      { convertShapeToPath: false },
      { collapseGroups: false },
      { cleanupIDs: false },
    ]
  }),
  imagemin.gifsicle({ interlaced: false, optimizationLevel: 1, colors: 256 }),
];
const imageminFunc = () => {
  src(PATHS.image.webpSrc)
    .pipe(webp())
    .pipe(dest(PATHS.image.dest));

  return src(PATHS.image.src)
    .pipe(plumber({ errorHandler: errorHandler }))
    .pipe(changed(PATHS.image.dest))
    .pipe(imagemin(imageminOption, { verbose: true }))
    .pipe(dest(PATHS.image.dest));
};

// server =========================================
const browserSyncOption = {
  port: 3000,
  server: {
    baseDir: ".",
  },
};
const browsersync = (done) => {
  browserSync.init(browserSyncOption);
  done();
};

const browserReload = (done) => {
  browserSync.reload();
  done();
};

// watch =========================================
const watchFiles = (done) => {
  watch(PATHS.html.watch, { ignored: /node_modules/ }, browserReload);
  watch(PATHS.styles.src, sassFunc);
  watch(PATHS.js.src, jsFunc);
  watch(PATHS.image.src, series(imageminFunc, browserReload));
  done();
};

// commands =========================================
exports.default = series(
  sassFunc,
  series(browsersync, watchFiles)
);

exports.sass = sassFunc;
exports.js = jsFunc;
exports.imagemin = imageminFunc;
