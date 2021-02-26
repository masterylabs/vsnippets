export default {
  data() {
    return {
      isFullscreen: false,
      fullscreenMaxHeight: window.screen.height,
      fullscreenBtnOn: {
        click: () => this.toggleFullscreen(),
      },
    }
  },

  computed: {
    fullscreenBtnAttrs() {
      return { design: this.controlButtonDesign, isFullscreen: this.isFullscreen }
    },
  },

  methods: {
    onFullscreenchange() {
      this.isFullscreen = !this.isFullscreen
    },

    toggleFullscreen() {
      if (!this.isFullscreen) {
        return this.enterFullscreen()
      }

      this.exitFullscreen()
    },

    enterFullscreen() {
      const element = this.$refs['player-wrap']

      if (element.requestFullscreen) {
        element.requestFullscreen()
      } else if (element.mozRequestFullScreen) {
        element.mozRequestFullScreen()
      } else if (element.webkitRequestFullscreen) {
        element.webkitRequestFullscreen()
      } else if (element.msRequestFullscreen) {
        element.msRequestFullscreen()
      }
    },

    exitFullscreen() {
      if (document.exitFullscreen) {
        document.exitFullscreen()
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen()
      } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen()
      }

      return
    },
  },

  beforeDestroy() {
    window.removeEventListener('fullscreenchange', this.onFullscreenchange)
  },

  mounted() {
    window.addEventListener('fullscreenchange', this.onFullscreenchange)
  },
}
