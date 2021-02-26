export default {
  data() {
    return {
      centerPlayOn: {
        click: () => {
          this.togglePlay()
        },
      },
    }
  },
  computed: {
    centerPlayAttrs() {
      const attrs = {
        ...this.attrs.centerPlay,
      }

      if (!attrs.color) {
        attrs.color = this.attrs.color
      }

      if (typeof attrs.dark != 'boolean') {
        attrs.dark = this.attrs.dark
      }

      attrs.ended = this.playerState == 'ended'

      return attrs
    },
  },
}
