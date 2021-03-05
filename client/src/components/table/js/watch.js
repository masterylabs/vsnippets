export default {
  doRefresh() {
    this.refresh()
  },
  options: {
    handler() {
      if (!this.ready || this.loading) return

      this.query.orderby = this.options.sortBy[0]
      this.query.page = 1

      this.getItems()
    },
    deep: true,
  },

  unselectableIds(ids) {
    const selected = this.selected.map((a) => a.id)
    // add to select
    ids.forEach((id) => {
      if (selected.indexOf(id) < 0) {
        this.selected.push({
          id: id,
        })
      }
    })
  },

  filters: {
    handler: function() {
      this.query.page = 1
      this.getItems()
    },
    deep: true,
  },
}
