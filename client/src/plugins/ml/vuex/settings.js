const state = {
	data: {},
}

const mutations = {
	SET_PROPS(state, payload) {
		for (let k in payload) {
			state.data[k] = payload[k]
		}
	},
}

// const actions = {}

export default {
	namespaced: true,
	state,
	mutations,
}
