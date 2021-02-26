export default {
  data() {
    return {
      onTimeline: {
        start: (v) => this.onTimelineStart(v),
        end: (v) => this.onTimelineEnd(v),
        rage: (v) => this.onTimelineRange(v),
        done: () => this.onTimelineDone(),
      },
      timelineSeekBuffer: {
        value: -1,
        seeking: false,
      },
    }
  },

  computed: {
    timelineAttrs() {
      return {
        start: this.video.trimStart,
        end: this.video.trimEnd,
      }
      // let start = 0
      // let end = 0
      // if (this.video.trimStart && this.video.trimStart <= this.duration)
      //   start = this.video.trimStart

      // if (this.video.trimEnd && this.video.trimEnd < this.duration)
      //   end = this.video.trimEnd

      // return {
      //   start,
      //   end,
      // }
    },
  },

  methods: {
    onTimelineStart(start) {
      this.video.trimStart = start
      this.timelineSeekTo(start)
    },
    onTimelineEnd(end) {
      this.video.trimEnd = end
      this.timelineSeekTo(end)
    },
    onTimelineRange({ start, end }) {
      this.video.trimStart = start
      this.video.trimEnd = end
      this.timelineSeekTo(start)
    },
    timelineSeekTo(n) {
      const seek = this.timelineSeekBuffer

      seek.value = n
      if (!seek.seeking) {
        seek.seeking = true
        setTimeout(() => {
          this.seekToAndPause = seek.value
          seek.seeking = false
        }, 200)
      }
    },
    onTimelineDone() {
      const video = { ...this.value, ...this.video }
      this.$emit('input', video)
    },
  },
}
