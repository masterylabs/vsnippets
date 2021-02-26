import { defaultValues } from './config'

export default {
  getTotal: Boolean,
  hideNone: Boolean,
  name: {
    type: String,
    required: true,
  },

  endpoint: {
    type: String,
    default() {
      return `${this.name}s`
    },
  },

  noHover: Boolean,

  cardWidth: {
    type: Number,
    default: defaultValues.cardWidth,
  },

  elevation: {
    type: Number,
    default: defaultValues.elevation,
  },

  hoverElevation: {
    type: Number,
    default: defaultValues.hoverElevation,
  },

  mx: {
    type: [String, Number],
    default: 4,
  },

  mb: {
    type: [String, Number],
    default: 8,
  },
}
