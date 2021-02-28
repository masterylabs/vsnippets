export default {
  data() {
    return {
      onEvents: {},
    }
  },

  methods: {
    on(key, func) {
      if (!this.onEvents[key]) this.onEvents[key] = []
      this.onEvents[key].push(func)
    },
  },
}
