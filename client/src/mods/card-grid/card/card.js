export default {
  data() {
    return {
      deletingCard: '',
      onCard: {
        delete: (id) => this.deleteCard(id),
        select: (id) => this.selectCard(id),
      },
    }
  },

  computed: {
    cardAttrs() {
      return {
        width: this.cardWidth,
        noHover: this.noHover,
        elevation: this.elevation,
        hoverElevation: this.hoverElevation,
        name: this.name,
        // item: this.params.q,
        // deleting,
      }
    },
  },

  methods: {
    selectCard(id) {
      this.$router.push({
        name: this.name,
        params: { id },
      })
    },

    async deleteCard(id) {
      this.deletingCard = id
      await this.$app.post(`${this.endpoint}/${id}/delete`)
      this.params.page = 1
      this.deletingCard = ''
      this.getItems()
    },
  },
}
