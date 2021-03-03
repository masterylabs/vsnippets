export default {
  data() {
    return {
      pauseBannerOn: {
        click: () => this.pause(),
      },
    }
  },

  computed: {
    pauseBannerAttrs() {
      return this.pauseBanner
    },
    showPauseBanner() {
      if (this.pauseBanner.showOnReady && this.playerState == 'ready')
        return true
      if (['pause', 'paused'].includes(this.playerState)) return true
      return false
    },
  },
}
