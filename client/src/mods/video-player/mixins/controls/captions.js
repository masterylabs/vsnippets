export default {
  data() {
    return {
      isCaptions: false,
      captionsTracklistIndex: 0,
      pendingCaptionsHide: false,
      captionsOn: {
        change: (index) => this.setCaptions(index),
        toggle: () => this.toggleCaptions(),
      },
      captionsBtnOn: {
        click: () => this.toggleCaptions(),
      },
    }
  },

  computed: {
    captionsAttrs() {
      const tracklist =
        this.videoType == 'youtube' ? this.ytCaptionsTracklist : this.captions.tracks ? this.captions.tracks : []
      return {
        active: this.isCaptions,
        index: this.captionsTracklistIndex,
        tracklist,
        color: this.attrs.color || this.attrs.controls.color,
      }
    },

    captionsBtnAttrs() {
      return { design: this.controlButtonDesign, isCaptions: this.isCaptions }
    },

    videoCaptionsTrack() {
      if (this.videoType != 'file' || !this.captions || !this.attrs.useCaptions) return false

      // simple url
      if (typeof this.captions == 'string')
        return {
          src: this.captions,
        }

      // looking for object with tracklist
      if (!this.captions.tracklist || !this.captions.tracklist.length < this.captionsTracklistIndex + 1) return false

      // could find default captions HERE

      return this.captions.tracklist[this.captionsTracklistIndex]
    },
  },

  methods: {
    onCaptionsReady() {
      if (this.attrs.useCaptions && ['on', 'always'].includes(this.attrs.useCaptions)) this.showCaptions()
      else this.hideCaptions()
    },

    toggleCaptions() {
      this.isCaptions = !this.isCaptions

      if (this.isCaptions) this.showCaptions()
      else this.hideCaptions()
    },

    setCaptions(trackIndex) {
      this.captionsTracklistIndex = trackIndex
      this.showCaptions()
    },

    hideCaptions() {
      this.isCaptions = false

      if (this.videoType == 'youtube') return this.ytHideCaptions()

      const video = this.$refs.video
      for (var i = 0; i < video.textTracks.length; i++) {
        video.textTracks[i].mode = 'hidden'
      }
    },

    showCaptions() {
      this.isCaptions = true

      if (this.videoType == 'youtube') return this.ytShowCaptions()

      const video = this.$refs.video
      for (var i = 0; i < video.textTracks.length; i++) {
        video.textTracks[i].mode = 'showing'
      }
    },
  },
}
