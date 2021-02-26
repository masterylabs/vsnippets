export default {
  data() {
    return {
      playbackRate: 1,
      playbackRateOn: {
        change: (v) => this.setPlaybackRate(v),
      },
    }
  },

  computed: {
    playbackRateAttrs() {
      return {
        color: this.attrs.color || this.attrs.controls.color,
        value: this.playbackRate,
      }
    },
  },

  methods: {
    setPlaybackRate(n) {
      this.playbackRate = n
      if (this.videoType == 'youtube') return this.ytSetPlaybackRate(n)
      this.player.playbackRate = n
    },
  },
}
