'use strict';

import gulp from 'gulp';
import babel from 'gulp-babel';
import concat from 'gulp-concat';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';

const DIST = {
  public: {
    scripts: 'assets/public/js',
  },
};

const SOURCE = {
  public: {
    scripts: 'src/public/js/**/*.js',
  },
}

const VENDOR = {
  public: {
    scripts: [
      'node_modules/hds-js/standalone/cookieConsent/index.js'
    ],
  },
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

gulp.task('publicScripts', () => handleScripts('public'));
gulp.task('publicVendorScripts', () => handleLibraryScripts('public'));

gulp.task('watchPublic',function() {
  gulp.watch(SOURCE.public.scripts, gulp.parallel('publicScripts'));
});

gulp.task('watch',function() {
  gulp.watch(SOURCE.public.scripts, gulp.parallel('publicScripts'));
});

gulp.task('default', gulp.parallel(
  'publicScripts',
  'publicVendorScripts',
));
