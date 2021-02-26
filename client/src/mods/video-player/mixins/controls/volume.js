export default {
  data() {
    return {
      isMuted: false,
      volume: 1,
      volumeBtnOn: {
        toggleMute: () => this.toggleMute(),
        volume: (v) => this.setVolume(v),
      },
    }
  },

  computed: {
    volumeBtnAttrs() {
      return { design: this.controlButtonDesign, isMuted: this.isMuted, volume: this.volume }
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
      this.onMute()
    },

    unmute() {
      this.isMuted = false
      this.player.muted = 0
      if (this.volume < 1) this.setVolume(1)
      if (this.videoType == 'youtube') return this.ytUnmute()
      this.onUnmute()
    },

    setVolume(n) {
      this.volume = n
      if (this.videoType == 'youtube') return this.ytSetVolume(n)
      this.player.volume = n
    },
  },
}
