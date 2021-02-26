export default {
  props: {
    remoteSeekToAndPause: {
      type: Number,
      default: -1,
    },
  },

  watch: {
    remoteSeekToAndPause(v) {
      if (v < 0) return

      this.seekToAndPause(v)
    },
  },

  methods: {
    seekToAndPause(v) {
      if (v < 0) return

      this.playerState = 'paused' // must be set direct

      if (this.videoType == 'youtube') return this.ytSeekToAndPause(v)

      this.seekTo(v)
    },
  },
}
