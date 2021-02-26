export default {
  data() {
    return {
      // posterOn: {
      //   //
      // },
    }
  },

  computed: {
    showPoster() {
      return true
    },

    posterAttrs() {
      return {
        src: this.attrs.poster,
        posterOnPause: this.attrs.posterOnPause,
        playerState: this.playerState,
        inStart: this.currentTime < 1,
      }
    },
  },

  methods: {
    //
  },
}
