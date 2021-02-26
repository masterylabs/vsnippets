export default {
  computed: {
    isLoading() {
      return ['unstarted', 'loading', 'seek', 'seeking'].includes(
        this.getPlayerState
      )
    },

    loadingAttrs() {
      return {
        color: this.attrs.color,
      }
    },
  },
}
