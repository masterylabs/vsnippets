export default {
  data() {
    return {
      resizing: false,
      resizeWait: null,
    }
  },

  methods: {
    onResize() {
      this.resizing = true
      clearTimeout(this.resizeWait)
      this.resizeWait = setTimeout(() => {
        this.resizing = false
        if (typeof this.onResized != 'undefined') this.onResized()
      }, 100)
    },
  },

  mounted() {
    window.addEventListener('resize', this.onResize)
  },

  beforeDestroy() {
    window.removeEventListener('resize', this.onResize)
  },
}
