// events
import events from './js/events'
import methods from './js/methods'
// import setters from './js/setters'

class App {
	started = false

	constructor(appId, options = {}) {
		this.appId = appId
		this.store = options.store
		this.api = options.api

		if (options.config) this.config = options.config
	}

	// Events
	onErrorResponse = events.onErrorResponse

	// Methods
	start = methods.start
	stop = methods.stop
	updateLicense = methods.updateLicense
	remoteStart = methods.remoteStart
	devStart = methods.devStart
	upgrade = methods.upgrade

	// setters
	// setThemeColor = setters.setThemeColor
	// setThemeColor = (color) => {
	// 	console.log('setColor', color, this)
	// }
	// loadModule = loadModule

	// Setters
	setValue(key, value) {
		this.store.dispatch('app/setProp', { key, value })
	}

	setValues(data) {
		this.store.dispatch('app/setProps', data)
	}

	setLicense(value) {
		this.store.dispatch('app/setProp', { key: 'license', value })
	}

	// addsers
	addError(error) {
		this.store.dispatch('app/addError', error)
	}

	on(eName, eFunc) {
		this.events.name = [eFunc]
	}

	// elerts
	success(message) {
		this.store.commit('msg/SHOW_MESSAGE', { message, color: 'success' })
	}

	error(message) {
		this.store.commit('msg/SHOW_MESSAGE', { message, color: 'error' })
	}

	warning(message) {
		this.store.commit('msg/SHOW_MESSAGE', { message, color: 'warning' })
	}

	info(message) {
		this.store.commit('msg/SHOW_MESSAGE', { message, color: 'info' })
	}

	saveSettings(success = 'Settings saved!') {
		return this.post('settings', { ...this.store.getters['app/settings'] }).then(() => {
			this.success(success)
		})
	}

	// api
	get(endpoint = '', params = {}) {
		return this.api
			.get(endpoint, params)
			.then(({ data }) => data)
			.catch((e) => {
				this.onErrorResponse(e.response)
			})
	}

	post(endpoint = '', data = {}, params = {}, remove = ['id', 'identifier', 'created', 'updated']) {
		return this.api
			.post(endpoint, data, params, remove)
			.then(({ data }) => data)
			.catch((e) => {
				this.onErrorResponse(e.response)
			})
	}
}

export default App
