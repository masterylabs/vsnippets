export default {
  data() {
    return {
      isMuted: false,
      playerVolume: 1,
      volumeBtnOn: {
        toggleMute: () => this.toggleMute(),
        volume: (v) => this.setVolume(v),
      },
    }
  },

  computed: {
    volumeBtnAttrs() {
      return {
        design: this.controlButtonDesign,
        isMuted: this.isMuted,
        volume: this.playerVolume,
      }
    },
  },

  methods: {
    toggleMute() {
      if (this.isMuted) return this.unmute()
      this.mute()
    },

    mute() {
      this.isMuted = true
      this.player.muted = 1
      if (this.videoType == 'youtube') return this.ytMute()
      if (this.videoType == 'vimeo') return this.vimMute()
      this.onMute()
    },

    unmute() {
      this.isMuted = false
      this.player.muted = 0
      if (this.volume < 1) this.setVolume(1)
      if (this.videoType == 'youtube') return this.ytUnmute()
      if (this.videoType == 'vimeo') return this.vimUnmute()
      this.onUnmute()
    },

    setVolume(n) {
      this.playerVolume = n
      if (this.videoType == 'youtube') return this.ytSetVolume(n)
      if (this.videoType == 'vimeo') return this.vimSetVolume(n)
      this.player.volume = n
    },
  },
}
