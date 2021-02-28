export default {
  togglePlay() {
    if (['play', 'playing', 'seek', 'seeking'].includes(this.playerState))
      return this.pause()
    this.play()
  },

  play() {
    if (!this.isReady) {
      this.on('ready', this.play())
    }

    if (this.playerState == 'ended') return this.playFromStart()

    this.setState('play')
    this.player.play()

    /*
    if (this.playerState == 'ended') return this.playFromStart()
    this.playerState = 'play'
    if (this.videoType == 'youtube') return this.ytPlay()
    this.player.play()
    */
  },

  pause() {
    this.setState('pause')
    if (this.videoType == 'youtube') return this.ytPause()
    this.player.pause()
  },

  playFromStart() {
    //
  },

  // pause() {

  // },
}
