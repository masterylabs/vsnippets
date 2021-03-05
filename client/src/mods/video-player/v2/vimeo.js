import { vueVimeoPlayer } from 'vue-vimeo-player'

export default {
  components: {
    vueVimeoPlayer,
  },

  data() {
    return {
      vimPlayer: null,
      vimOn: {
        loaded: () => this.vimOnReady(),
        play: () => {},
        timeupdate: (n) => this.vimTimeupdate(n),
      },
      vimeo: {
        seekTo: (v) => {
          this.$refs.vimPlayer.player.setCurrentTime(v)
        },
      },
    }
  },
  /**
   * 
   * bufferend
bufferstart
ended
error
loaded
pause
play
playbackratechange
progress
seeked
timeupdate
volumechange


     <!-- 
          @loaded="viReady"
            @ended="vimOnEnded"
            @play="vimOnPlay"
            @pause="vimOnPause" -->


            :videoId="attrs.src"
              :player-width="1280"
              :player-height="720"
              :options="{ width: 1280, height: 720 }"
   */

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
          chromeless: true,
        },
        // src: `https://player.vimeo.com/video/${this.attrs.src}`,
        // width: 1280,
        // height: 720,
        // frameborder: 0,
        // byline: false,
        // dataVimeoControls: false,
        // dataVimeoMuted: true,
        // dataVimeoAutoplay: true,
        // controls: false,
        // 'data-vimeo-controls': false,
      }
    },
    //
  },

  methods: {
    async vimOnReady() {
      const dur = await this.$refs.vimPlayer.player.getDuration()
      this.duration = dur
      this.onReady()
    },

    vimTimeupdate({ seconds }) {
      this.setTime(seconds)
    },

    vimOnPlay() {
      //
    },

    vimLoadPlayer() {
      const options = {
        id: this.attrs.src,
        controls: false,
        muted: true,
        autoplay: true,
        width: 1280,
      }
      var player = new window.Vimeo.Player(this.$refs.vimeoPlayer, options)

      player.getVideoTitle().then(function(title) {
        player.mute()
        player.play()
      })

      // // nEXT
    },
  },

  watch: {
    videoType(v) {
      //
    },
  },
}
