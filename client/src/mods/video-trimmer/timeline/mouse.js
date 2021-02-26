export default {
  methods: {
    onMousedown({ clientX }) {
      if (!this.overHandle) return

      // Start Slide
      const pixVal = this.containerWidth / this.duration
      this.startState = {
        ...this.model,
        x: clientX,
        pixVal,
        trimDuration: this.trimDuration,
      }
      this.sliding = true
    },

    onMousemove({ clientX }) {
      if (!this.sliding) return

      const x = clientX - this.startState.x
      const secs = x / this.startState.pixVal

      let value

      const both = !this.overSide

      const { trimDuration } = this.startState

      if (both || this.overSide == 'left') {
        value = this.startState.start + secs
        if (value > this.model.end) value = this.model.end

        if (both) {
          const max = this.duration - trimDuration
          if (value >= max) value = max
        }

        if (value < 0) value = 0

        this.setStart(value)
      }
      if (both || this.overSide == 'right') {
        value = this.startState.end + secs

        // if less than start
        if (value < this.model.start) value = this.model.start

        if (both && value <= trimDuration) value = trimDuration

        if (value > this.duration) value = Math.floor(this.duration)

        this.setEnd(value)
      }

      // notify
      if (both) this.onSlidingBoth()
      else if (this.overSide == 'left') this.onSlidingLeft()
      else this.onSlidingRight()
    },

    onMouseup() {
      if (!this.sliding) return
      this.sliding = false
      this.$emit('done')
    },
  },

  mounted() {
    document.addEventListener('mousedown', this.onMousedown)
    document.addEventListener('mouseup', this.onMouseup)
    document.addEventListener('mousemove', this.onMousemove)
  },

  beforeDestroy() {
    document.removeEventListener('mouseup', this.onMouseup)
    document.removeEventListener('mousedown', this.onMousedown)
    document.removeEventListener('mousemove', this.onMousemove)
  },
}
