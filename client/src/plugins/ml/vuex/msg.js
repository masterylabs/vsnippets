const state = {
	open: false,
	// customise it
	snackbar: {},
	message: {
		color: 'info',
		title: '',
		text: '',
	},
}

const mutations = {
	SHOW_MESSAGE(state, payload) {
		state.message = {
			color: payload.color || '',
			title: typeof payload.message == 'object' && payload.message.title ? payload.message.title : '',
			text: typeof payload.message == 'object' ? payload.message.text || '' : payload.message,
		}
		state.open = true
	},
	CLOSE(state, value = false) {
		state.open = value
	},
}

export default {
	namespaced: true,
	state,
	mutations,
}
