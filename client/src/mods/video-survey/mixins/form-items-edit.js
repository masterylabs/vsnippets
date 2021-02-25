export default {
	data() {
		return {
			editIndex: -1,
			editValue: '',
			editItem: '',
			edit: {
				index: -1,
				value: '',
			},
		}
	},

	methods: {
		onEdit(value) {
			this.model.items[this.edit.index] = value
		},
		doEdit(index) {
			if (this.edit.index == index) this.edit.index = -1
			else {
				this.edit.value = this.model.items[index]
				this.edit.index = index
			}
		},
	},
}
