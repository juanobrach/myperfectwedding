'use strict';
 
var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var sourceMap = require('gulp-sourcemaps');
var minified = require('gulp-minify-css')
var filepath = require('./filepaths');


gulp.task('sass',function(){
	sass(filepath.src.styles,{sourcemap:true})
	.pipe(sourceMap.init())
	.on('error',sass.logError)
	.pipe(minified({processImport: false}))
	.pipe(sourceMap.write(filepath.dest.styles))
	.pipe(gulp.dest(filepath.dest.styles))
})
