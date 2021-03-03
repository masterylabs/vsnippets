export default {
  data() {
    return {
      timelineOn: {
        click: (v) => this.onTimelineClick(v),
      },
    }
  },

  computed: {
    timelineAttrs() {
      const attrs = {
        ...this.attrs.timeline,
        duration: this.getDuration,
        currentTime: this.getCurrentTime,
      }

      if (!attrs.color) {
        attrs.color = this.attrs.controls.color
          ? this.attrs.controls.color
          : this.attrs.color
      }

      if (typeof attrs.dark != 'boolean') {
        attrs.dark = this.attrs.controls.dark
          ? this.attrs.controls.dark
          : this.attrs.dark
      }

      if (!attrs.height && this.attrs.controls.height) {
        attrs.height = this.attrs.controls.height
      } else if (
        !attrs.height &&
        this.attrs.controls.buttonDesign &&
        this.attrs.controls.buttonDesign.height
      ) {
        attrs.height = this.attrs.controls.buttonDesign.height
      }

      // set icon color
      if (!attrs.iconColor) attrs.iconColor = attrs.dark ? '#fff' : '#000'

      return attrs
    },
  },

  methods: {
    onTimelineClick(n) {
      // if (!this.duration) return
      if (this.trimStart) n = n + this.trimStart
      this.seekTo(n)
    },
  },
}
