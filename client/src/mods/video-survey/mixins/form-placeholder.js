export default {
	data() {
		return {
			placeholderVal: '',
		}
	},

	methods: {
		onPlaceholderFocus() {
			this.placeholderVal = this.model.placeholder
		},
		onPlaceholderBlur() {
			this.model.placeholder = this.placeholderVal
			this.placeholderVal = ''
		},
	},
}
