export default {
  data() {
    return {
      file: {
        seekTo: (n) => {
          // this.$refs.video.currentTime = n
          this.player.currentTime = n
        },
      },
    }
  },
}
