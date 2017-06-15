'use strict';

var gulp = require('gulp');
var gulpRunSequence = require('run-sequence');
var gulpConcat = require('gulp-concat');
var gulpUglify = require('gulp-uglify');
var gulpCleanCSS = require('gulp-clean-css');
var gulpDelete = require('del');
var gulpAutoprefixer = require('gulp-autoprefixer');
var gulpTinypng = require('gulp-tinypng');

// Приватные параметры.
const Private = require('./private');

const SRC = './src';
const DIST = './dist';

// Каталоги с файлами.
const CSS = '/resources/css';
const JS = '/resources/js';
const IMG = '/resources/img';
const UPLOAD = '/upload/images';
const PRODUCTION = '../www';

// Настройки для плагина `gulp-clean-css`.
let cleanerSettings = {
	level: {
		1: {
			specialComments: 0
		}
	}
};

/**
 *  Таски.
 */
// Назначение таска по-умолчанию.
gulp.task('default', ['build']);

// Ключевой таск с последовательными подтасками.
gulp.task('build', function(callback) {
	gulpRunSequence(
		'clearDist',
		['css', 'cssErrors', 'js', 'imgOther', 'uploadOther'],
		'imgTinypng',
		'uploadTinypng',
		'copyToProduction',
		callback
	);
});

// Очистка конечной директории.
gulp.task('clearDist', function() {
	return gulpDelete([`${DIST}/**`, `!${DIST}`]);
});

// Обработка файлов стилей.
gulp.task('css', function() {
	return gulp.src(getStylesFiles([
			'bootstrap',
			'perfect-scrollbar',
			'magnific-popup',
			'github-gist',
			'style',
			'icons',
			'responsive'
		]))
		.pipe(gulpConcat('common.css'))
		.pipe(gulpAutoprefixer(['last 30 versions']))
		.pipe(gulpCleanCSS(cleanerSettings))
		.pipe(gulp.dest(`${DIST}${CSS}`));
});

// Обработка файлов стилей для страниц с ошибками.
gulp.task('cssErrors', function() {
	return gulp.src(getStylesFiles([
			'bootstrap',
			'error/style',
			'error/responsive'
		]))
		.pipe(gulpConcat('common.css'))
		.pipe(gulpAutoprefixer(['last 30 versions']))
		.pipe(gulpCleanCSS(cleanerSettings))
		.pipe(gulp.dest(`${DIST}${CSS}/error`));
});

// Обработка JavaScript-файлов.
gulp.task('js', function() {
	return gulp.src(getScriptsFiles([
			'jquery-3.2.1',
			'tether',
			'jquery.magnific-popup',
			'perfect-scrollbar.jquery',
			'highlight.pack',
			'clipboard',
			'mustache',
			'autosize',
			'bootstrap',
			'functions',
			'plugins',
			'index'
		]))
		.pipe(gulpConcat('common.js'))
		.pipe(gulpUglify())
		.pipe(gulp.dest(`${DIST}${JS}`));
});

// Обработка основных изображений, отличных от форматов .png и .jpg.
gulp.task('imgOther', function() {
	return gulp.src(`${SRC}${IMG}/**/*.!(png|jpg)`)
		.pipe(gulp.dest(`${DIST}${IMG}`));
});

// Обработка дополнительных изображений, отличных от форматов .png и .jpg.
gulp.task('uploadOther', function() {
	return gulp.src(`${SRC}${UPLOAD}/**/*.!(png|jpg)`)
		.pipe(gulp.dest(`${DIST}${UPLOAD}`));
});

// Обработка и сжатие основных изображений .png и .jpg форматов.
gulp.task('imgTinypng', function() {
	return gulp.src(`${SRC}${IMG}/**/*.+(png|jpg)`)
		.pipe(gulpTinypng(Private.TinypngAPI))
		.pipe(gulp.dest(`${DIST}${IMG}`));
});

// Обработка и сжатие дополнительных изображений .png и .jpg форматов.
gulp.task('uploadTinypng', function() {
	return gulp.src(`${SRC}${UPLOAD}/**/*.+(png|jpg)`)
		.pipe(gulpTinypng(Private.TinypngAPI))
		.pipe(gulp.dest(`${DIST}${UPLOAD}`));
});

// Копирование файлов в каталог с проектом.
gulp.task('copyToProduction', function() {
	return gulp.src(`${DIST}/**`)
		.pipe(gulp.dest(`${PRODUCTION}`));
});

// Формирование массива с файлами заданного формата.
let getFiles = (files = [], path = '', format = '') => {
	let result = [];

	/*
	if (format == 'img') {
		format = '*';
	}
	*/

	files.forEach((file) => {
		result.push(`${SRC}${path}/${file}.${format}`);
	});

	return result;
};

// Формирование массива с CSS-файлами.
let getStylesFiles = (files = []) => {
	return getFiles(files, CSS, 'css');
};

// Формирование массива с JS-файлами.
let getScriptsFiles = (files = []) => {
	return getFiles(files, JS, 'js');
};

/*
// Формирование массива с изображениями.
let getImagesFiles = (files = []) => {
	return getFiles(files, IMG, 'img');
};
*/