import props from './props'

import searchMixin from './search/search'
import cardMixin from './card/card'

const mixins = [searchMixin, cardMixin]

export default {
  props,
  mixins,
  data() {
    return {
      ready: false,
      loading: false,
      data: [],
      pagin: {
        page: 1,
        pages: 1,
        total: 0,
      },
      params: {
        page: 1,
        q: '',
        limit: 24,
      },
    }
  },

  computed: {
    hideAll() {
      return this.hideNone && this.pagin.total == 0 && this.ready
    },
    items() {
      return this.data.filter((item) => {
        if (!this.params.q) return true

        const q = this.params.q.toLowerCase()

        for (const k in item) {
          if (item[k]) {
            const val = item[k].toString().toLowerCase()
            if (val.indexOf(q) > -1) return true
          }
        }
        return false
      })
    },
  },

  methods: {
    onPagin() {
      console.log('onPagin')
      this.getItems()
    },

    async getItems(d = false) {
      this.loading = true
      const { data, pagin } = await this.$app.get(this.endpoint, this.params)
      this.data = data
      this.pagin = pagin
      this.loading = false
      if (typeof d == 'function') d()
    },
  },

  beforeMount() {
    this.getItems(() => {
      this.ready = true
      if (this.getTotal) this.$emit('total', this.pagin.total)
    })
  },
}
