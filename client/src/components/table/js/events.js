export default {
	onSelect(item) {
		this.$router.push({ name: this.singular, params: { id: item.id } })
	},

	onAction(action, item) {
		if (action == 'edit') {
			this.editItem = item
			this.edit = true
			return
		}

		if (action == 'delete') {
			this.deleteId = item.id
			return
		}
	},

	onRowItems() {
		this.getItems(1)
	},

	async onSearchKeyup() {
		if (this.loading) return

		const form = {
			...this.query,
		}
		this.loading = true
		this.query.page = 1
		this.data = await this.$app.get(this.endpoint, form)
		this.loading = false

		if (form.q != this.query.q) this.onSearchKeyup()
	},
	onPagin(n) {
		this.getItems(n)
	},
	onPageCount(e) {
		// console.log('onPageCount', e)
	},
}
