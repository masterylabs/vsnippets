import Ml from './ml'
import Api from './api'
import vuex from './vuex'
import msg from './vuex/msg'
import settings from './vuex/settings'

import { toCamel } from '@/helpers/str'
import { loadComponents } from '@/helpers/loaders'
// import { mapActions } from 'vuex'

// Components

//export default App

export default {
	install(Vue, options) {
		// Register vuex mods
		options.store.registerModule('app', vuex)
		options.store.registerModule('msg', msg)
		options.store.registerModule('settings', settings)

		// components
		loadComponents(Vue, require.context('./components', true, /\.vue$/i), 'ml')

		const apiEndpoint = options.route ? `${options.route}/api` : options.api ? options.api : ''
		const authToken = options.authToken || options.token || ''

		const cashBuster = options.apiCashBuster ? options.apiCashBuster : false

		options.api = new Api(apiEndpoint, { authToken, cashBuster })

		const app = new Ml(options.appId, options)

		Vue.prototype.$app = app

		/**
		 * Modules
		 */

		if (options.modules) {
			options.modules.forEach((mod) => {
				if (mod.vuex) options.store.registerModule(mod.name, mod.vuex)
				const prefix = toCamel(mod.name, true)
				if (mod.context) loadComponents(Vue, mod.context, prefix)
				// add module to app if needed
			})
		}
	},
}
