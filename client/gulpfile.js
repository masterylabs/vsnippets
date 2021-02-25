const gulp = require('gulp')
const zip = require('gulp-zip')
const clean = require('gulp-clean')
const replace = require('gulp-replace')
const filter = require('gulp-filter')
const app = require('../package.json')

const classPrefixMe = (str) => {
	const camelCased = str.replace(/-([a-z])/g, function(g) {
		return g[1].toUpperCase()
	})
	return camelCased.charAt(0).toUpperCase() + camelCased.slice(1)
}

const slug = app && app.slug ? app.slug : 'my-ml-app'
const prefix = slug.replace(/-/g, '_') + '_'
const prefix2 = classPrefixMe(slug) + '_'
const prefix3 = classPrefixMe(slug).toUpperCase()
const prefix4 = prefix.replace(/_/g, '-')
const version = app && app.version ? app.version : '0.0.1'

const sourceMapsFilter = filter(['**', '!**/*.map'])

const zipPlugin = function(cb) {
	gulp.src('dist-temp/**')
		.pipe(zip(slug + '.' + version + '.zip'))
		.pipe(gulp.dest('../dist'))
		.on('finish', function() {
			console.log('zipped')
			cb()
		})
}

const buildPackage = function(cb) {
	gulp.src('../src/**')
		.pipe(sourceMapsFilter)
		.pipe(replace('masteryl_', prefix))
		.pipe(replace('Masteryl_', prefix2))
		.pipe(replace('MASTERYL', prefix3))
		.pipe(replace('masteryl-', prefix4))
		.pipe(gulp.dest('dist-temp/' + slug))
		.on('finish', function() {
			// zip it up
			console.log('buildPackage done')
			cb()
		})
}

const deleteTemp = function(cb) {
	return gulp
		.src('dist-temp', { read: false })
		.pipe(clean())
		.on('finish', function() {
			// zip it up
			console.log('deleteTemp done')
			cb()
		})
}

/**
 * Copy public directory to wordpress plugin
 */
const copyPublicToWp = function(cb) {
	gulp.src('src-plugin/public/**')
		.pipe(gulp.dest('../../wordpress/wp-content/plugins/ml-member/public'))
		.on('finish', function() {
			console.log('copyPublicToWp done')
			cb()
		})
}
const copyPublicToAssets = function(cb) {
	gulp.src(['src-plugin/public/**', '!src-plugin/public/**/*.html', '!src-plugin/public/**/*.php'])
		.pipe(gulp.dest('../../wordpress/assets/ml-member'))
		.on('finish', function() {
			console.log('copyPublicToWp done')
			cb()
		})
}

gulp.task('build', async function() {
	buildPackage(function() {
		zipPlugin(function() {
			deleteTemp(function() {
				console.log('ALL DONE')
			})
		})
	})
})

gulp.task('copy-pub', async function() {
	copyPublicToWp(function() {
		copyPublicToAssets(() => {
			console.log('DONE!')
		})
	})
})
