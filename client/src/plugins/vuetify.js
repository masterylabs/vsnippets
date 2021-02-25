import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import config from '../config/config'

Vue.use(Vuetify)

export default new Vuetify({
	icons: {
		iconfont: 'mdi', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4' || 'faSvg'
	},
	theme: {
		options: {
			customProperties: true,
		},
		themes: {
			light: config.colors,
		},
	},
})
