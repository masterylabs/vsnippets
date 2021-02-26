export default {
  props: {
    design: {
      type: Object,
      default() {
        return {}
      },
    },
  },

  data() {
    return {
      on: {
        click: () => this.$emit('click'),
      },
    }
  },
}
