import './style.scss'

const vuex = {
	namespaced: true,
	state: {
		isFullscreen: false,
	},
	mutations: {
		TOGGLE(state) {
			state.isFullscreen = !state.isFullscreen

			if (state.isFullscreen) {
				document.body.classList.add('wp-fullscreen-btn--in-fullscreen')
				document.querySelector('html').classList.remove('wp-toolbar')
				return
			}
			document.body.classList.remove('wp-fullscreen-btn--in-fullscreen')
			document.querySelector('html').classList.add('wp-toolbar')
		},
	},
}

export default {
	name: 'wp-fullscreen-btn',
	context: require.context('./', true, /\.vue$/i),
	vuex,
}
