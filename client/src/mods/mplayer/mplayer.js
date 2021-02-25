import './scss/style.scss'
import Mplayer from './Mplayer.vue'

const PlayerOnlyPlugin = {
	install(Vue, options) {
		const context = require.context('./components', true, /\.vue$/i)

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

			Vue.component('Mplayer' + componentName, componentConfig.default || componentConfig)
		})

		Vue.component('Mplayer', Mplayer)
	},
}

export default PlayerOnlyPlugin
