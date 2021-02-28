export default {
  onReady() {
    // console.log('READY')
    this.$emit('ready', this.duration)
  },

  onCurrentTime() {
    // console.log('triggeres here', this.currentTime)
  },

  // play initated
  onPlay() {
    //
  },

  // pause initiated
  onPause() {
    //
  },
}
