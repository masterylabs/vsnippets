import { bigNumber } from '@/helpers/number'
import computed from './computed'
import data from './data'
import events from './events'
import methods from './methods'
import props from './props'
import watch from './watch'

export default {
	props,
	data() {
		return data
	},
	watch,
	computed,
	methods: {
		...events,
		...methods,
	},
	async beforeMount() {
		this.query.limit = this.defaultRows
		await this.getItems()
		this.ready = true
	},

	filters: {
		bigNumber(n) {
			return bigNumber(n)
		},
	},
}
