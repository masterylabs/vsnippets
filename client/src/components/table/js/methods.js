export default {
  // selectAllToggle() {}

  deselectAll() {
    this.selected = []

    this.selectingAll = false
  },

  // quickSelectAll() {
  // 	this.isQuickSelectAll = !this.isQuickSelectAll
  // },

  selectAll() {
    if (this.isQuickSelectAll) this.isQuickSelectAll = false
    // manual select all
    this.selectingAll = true

    if (this.selected.length == this.total) return this.deselectAll()

    let page = 1

    if (this.query.page == 1) {
      if (this.items.length) this.selected = [...this.items]
      page++
    } else {
      this.selected = [] // start from beginning
    }

    this.selectAllNext(page)
  },

  async selectAllNext(page) {
    const form = { ...this.getForm, page, limit: 1000 }

    const { data, pagin } = await this.$app.get(this.endpoint, form)

    if (!this.selectingAll) return // cancelled

    if (data.length) {
      this.selected.push(...data)
      // data.forEach((item) => {
      // 	// add to selected
      // 	const index = this.selected.findIndex((a) => a.id == item.id)
      // 	if (index < 0) this.selected.push(item)
      // })

      // check if more
      if (pagin.pages > page) {
        page++
        return this.selectAllNext(page)
      }

      // done
      this.selectingAll = false
    }
  },

  onEdited() {
    this.getItems()
    this.edit = false
    this.editItem = null
  },

  async onItemActive(id, active) {
    this.activatingId = id
    await this.$app.post(`${this.endpoint}/${id}`, { active })
    this.activatingId = null

    this.$app.success(active ? 'Activated' : 'Disabled')
  },

  onCreated() {
    this.create = false
    this.getItems(1)
  },

  async refresh() {
    this.selected = []
    this.refreshing = true
    this.query.page = 1
    await this.getItems()
    this.refreshing = false
  },

  async deleteItem() {
    this.deleting = true
    await this.$app.post(`${this.endpoint}/${this.deleteId}/delete`)
    this.deleting = false
    this.deleteId = null
    this.getItems()
  },

  // todo batch for large numbers
  async deleteSelected() {
    this.deletingSelected = true
    const ids = this.selected.map((a) => a.id).join(',')
    await this.$app.post(`${this.endpoint}/${ids}/delete`)
    this.deletingSelected = false
    this.isSelectedDelete = false
    this.selected = []
    this.getItems(1)
  },

  getItems(page = false) {
    if (page) this.query.page = page

    this.loading = true
    return this.$app.get(this.endpoint, this.getForm).then((data) => {
      this.query.pages = data.pagin.pages
      this.data = data
      this.loading = false
    })
  },
}
