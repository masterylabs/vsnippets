export default {
	selectedCount() {
		return this.isQuickSelectAll ? this.total : this.selected.length
	},

	getForm() {
		const filters = this.filters ? { ...this.filters } : {}
		return { ...this.query, ...filters }
	},

	sortDesc: {
		get() {
			return this.query.order == 'desc'
		},
		set(desc) {
			this.query.order = desc ? 'desc' : 'asc'
		},
	},
	total() {
		return this.data ? this.data.pagin.total : 0
	},

	activeSelected() {
		return this.selected.filter((a) => {
			return this.unselectableIds.indexOf(a.id) < 0
		})
	},

	items() {
		if (!this.data) {
			return []
		}

		const items = this.itemFilter ? this.data.data.map(this.itemFilter) : this.data.data

		// isSelectable

		return items.map((a) => {
			return {
				...a,
				isSelectable: !a.id || this.unselectableIds.indexOf(a.id) < 0,
			}
		})

		// if (this.itemFilter) return this.data.data.map(this.itemFilter)

		return this.data.data
	},

	getHeaders() {
		const headers = this.headers ? [...this.headers] : this.data && this.data.headers ? [...this.data.headers] : []

		// if (this.headers) return this.headers

		// if (!this.data) {
		// 	return []
		// }

		// const headers = [...this.data.headers]
		if (this.created) {
			headers.push({
				text: 'Added',
				value: 'created',
				align: 'left',
				width: 174,
			})
		}

		if (this.updated) {
			headers.push({
				text: 'Updated',
				value: 'updated',
				align: 'left',
				width: 174,
			})
		}

		headers.push({ text: 'Actions', value: 'actions', width: 120 })

		return headers
	},

	fields() {
		if (!this.data) {
			return []
		}
		const skip = ['id', 'identifier', 'created', 'updated']
		return this.data.headers.filter((a) => {
			return skip.indexOf(a.value) < 0
		})
	},

	groupActions() {
		return this.actions.filter((a) => a.selectedClick)
	},

	createForm() {
		if (this.form && this.form.fields) return this.form

		const form = {
			title: 'Add ' + this.singular,
			fields: [],
		}

		const ignoreFields = ['id', 'identifier', 'created', 'updated']

		// console.log(this.data && this.data.headers ? true : false)

		// return form

		if (this.data && this.data.headers) {
			form.fields = this.data.headers.filter((a) => {
				if (ignoreFields.indexOf(a.value) < 0) return true
				return false
			})
		}

		return form
	},
}
