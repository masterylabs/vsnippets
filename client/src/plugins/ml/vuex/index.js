import { isEmpty } from 'lodash'

const state = {
	noAuth: false, // app no auth
	ready: false,
	expired: false,
	errors: null,
	license: null,
	settings: {},
	app: {},
	licenseInterval: null,
	upgrade: null,
	brand: {},
	isBrandClient: false,
	addonIds: ['volt', 'search'],
}

const getters = {
	isBrandClient(state) {
		return state.isBrandClient
	},
	app(state) {
		return state.app
	},
	brand(state) {
		return state.brand
	},
	license(state) {
		return state.license
	},
	validLicense(state) {
		return state.license && typeof state.license == 'object' && state.license.valid ? state.license : false
	},
	trial(state) {
		return !state.license || !state.license.is_trial ? false : state.license
	},
	upgrade(state) {
		return state.upgrade
	},
	settings(state) {
		return state.settings
	},
	addons(state) {
		return []
	},
	hasAddon(state) {
		if (!state.license || !state.license.addons || state.license.addons.length < 1) return {}

		const addons = {}

		state.license.addons.forEach(({ app_id }) => {
			addons[app_id] = true
		})

		return addons
	},
}

const mutations = {
	SET_PROP(state, { key, value }) {
		// if (!value && )
		if (!value && ['settings'].includes(key)) {
			state[key] = {}
		} else {
			state[key] = value
		}
	},

	PARSE_LICENSE(state) {
		if (!state.license) return

		// invalid

		if (typeof state.license != 'object') return (state.license = '')

		if (state.licenseInterval) clearInterval(state.licenseInterval)

		if (!state.license.expires_in) {
			state.expired = false
			return
		}

		// set expire countdown
		state.licenseInterval = setInterval(() => {
			state.license.expires_in--
			state.license.valid = state.license.expires_in > 0
			state.expired = state.license.expires_in < 1
		}, 1000)
	},
}

const actions = {
	setProp({ commit }, { key, value }) {
		// console.log('setProp', key)
		commit('SET_PROP', { key, value })
	},

	setProps({ commit }, payload) {
		for (let key in payload) {
			commit('SET_PROP', { key, value: payload[key] })
		}
	},

	addError({ commit, state }, payload) {
		const value = state.errors ? state.errors.push(payload) : [payload]
		commit('SET_PROP', { key: 'errors', value })
	},

	parseLicense({ commit, state }) {
		commit('PARSE_LICENSE')
	},
}

export default {
	namespaced: true,
	state,
	getters,
	mutations,
	actions,
}
