import { isUrl } from '../helpers/helpers'

export default {
  data() {
    return {
      isReady: false,
      hasEnded: false,
      // duration: 0,
      playerState: '',
      // playerDuration: 0,
      // playerCurrentTime: 0,
    }
  },

  computed: {
    source() {
      const src = this.src
      if (!isNaN(src)) return 'vimeo'
      if (src.length == 11) return 'youtube'
      if (isUrl(src)) return 'video'
      return '' // invalid is empty
    },

    player() {
      if (!this.source) return {} // empty object
      return this[this.source]
    },
  },
}
