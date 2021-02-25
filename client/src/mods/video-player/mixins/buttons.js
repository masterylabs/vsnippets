export default {
	props: {
		loading: Boolean,
		dark: {
			type: Boolean,
			default: null,
		},
		icon: Boolean,
		canPlay: Boolean,
		canPause: Boolean,
		tile: Boolean,
		depressed: Boolean,
		height: {
			type: [Number, String],
			default: 50,
		},
		size: {
			type: [Number, String],
			default: 30,
		},
		width: {
			type: [Number, String],
			default: 50,
		},
		color: {
			type: String,
			default: '',
		},
		iconColor: {
			type: String,
			default: '',
		},
	},
}
