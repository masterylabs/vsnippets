/**
 * Check before setting,
 */
export default {
  //
  setDuration(n) {
    this.duration = n
  },

  // source notifiying of sate cahnge
  setState(state) {
    if (state == 'paused' && this.playerState == 'ended') return
    this.playerState = state
  },

  setCurrentTime(n) {
    this.currentTime = n
    this.onCurrentTime()
  },

  // source is ready
  ready() {
    // before ready here
    this.playerState = 'ready'
    this.isReady = true
    this.onReady()
  },

  ended() {
    console.log('videoEnded')
    this.hasEnded = true
    this.playerState = 'ended'
  },
}
