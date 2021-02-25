export default {
	install(Vue, options) {
		const context = require.context('../admin/components', true, /\.vue$/i)

		context.keys().forEach((fileName) => {
			const componentConfig = context(fileName)
			const componentName = fileName
				.replace(/^\.\/_/, '')
				.replace(/\.\w+$/, '')
				.split('-')
				.map((kebab) => kebab.charAt(0).toUpperCase() + kebab.slice(1))
				.join('')
				.split('/')
				.pop()

			Vue.component('M' + componentName, componentConfig.default || componentConfig)
		})
	},
}
