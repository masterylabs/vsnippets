export default {
  handleLeft() {
    // will not allow to be grater than end
    if (!this.containerWidth || !this.model.start) return 0

    const progress = this.model.start / this.duration
    const left = progress * this.containerWidth

    return Math.floor(left)
  },

  handleWidth() {
    const min = this.handleSideWidth * 2
    let width = min
    if (!this.containerWidth || !this.model.end) return width // not ready

    const progress = (this.model.end - this.model.start) / this.duration

    width = progress * this.containerWidth

    return width < 0 ? 0 : Math.floor(width)
  },

  trimDuration() {
    let v = this.model.end - this.model.start
    if (!isNaN(v) && v > 0) return v
    return 0
  },
}
