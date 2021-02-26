export default {
  data() {
    return {
      isSettings: false,
      settingsOn: {
        close: () => (this.isSettings = false),
      },
      settingsBtnOn: {
        click: () => (this.isSettings = !this.isSettings),
      },
    }
  },

  computed: {
    settingsAttrs() {
      const attrs = {
        // toggle: this.toggleSettings,
      }

      return attrs
    },

    settingsBtnAttrs() {
      return { design: this.controlButtonDesign, isSettings: this.isSettings }
    },
  },

  methods: {
    toggleSettings() {
      this.isSettings = !this.isSettings
    },
  },

  mounted() {
    // this.toggleSettings()
  },
}
