export default {
  onInfo({ title }) {
    if (title) {
      this.$emit('video-title', title)
    }
  },
  onSrc(v) {
    console.log('onSrc', v)
  },

  onPlayerReady(dur) {
    console.log('onPlayerReady', dur)
    this.duration = dur
    if (this.start) {
      this.playerSeek = this.start
      console.log('start')
    }
  },

  onRange(v) {
    console.log('onRange', v)
    this.start = v[0]
    this.end = v[1]
    this.playerSeek = v[0]
  },

  onStart(v) {
    console.log('onStart', v)
    this.start = v
    this.playerSeek = v
  },

  onEnd(v) {
    console.log('onEnd', v)
    this.end = v
    this.playerSeek = v
  },
}
