export default {
  onEnded() {
    console.log('ended')
  },

  onReady() {
    this.playerState = 'ready'

    // console.log('ready')
    if (this.attrs.useTrim) {
      this.onTrimReady()
    }

    // captions
    if (this.attrs.useCaptions) this.onCaptionsReady()
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
}
