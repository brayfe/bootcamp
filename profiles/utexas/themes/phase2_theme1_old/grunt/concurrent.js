module.exports = {
	'copy-dist': [
		'copy:fonts',
		'copy:js'
	],
	'copy-build': [
		'copy:phase2_theme1'
	],
	'minify': [
		'uglify:dist'
	]
}