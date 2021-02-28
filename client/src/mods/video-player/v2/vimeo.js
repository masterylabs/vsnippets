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
        play: () => console.log('PLAY'),
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
      console.log(this.$refs)
      const dur = await this.$refs.vimPlayer.player.getDuration()
      this.duration = dur
      this.onReady()
    },

    vimTimeupdate({ seconds }) {
      console.log('n', seconds)
      this.setTime(seconds)
    },

    vimOnPlay() {
      console.log('vimeo on play')
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

      // player.on('play', function() {
      //   console.log('Played the video')
      // })

      player.getVideoTitle().then(function(title) {
        console.log('title:', title)
        player.mute()
        player.play()
      })

      // // nEXT

      // var videoPlayer = new window.Vimeo.Player('myVideo')
      // videoPlayer.on('play', function() {
      //   console.log('Played the video')
      // })

      // console.log('load player')

      // var options = {
      //   id: '14213714',
      //   width: '1280px',
      //   height: '720px',
      // }

      // var player = new window.Vimeo.Player('vimPlayer', options)
      // console.log('player', player)

      // player.on('play', () => {
      //   console.log('PLAY')
      // })
      // player.on('ready', () => {
      //   console.log('READY')
      // })
      // return

      // player.setVolume(0)

      // player.on('play', function() {
      //   console.log('Played the video')
      // })

      // const options = {
      //   id: this.attrs.src,
      //   width: 1280,
      // }

      // console.log('vimeo', Vimeo)

      // // let player = new Vimeo('myVideo', options)
      // var videoPlayer = new Vimeo('myVideo', options)
      // var player = new Vimeo.default('made-in-ny', options);
      // videoPlayer.on('play', function() {
      //   console.log('Played the video')
      // })

      // return
      // console.log('load vimeo player')

      // // destroy previous player if exists
      // var options = {
      //   url: `https://vimeo.com/${this.attrs.src}`,
      //   width: 800,
      // }

      // var videoPlayer = new Vimeo.Player(`${this.playerId}_player`, options)

      // videoPlayer.on('play', function() {
      //   console.log('Played the video')
      // })
    },
  },

  watch: {
    videoType(v) {
      console.log('videoType changed', v)
    },
  },

  mounted() {
    // if (this.videoType == 'vimeo') this.vimLoadPlayer()
    // console.log('before mount vimeo')
  },
}
