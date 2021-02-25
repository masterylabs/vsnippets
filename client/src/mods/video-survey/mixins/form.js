export default {
	props: {
		value: {
			type: Object,
			default() {
				return {}
			},
		},
	},

	computed: {
		isCreate() {
			return this.value.id ? true : false
		},
	},

	data() {
		return {
			loading: false,
			model: {},
		}
	},

	beforeMount() {
		this.model = this.value
	},
}
