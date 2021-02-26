export default {
  addNew: Boolean,
  doRefresh: Boolean,
  canSelect: Boolean,
  created: Boolean,
  updated: Boolean,
  cardView: Boolean,
  headers: {
    type: Array,
    default: null,
  },
  itemSlots: {
    type: Array,
    default() {
      return []
    },
  },

  filters: {
    type: Object,
    default() {
      return null
    },
  },
  unselectableIds: {
    type: Array,
    default() {
      return []
    },
  },
  primaryCol: {
    type: String,
    default: 'name',
  },
  linkCols: {
    type: Array,
    default() {
      return ['name', 'title', 'first_name', 'last_name', 'email']
    },
  },
  name: {
    type: String,
    default() {
      return this.$route.name
    },
  },

  title: {
    type: String,
    default() {
      return this.$route.name
    },
  },

  singular: {
    type: String,
    default() {
      if (!this.name) return ''
      return this.name.slice(0, -1)
    },
  },

  endpoint: {
    type: String,
    default() {
      return this.$route.path
    },
  },
  form: {
    type: Object,
    default: null,
  },
  itemRoute: {
    type: String,
    default: '',
  },
  itemFilter: {
    type: Function,
    default: null,
  },
  rowItems: {
    type: Array,
    default() {
      return [10, 25, 50, 100]
    },
  },
  defaultRows: {
    type: Number,
    default: 25,
  },
}
