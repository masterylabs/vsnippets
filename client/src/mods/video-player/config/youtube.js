export default {
  playerVars: {
    autoplay: 0,
    controls: 0,
    disablekb: 1,
    rel: 0,
    playsinline: 1,
    // start: 0,
    // end: 0,
    modestbranding: 1,
    // showinfo: 0,
    cc_load_policy: 0,
    wmode: 'opaque',
    enablejsapi: 1,
    mute: 0,
  },

  getPlayerState: function(n) {
    // console.log({ n })
    switch (n) {
      case -1:
        return 'unstarted'
      case 0:
        return 'ended'
      case 1:
        return 'playing'
      case 2:
        return 'paused'
      case 3:
        return 'buffering'
      case 4:
        return 'UNKOWN'
      case 5:
        return 'cued'
      default:
        return false
    }
  },
}
