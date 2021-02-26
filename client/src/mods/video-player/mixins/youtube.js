import YouTubePlayer from 'youtube-player'
import ytConfig from '../config/youtube'

export default {
  data() {
    return {
      ytReady: false,
      ytPlayerLoaded: false,
      ytPlayer: null,
      ytTarget: null,

      ytTicker: null,
      ytTickerUpdating: false,

      ytCaptionsTracklist: [],

      ytPendingNoPause: null,
    }
  },

  methods: {
    ytOnReadyOne({ target }) {
      this.ytTarget = target

      const dur = target.getDuration()
      if (dur) this.duration = dur

      if (this.attrs.useCaptions) {
        target.loadModule('captions')
        this.ytHideCaptions()
      } else {
        this.ytOnReadyTwo()
      }

      // get anme
      if (this.getInfo) {
        const info = this.ytTarget.getVideoData()
        this.$emit('info', info)
      }
    },

    ytOnReadyTwo() {
      this.ytPause() // back to normal
      // this.ytUnmute() // back to normal

      this.ytReady = true

      if (this.attrs.useCaptions) this.ytLoadCaptions()
      this.ytHideCaptions() // not always hidden on first

      this.onReady()
    },

    ytOnStateChange({ data }) {
      const state = ytConfig.getPlayerState(data)

      if (state == 'paused' && this.ytPendingNoPause) {
        this.ytPendingNoPause()
        this.ytPendingNoPause = null
        return
      }

      if (!this.ytReady && state == 'playing') return this.ytOnReadyTwo()

      if (state == 'playing') {
        this.ytStartTicker()
        this.ifActionDo('ytPlaying', true)
      } else {
        this.ytStopTicker()
        this.ytUpdateTime()
      }

      this.setState(state)
    },

    /**
     * Loaders
     */

    ytLoadPlayer() {
      const cc_load_policy = this.attrs.useCaptions ? 1 : 0

      let autoplay = 0

      if (this.attrs.useCaptions) autoplay = 1

      const width = this.$refs.container
        ? this.$refs.container.clientWidth
        : 1280
      const height = this.$refs.container
        ? this.$refs.container.clientHeight
        : 720

      const args = {
        playerVars: {
          ...ytConfig.playerVars,
          cc_load_policy,
          mute: 1,
          autoplay,
        },
        videoId: this.attrs.src,
        width,
        height,
      }

      const player = YouTubePlayer(this.$refs.player, args)

      player.on('ready', this.ytOnReadyOne)
      player.on('stateChange', this.ytOnStateChange)

      this.ytPlayer = player
    },

    /**
     * Methods
     */

    ytSeekToAndPause(n) {
      this.setAction('ytPlaying', () => {
        setTimeout(() => {
          this.pause()
        }, 300)
      })
      this.seekTo(n)
    },

    ytSeekToAndPlay(n) {
      this.clearAction('ytPlaying')
      this.ytSeekTo(n)
      setTimeout(() => {
        this.ytPlay()
      })
    },

    ytPlay() {
      this.ytTarget.playVideo()
    },

    ytPause() {
      this.ytTarget.pauseVideo()
      this.setState('paused')
    },

    ytSeekTo(n) {
      this.ytTarget.seekTo(n, true)
    },

    ytMute() {
      this.ytTarget.mute()
    },

    ytUnmute() {
      this.ytTarget.unMute() //
    },

    ytSetVolume(n) {
      n = Math.floor(n * 100)
      this.ytTarget.setVolume(n)
    },

    ytEndVideo() {
      this.ytPendingNoPause = () => {
        this.setState('ended')
      }
      this.ytTarget.pauseVideo()
      this.setState('ended')
    },

    ytSetPlaybackRate(n) {
      this.ytTarget.setPlaybackRate(n)
    },

    /**
     * Captions
     */

    ytLoadCaptions() {
      const list = this.ytTarget.getOption('captions', 'tracklist')
      const track = this.ytTarget.getOption('captions', 'track')
      const index = list.findIndex((a) => a.languageName == track.languageName)

      this.ytCaptionsTracklist = list
      this.captionsTracklistIndex = index
    },

    ytShowCaptions() {
      const track = this.ytCaptionsTracklist[this.captionsTracklistIndex]
      this.ytTarget.setOption('captions', 'track', track)
    },

    ytHideCaptions() {
      this.ytTarget.setOption('captions', 'track', {})
    },

    yCaptionsSetSize(size = 0) {
      // -1 to 3
      this.ytTarget.setOption('captions', 'fontSize', size)
    },

    /**
     * YouTube Ticker
     */

    ytStopTicker() {
      clearTimeout(this.ytTicker)
      this.ytTicker = null
    },
    ytStartTicker() {
      if (this.ytTicker) return

      this.ytTicker = setInterval(() => {
        if (this.playerState == 'playing') this.ytUpdateTime()
      }, 300)
    },

    ytUpdateTime() {
      if (!this.ytTarget) return

      const ct = this.ytTarget.getCurrentTime()
      this.setTime(ct)
    },

    ytDestroy() {
      if (this.ytPlayer && this.ytPlayer.destroy) this.ytPlayer.destroy()
      this.ytReady = false
    },
  },

  mounted() {
    if (this.videoType == 'youtube') this.ytLoadPlayer()
  },
}
