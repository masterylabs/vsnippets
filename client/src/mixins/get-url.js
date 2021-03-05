import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      settings: 'app/settings',
    }),
  },

  methods: {
    getUrl(slug = '') {
      slug = slug.replace(/vide_/, '')
      if (this.settings.url_prefix)
        return `${this.$app.config.baseUrl}/${this.settings.url_prefix}/${slug}`

      return `${this.$app.config.route}/${slug}`
    },
  },
}
