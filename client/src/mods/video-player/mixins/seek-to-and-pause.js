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
    seekToAndPause(v, onDone = false) {
      if (v < 0) return

      this.playerState = 'paused' // must be set direct

      if (this.videoType == 'youtube') return this.ytSeekToAndPause(v, onDone)
      if (this.videoType == 'vimeo') return this.vimSeekToAndPause(v, onDone)

      if (onDone) onDone()

      this.seekTo(v)
    },
  },
}
