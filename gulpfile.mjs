'use strict';

import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import gulp from 'gulp';
import rename from 'gulp-rename';
import cleanCSS from 'gulp-clean-css';
import prefix from 'gulp-autoprefixer';
import concat from 'gulp-concat';
import uglify from 'gulp-uglify';
import babel from 'gulp-babel';

const sass = gulpSass(dartSass);
const sassOptions = {
  outputStyle: 'compressed'
};

const cssOptions = {
  level: {
    2: {
      mergeMedia: false,
    }
  },
  format: {
    semicolonAfterLastProperty: true
  }
};

const DIST = {
  public: {
    scripts: 'assets/public/js',
    styles: 'assets/public/css',
  },
};

const SOURCE = {
  public: {
    scripts: 'src/public/js/**/*.js',
    styles: 'src/public/scss/**/*.scss',
  },
}

const VENDOR = {
  public: {
    scripts: [
      'node_modules/hds-js/standalone/cookieConsent/index.js'
    ],
  },
}

function handleStyles(type) {
  return gulp.src(SOURCE[type].styles)
    .pipe(sass(sassOptions).on('error', sass.logError))
    .pipe(prefix())
    .pipe(cleanCSS(cssOptions))
    .pipe(gulp.dest(DIST[type].styles))
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest(DIST[type].styles))
}

function handleScripts(type) {
  return gulp.src(SOURCE[type].scripts)
		.pipe(concat('scripts.js'))
		.pipe(babel({
			presets: ["@babel/preset-env"]
		}))
    .pipe(gulp.dest(DIST[type].scripts))
		.pipe(uglify())
		.pipe(rename('scripts.min.js'))
		.pipe(gulp.dest(DIST[type].scripts));
}

function handleLibraryScripts(type) {
  return gulp.src(VENDOR[type].scripts)
		.pipe(concat('vendor.js'))
    .pipe(gulp.dest(DIST[type].scripts))
		.pipe(uglify())
		.pipe(rename('vendor.min.js'))
		.pipe(gulp.dest(DIST[type].scripts));
}

gulp.task('publicStyles', () => handleStyles('public'));
gulp.task('publicScripts', () => handleScripts('public'));
gulp.task('publicVendorScripts', () => handleLibraryScripts('public'));

gulp.task('watchPublic',function() {
  gulp.watch(SOURCE.public.styles, gulp.parallel('publicStyles'));
  gulp.watch(SOURCE.public.scripts, gulp.parallel('publicScripts'));
});

gulp.task('watch',function() {
  gulp.watch(SOURCE.public.styles, gulp.parallel('publicStyles'));
  gulp.watch(SOURCE.public.scripts, gulp.parallel('publicScripts'));
});

gulp.task('default', gulp.parallel(
  'publicStyles',
  'publicScripts',
  'publicVendorScripts',
));
