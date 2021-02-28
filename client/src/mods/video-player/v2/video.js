export default {
  data() {
    return {
      video: {
        // map events
        on: {
          loadedmetadata: () => this.onVideoReady(),
          pause: () => this.onVideoPause(),
          play: () => this.onVideoPlay(),
          playing: () => this.onVideoPlaying(),
          seeked: () => this.onVideoSeeked(),
          progress: () => this.onVideoProgress(),
          ratechange: () => this.onVideoRateChange(),
          seeking: () => this.onVideoSeeking(),
          timeupdate: () => this.onVideoTimeUpdate(),
          ended: () => this.onVideoEnded(),
          error: () => this.onVideoError(),
        },

        // map methods
        pause: () => this.videoPause(),
        play: () => this.videoPlay(),
      },
    }
  },

  computed: {
    videoAttrs() {
      return {
        controls: false,
        autoplay: false,
        loop: false,
        muted: false,
        playsinline: true,
      }
    },
    videoSources() {
      return [
        {
          src: this.src,
          type: `video/mp4`,
        },
      ]
    },
  },

  methods: {
    onVideoReady() {
      console.log('video ready , se duration', this.$refs.video.duration)
      this.setDuration(this.$refs.video.duration)
      this.ready()
      // this.video.ready = true
    },
    onVideoPause() {
      console.log('onVideoPause')
    },
    onVideoPlay() {
      console.log('onVideoPlay')
    },
    onVideoPlaying(n) {
      console.log('onVideoPlaying', n)
    },
    onVideoSeeked() {
      console.log('onVideoSeeked')
    },
    onVideoProgress() {
      console.log('onVideoProgress')
    },
    onVideoRateChange() {
      console.log('onVideoRateChange')
    },
    onVideoSeeking() {
      console.log('onVideoSeeking')
    },
    onVideoTimeUpdate() {
      this.setCurrentTime(this.$refs.video.currentTime)
    },
    onVideoEnded() {
      this.ended()
    },
    onVideoError() {
      console.log('onVideoError')
    },
  },
}
