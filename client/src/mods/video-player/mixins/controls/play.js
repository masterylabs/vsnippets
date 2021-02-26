export default {
  data() {
    return {
      playOn: {
        click: () => this.togglePlay(),
      },
    }
  },

  computed: {
    playAttrs() {
      return {
        design: this.controlButtonDesign,
        canPlay: this.canPlay,
        canPause: this.canPause,
        ended: this.playerState == 'ended',
      }
    },
  },
}
