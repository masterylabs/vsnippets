import uuid from 'uuid'

import config from './config/config'
import { deepMerge } from './helpers/helpers'
import { isValidVideo } from '@/helpers/video'
import isDark from '@/helpers/is-dark'

import props from './props'
import watch from './watch'
import events from './events'
import methods from './methods'

import captionsMixin from './mixins/controls/captions'
import controlsMixin from './mixins/controls/controls'
import youtubeMixin from './mixins/youtube'
import videoMixin from './mixins/video'
import posterMixin from './mixins/controls/poster'
import centerPlayMixin from './mixins/controls/center-play'
import timelineMixin from './mixins/controls/timeline'
import settingsMixin from './mixins/controls/settings'
import playbackRateMixin from './mixins/controls/playback-rate'
import maskMixin from './mixins/controls/mask'
import playMixin from './mixins/controls/play'
import fullscreenMixin from './mixins/controls/fullscreen'
import volumeMixin from './mixins/controls/volume'
import loadingMixin from './mixins/controls/loading'
import trimMixin from './mixins/trim'
import seekToAndPause from './mixins/seek-to-and-pause'
import actionsMixin from './mixins/actions'
import vimeoMixin from './mixins/vimeo'
import pauseBannerMixin from './pause-banner/pause-banner'
import promoAlertMixin from './promo-alert/promo-alert'
import endPosterMixin from './end-poster/end-poster'

const mixins = [
  captionsMixin,
  youtubeMixin,
  controlsMixin,
  videoMixin,
  posterMixin,
  centerPlayMixin,
  timelineMixin,
  settingsMixin,
  playbackRateMixin,
  maskMixin,
  playMixin,
  fullscreenMixin,
  volumeMixin,
  loadingMixin,
  trimMixin,
  seekToAndPause,
  actionsMixin,
  vimeoMixin,
  pauseBannerMixin,
  promoAlertMixin,
  endPosterMixin,
]

export default {
  props,
  mixins,
  data() {
    return {
      // isOverPlayer: false,
      isOver: false,
      isOverWait: null,
      playerId: `player-${uuid()}`,
      playerState: 'unstarted',
      videoHeight: 0,
      videoWidth: 0,
      duration: 0,
      currentTime: 0,
    }
  },
  computed: {
    attrs() {
      let k
      const propValue = {}
      for (k in config) if (this[k] != null) propValue[k] = this[k]

      // automate is dark
      if (propValue.color) propValue.dark = isDark(propValue.color)

      return deepMerge(config, propValue)
    },

    videoType() {
      const src = this.attrs.src
      // console.log('src', src)
      return !src
        ? ''
        : !isNaN(src)
        ? 'vimeo'
        : src.length == 11
        ? 'youtube'
        : 'file'
    },

    showControls() {
      if (this.endPosterNoControls) return false
      return this.isOver || this.isOverControls || this.attrs.lockControls
    },

    isValidVideo() {
      return this.attrs.src && this.videoType && isValidVideo(this.attrs.src)
      // if (!this.videoType) return false
      // return this.videoType != 'file' ||
      //   (this.attrs.src.indexOf('://') > -1 && this.attrs.src.indexOf('.') > -1)
      //   ? true
      //   : false
    },

    getPlayerState() {
      return this.isValidVideo ? this.playerState : 'invalid'
    },

    aspectRatio() {
      if (!this.videoWidth || !this.videoHeight) {
        return 1.7777777777777777 // 16 / 9
      }
      return this.videoWidth / this.videoHeight
    },

    player() {
      return this.videoType == 'file' ? this.$refs.video : this.$refs.player
    },

    canPlay() {
      return ['ready', 'paused', 'ended'].includes(this.playerState)
    },

    canPause() {
      return ['playing', 'seeked'].includes(this.playerState)
    },

    // isPaused() {
    //   return ['pause', 'paused']
    // },

    wrapStyle() {
      const style = {}

      if (this.fullscreenMaxHeight) {
        style.maxHeight = `${this.fullscreenMaxHeight}px`
      }

      return style
    },

    captionsTracks() {
      if (!this.attrs.useCaptions) return []

      if (this.videoType == 'youtube') return this.ytCaptionsTracks

      return this.attrs.captions.tracks
    },
  },
  watch,
  methods: {
    ...events,
    ...methods,
  },

  // mounted() {
  //   // setInterval(() => {
  //   // }, 1000)
  // },

  beforeDestroy() {
    this.destroy()
  },
}
