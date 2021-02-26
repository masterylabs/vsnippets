export default {
  data() {
    return {
      actions: {},
    }
  },

  methods: {
    setAction(key, value) {
      this.actions[key] = value
    },

    ifActionDo(key, andClear = false) {
      if (typeof this.actions[key] != 'undefined') this.doAction(key, andClear)
    },

    doAction(key, andClear = false) {
      if (typeof this.actions[key] == 'function') this.actions[key]()

      if (andClear) this.clearAction(key)
    },

    clearAction(key) {
      if (typeof this.actions[key] != 'undefined') delete this.actions[key]
    },
  },
}
