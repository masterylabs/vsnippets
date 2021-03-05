export default {
  onInfo({ title }) {
    if (title) {
      this.$emit('video-title', title)
    }
  },
  onSrc(v) {},

  onPlayerReady(dur) {
    this.duration = dur
    if (this.start) {
      this.playerSeek = this.start
    }
  },

  onRange(v) {
    this.start = v[0]
    this.end = v[1]
    this.playerSeek = v[0]
  },

  onStart(v) {
    this.start = v
    this.playerSeek = v
  },

  onEnd(v) {
    this.end = v
    this.playerSeek = v
  },
}
