export default {
  data() {
    return {
      searching: false,
      onSearch: {
        submit: () => this.search(),
      },
    }
  },

  computed: {
    searchAttrs() {
      return {
        value: this.params.q,
        loading: this.searching,
      }
    },
  },

  methods: {
    async search() {
      this.searching = true
      this.params.page = 1
      this.getItems(() => (this.searching = false))
    },
  },
}
