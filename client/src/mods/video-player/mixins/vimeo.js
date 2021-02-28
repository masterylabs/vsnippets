import { vueVimeoPlayer } from 'vue-vimeo-player'

export default {
  components: {
    vueVimeoPlayer,
  },

  data() {
    return {
      vimPlayer: null,
      vimPendingPause: false,
      vimOn: {
        loaded: () => this.vimOnReady(),
        play: () => this.vimOnPlaying(),
        timeupdate: (n) => this.vimTimeupdate(n),
        seeked: () => this.vimOnSeeked(),
        pause: () => this.vimOnPause(),
      },
      vimeo: {
        seekTo: (v) => {
          this.$refs.vimPlayer.player.setCurrentTime(v)
        },
      },
    }
  },

  computed: {
    vimAttrs() {
      return {
        videoId: this.attrs.src,
        playerWidth: 1280,
        playerHeight: 720,
        options: {
          width: 1280,
          height: 720,
          muted: true,
          autoplay: false,
          controls: false,
        },
      }
    },
    //
  },

  methods: {
    async vimSeekToAndPause(n) {
      // this.vimPendingPause = true
      await this.$refs.vimPlayer.player.setCurrentTime(n)
      await this.$refs.vimPlayer.player.pause()
      this.setState('paused')
    },

    async vimSeekToAndPlay(n) {
      await this.$refs.vimPlayer.player.setCurrentTime(n)
      this.setState('play')
      await this.$refs.vimPlayer.player.play()
    },

    async vimOnReady() {
      const dur = await this.$refs.vimPlayer.player.getDuration()
      this.duration = dur
      this.onReady()
    },

    async vimEndVideo() {
      await this.$refs.vimPlayer.player.pause()
      this.setState('ended')
    },

    vimOnSeeked() {
      this.setState('seeked')
    },

    vimOnPause() {
      this.setState('paused')
    },

    vimOnPlaying() {
      this.setState('playing')
    },
    vimPlay() {
      this.$refs.vimPlayer.play()
    },
    vimPause() {
      this.$refs.vimPlayer.player.pause()
    },

    vimSeekTo(n) {
      this.$refs.vimPlayer.player.setCurrentTime(n)
    },

    vimMute() {
      this.$refs.vimPlayer.player.setVolume(0)
    },

    vimUnmute() {
      this.$refs.vimPlayer.player.setVolume(1)
    },

    vimSetVolume(n) {
      this.$refs.vimPlayer.player.setVolume(n)
    },

    vimTimeupdate({ seconds }) {
      this.setTime(seconds)
    },
  },
}
