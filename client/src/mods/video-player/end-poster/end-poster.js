export default {
  props: {
    endPoster: {
      type: Object,
      default() {
        return {}
      },
    },
  },

  data() {
    return {
      endPosterOn: {
        click: () => this.pause(),
      },
    }
  },

  computed: {
    endPosterAttrs() {
      return this.endPoster
    },
    showEndPoster() {
      if (this.endPoster.isPreview && this.playerState == 'ready') return true

      return this.playerState == 'ended'
    },
    endPosterNoControls() {
      return (
        this.playerState == 'ended' &&
        this.endPoster.noControls &&
        this.endPoster.active
      )
    },
  },
}
