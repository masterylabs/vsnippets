import { textFieldAttrs } from '../config/config'

export default {
  props: {
    value: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      model: '',
      on: {
        input: (v) => {
          this.$emit('input', v)
        },
      },
    }
  },

  computed: {
    attrs() {
      return {
        ...textFieldAttrs,
        label: this.label,
      }
    },
  },

  beforeMount() {
    if (this.value !== '') this.model = this.value
  },
}
