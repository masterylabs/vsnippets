export default {
  loadVideo() {
    // console.log('load video', id);
    // console.log('plyr', Plyr);
  },

  startSlideL() {
    this.handle.startWidth = this.handle.width
    this.handle.startLeft = this.handle.left
    this.handle.startX = this.clientX
    this.slidingL = true
  },

  slideL() {
    let moveX = this.clientX - this.handle.startX
    let x = this.handle.startLeft + moveX
    let setWidth = true
    if (x < 0) {
      x = 0
      setWidth = false
    } else {
      const rx =
        this.handle.startLeft +
        this.handle.startWidth +
        this.handle.barWidth * 2

      if (x > rx) {
        x = rx - this.handle.width
        setWidth = false
      }
    }
    this.handle.left = x

    if (setWidth) {
      this.handle.width = this.handle.startWidth - moveX
    }
  },

  slide() {
    let x = this.clientX - this.handle.startX
    x = this.handle.startLeft + x

    if (x < 0) {
      x = 0
    } else {
      const w = this.$refs.timelineContainer.clientWidth
      if (x + this.handle.width > w) {
        x = w - this.handle.width
      }
    }
    this.handle.left = x
  },

  slideR() {
    let x = this.clientX - this.handle.startX
    let min = 0 - this.handle.startWidth + 2 * this.handle.barWidth

    if (x < min) {
      x = min
    } else {
      const w = this.$refs.timelineContainer.clientWidth
      let max = w - this.handle.left - this.handle.startWidth

      if (x > max) {
        x = max
      }
    }

    this.handle.width = this.handle.startWidth + x
  },

  startSlide() {
    this.handle.startLeft = this.handle.left
    this.handle.startX = this.clientX
    this.sliding = true
  },

  startSlideR() {
    this.handle.startWidth = this.handle.width
    this.handle.startX = this.clientX
    this.handle.startLeft = this.handle.left
    this.slidingR = true
  },

  endSlide() {
    this.sliding = false
    // this.handle.startLeft = this.handle.left;
    // this.handle.startX = this.clientX;
    console.log('end slide')
  },

  endSlideL() {
    this.slidingL = false
  },

  endSlideR() {
    this.slidingR = false

    // this.handle.startWidth = 0;
    // this.handle.startLeft = 0;
    // this.handle.startX = 0;
  },
}
