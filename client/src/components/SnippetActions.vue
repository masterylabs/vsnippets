<template>
  <v-row justify="end" no-gutters>
    <v-tooltip
      v-for="a in getActions"
      :key="a.value"
      top
      :disabled="!a.tooltip"
    >
      <template v-slot:activator="tooltip">
        <v-btn
          :icon="!a.text"
          v-bind="a.attrs"
          v-on="tooltip.on"
          @click="a.click"
        >
          <v-icon v-text="`mdi-${a.value}`" />
        </v-btn>
      </template>
      <span v-text="a.tooltip" />
    </v-tooltip>
  </v-row>
</template>

<script>
  import getUrlMixin from '@/mixins/get-url'
  import brandMixin from '@/mixins/brand'
  export default {
    props: {
      id: {
        type: [String, Number],
        default: '',
      },

      slug: {
        type: String,
        default: 'slug',
      },
    },

    mixins: [getUrlMixin, brandMixin],
    data() {
      return {
        actions: [
          {
            tooltip: 'Copy Shortcode',
            value: 'code-brackets',
            click: () => this.copyShortcode(),
          },
          {
            tooltip: 'Copy Quick Link',
            value: 'link',
            click: () => this.copyUrl(),
            hide: () => !this.hasQuickLink,
          },
          {
            tooltip: 'Open Quick Link',
            value: 'open-in-new',
            click: () => this.openLink(),
            hide: () => !this.hasQuickLink,
          },
          // {
          //   tooltip: 'Edit',
          //   value: 'pencil',
          //   click: () => this.select(),
          //   attrs: {
          //     color: 'primary',
          //   },
          // },
          // {
          //   value: 'chevron-down',
          //   click: () => (this.more = !this.more),
          // },
        ],
      }
    },

    computed: {
      itemUrl() {
        return this.getUrl(this.slug)
      },
      getActions() {
        return this.actions.filter((a) => !a.hide || !a.hide())
      },
    },

    methods: {
      openLink() {
        const url = this.getUrl(this.slug)
        window.open(url)
      },

      async copyUrl() {
        const url = this.getUrl(this.slug)
        await this.$copyText(url)
        this.$app.success('Copied to Clipboard!')
      },

      async copyShortcode() {
        const code = `[vsnippets id="${this.id}"]`
        await this.$copyText(code)
        this.$app.success('Copied to Clipboard!')
      },
    },
  }
</script>
