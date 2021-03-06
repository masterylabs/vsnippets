export default {
  loadPlayer() {
    this.destroy()

    this.currentTime = 0
    this.duration = 0

    setTimeout(() => {
      if (this.videoType == 'youtube') this.ytLoadPlayer()
    }, 100)
  },

  seekTo(n) {
    this.setTime(n)
    if (this.videoType == 'youtube') return this.ytSeekTo(n)
    if (this.videoType == 'vimeo') return this.vimSeekTo(n)
    this.player.currentTime = n
  },

  play() {
    if (this.playerState == 'ended') return this.playFromStart()
    this.playerState = 'play'
    if (this.videoType == 'youtube') return this.ytPlay()
    if (this.videoType == 'vimeo') return this.vimPlay()
    this.player.play()
  },

  playFromStart() {
    const n = this.trimStart ? this.trimStart : 0
    this.setTime(n)
    this.playerState = 'play'
    if (this.videoType == 'youtube') return this.ytSeekToAndPlay(n)
    if (this.videoType == 'vimeo') return this.vimSeekToAndPlay(n)

    this.player.currentTime = n
    this.player.play()
  },

  pause() {
    this.setState('pause')
    if (this.videoType == 'youtube') return this.ytPause()
    if (this.videoType == 'vimeo') return this.vimPause()
    this.player.pause()
  },

  endVideo() {
    if (this.videoType == 'youtube') return this.ytEndVideo()
    if (this.videoType == 'vimeo') return this.vimEndVideo()
    this.player.pause()
    this.setState('ended')
  },

  togglePlay() {
    if (this.canPlay) {
      this.play()
      this.unmute()
    } else {
      this.pause()
    }
  },

  setTime(n) {
    if (this.trimEnd && n >= this.trimEnd) {
      this.currentTime = n
      this.endVideo()
      // this.set
      return
    }

    if (n > this.duration - 1) {
      this.currentTime = this.duration
      return
    }
    this.currentTime = this.attrs.useDecimalTime ? n : Math.floor(n)
  },

  setDuration(n) {
    this.duration = n
  },

  setState(state) {
    if (state == 'paused' && this.playerState == 'ended') return
    this.playerState = state
  },

  destroy() {
    if (this.videoType == 'youtube') return this.ytDestroy()
  },
}
