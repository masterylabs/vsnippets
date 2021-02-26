// import { deepMerge } from '../helpers/helpers'

export default {
  data() {
    return {
      isOverControls: false,
      controlsOn: {
        play: () => this.togglePlay(),
        // timeline: (v) => this.onTimelineClick(v),
        fullscreen: () => this.toggleFullscreen(),
        toggleMute: () => this.toggleMute(),
        volume: (v) => this.setVolume(v),
        // playbackRate: (v) => this.setPlaybackRate(v),
        // setCaptions: (v) => this.setCaptions(v),
        toggleCaptions: () => this.toggleCaptions(),
        settings: () => this.toggleSettings(),
        mouseenter: () => (this.isOverControls = true),
        mouseleave: () => (this.isOverControls = false),

        click: () => {
          //
        },
      },
    }
  },

  computed: {
    controlsAttrs() {
      const attrs = {
        ...this.attrs.controls,
        canPlay: this.canPlay,
        canPause: this.canPause,
        isFullscreen: this.isFullscreen,
        isMuted: this.isMuted,
        volume: this.volume,
        playbackRate: this.playbackRate,

        captionsActive: this.isCaptions,

        // captions
        useSettings: true,
      }

      if (!attrs.color) attrs.color = this.attrs.color
      if (typeof attrs.dark != 'boolean') attrs.dark = this.attrs.dark

      if (!attrs.iconColor) attrs.iconColor = attrs.dark ? '#fff' : '#000'

      return attrs
    },

    controlButtonDesign() {
      const value = { ...this.attrs.controls.buttonDesign }

      // add default
      if (!value.color) value.color = this.attrs.controls.color ? this.attrs.controls.color : this.attrs.color
      if (!value.dark) value.dark = this.attrs.controls.dark ? this.attrs.controls.dark : this.attrs.dark

      if (!value.iconColor) value.iconColor = value.dark ? '#fff' : '#000'

      // value.class = 'rounded-xl ma-4'

      return value
    },
  },

  methods: {
    onMouseenterControls() {
      this.isOverControls = true
    },
    onMouseleaveControls() {
      this.isOverControls = false
    },
  },
}
