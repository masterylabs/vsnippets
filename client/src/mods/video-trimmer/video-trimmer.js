import props from './props'
import events from './events'
import methods from './methods'

import timelineMixin from './mixins/timeline'

const mixins = [timelineMixin]

export default {
  props,
  mixins,
  data() {
    return {
      video: {},
      seekToAndPause: -1,
      start: 0,
      end: 0,
      duration: 0,
      playerSeek: null,

      isPlayer: false,

      overHandle: false,
      overHandleL: false,
      overHandleR: false,
      sliding: false,
      slidingL: false,
      slidingR: false,

      // video: 'QbYPCjO2vYg',
      player: null,
      clientX: 0,

      handle: {
        // over: false,
        barWidth: 20,
        width: 200,
        left: 150,
        startLeft: 0,
        startX: 0,
        startWidth: 0,
      },
    }
  },

  computed: {
    inSlide() {
      return this.sliding || this.slidingL || this.slidingR
    },
  },

  methods: {
    ...events,
    ...methods,
  },

  beforeMount() {
    this.video = { ...this.value }
  },
}
