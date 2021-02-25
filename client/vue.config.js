module.exports = {
	productionSourceMap: false,
	outputDir: '../src/public/client',
	transpileDependencies: ['vuetify'],
	pages: {
		app: {
			entry: 'src/main.js',
			template: 'public/index.html',
			filename: 'index.html',
			title: 'Index',
			chunks: ['chunk-vendors', 'chunk-common', 'app'],
		},
		// admin: {
		// 	entry: 'src/admin/admin.js',
		// 	template: 'public/admin.html',
		// 	title: 'Admin',
		// 	chunks: ['chunk-vendors', 'chunk-common', 'admin'],
		// },
	},
	configureWebpack: {
		// dev: {
		//   poll: false,
		// },
	},
}
