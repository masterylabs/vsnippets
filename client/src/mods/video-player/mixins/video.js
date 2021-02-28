export default {
  data() {
    return {
      video: {
        seekTo(n) {
          this.player.currentTime = n
        },
      },

      videoOn: {
        loadedmetadata: () => {
          if (this.$refs.video) {
            this.videoWidth = this.$refs.video.videoWidth
            this.videoHeight = this.$refs.video.videoHeight
            this.duration = this.$refs.video.duration
          }

          this.onReady()
        },
        pause: () => {
          this.setState('paused')
        },
        play: () => {
          // this.playerState = 'play'
          this.setState('play')
        },
        playing: () => {
          // this.playerState = 'playing'
          this.setState('playing')
        },
        // progress: () => {},
        // ratechange: (v) => {},
        seeked: () => {
          // this.playerState = 'paused' // 'seeking'
          this.setState('paused')
        },
        seeking: () => {
          // this.playerState = 'seeking'
          this.setState('seeking')
        },
        timeupdate: () => {
          this.setTime(this.player.currentTime)
        },
        error: () => {
          console.log('error')
        },
        // stalled: () => {
        // },
        // suspend: () => {
        // },
        // volumechnage: () => {
        // },
        // waiting: () => {
        // },
        // durationchange: () => {
        // },
        // canplay: () => {
        // },
        // canplaythrough: () => {
        // },
      },

      videoAttrs: {
        playsinline: true,
      },
    }
  },
}
