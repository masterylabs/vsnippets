export default {
  props: {
    trimStart: {
      type: [Number, String],
      default: 0,
    },
    trimEnd: {
      type: [Number, String],
      default: 0,
    },
  },

  data() {
    {
      return {
        pendingSeekedAction: null,
        // ytPlayingAction: null,
      }
    }
  },

  computed: {
    getDuration() {
      let dur = this.trimEnd ? this.trimEnd : this.duration // parseFloat(this.duration)
      if (this.trimStart) dur = dur - this.trimStart
      // if (this.trimEnd) dur = dur - this.trimStart

      return dur
    },

    getCurrentTime() {
      let ct = this.currentTime
      if (this.trimStart) ct = ct - this.trimStart

      if (ct < 0) ct = 0

      return ct
    },

    getStart() {
      return this.trimStart ? this.trimStart : 0
    },
  },

  methods: {
    onTrimReady() {
      if (this.trimStart) {
        // autoplay would be here
        this.seekToAndPause(this.trimStart, () => this.onFullyReady)
        // this.seekToAndPause
        // this.pendingSeekedAction = 'STOP!'
        // const action = () => {
        //   this.ytPlayingAction = null
        //   setTimeout(() => {
        //     this.pause()
        //   }, 300)
        // }

        // this.setAction('ytPlayingAction', () => {
        //   setTimeout(() => {
        //     this.pause()
        //   }, 300)
        // })
        // this.seekTo(this.trimStart)
      } else this.onFullyReady()
    },
  },
}
