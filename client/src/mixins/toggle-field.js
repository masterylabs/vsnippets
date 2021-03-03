export default {
  props: {
    value: {
      type: [String, Number, Boolean],
    },
    label: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      on: {
        input: (v) => {
          this.$emit('input', v)
        },
      },

      // items: [],
    }
  },

  computed: {
    attrs() {
      return {
        value: this.value,
      }
    },
  },
}
