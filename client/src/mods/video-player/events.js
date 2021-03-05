export default {
  onEnded() {
    //
  },

  onFullyReady() {
    this.unmute()
  },

  onReady() {
    this.playerState = 'ready'

    if (this.attrs.useTrim) {
      this.onTrimReady()
    } else this.onFullyReady()

    // captions
    if (this.attrs.useCaptions) this.onCaptionsReady()

    this.$emit('ready', this.duration)
  },

  onMute() {
    // captions hook
    if (this.useCaptions == 'muted') {
      // support to keep captions on if preset on
      this.pendingCaptionsHide = !this.isCaptions
      this.setCaptions(true)
    }
  },

  onUnmute() {
    // captions hook
    if (this.pendingCaptionsHide) this.setCaptions(false)
  },

  onMousemove() {
    this.isOver = true
    clearTimeout(this.isOverWait)
    const wait = this.attrs.mouseOverDelay || 2500

    this.isOverWait = setTimeout(() => {
      this.isOver = false
    }, wait)
  },

  onResize() {
    this.windowHeight = document.documentElement.clientHeight
  },
}
