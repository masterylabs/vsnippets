<template>
  <div>
    <div
      ref="container"
      class="video-trimmer-timeline-container yellow lighten-5 elevation-3 ml-unselectable"
    >
      <video-trimmer-timeline-markers
        :duration="duration"
        :containerWidth="containerWidth"
      />
      <div
        class="video-trimmer-timeline-handle white--text text-center"
        :style="`left:${handleLeft}px;width:${handleWidth}px`"
        v-on="onHandle"
      >
        <div class="video-trimmer-timeline-handle-bg success lighten-3" />
        <v-row align="center" justify="space-between" no-gutters class="">
          <div
            class="video-trimmer-timeline-handle-left primary rounded-l-lg elevation-2"
            v-on="onLeft"
          >
            <video-trimmer-timeline-label>
              {{ model.start | pretty }}
            </video-trimmer-timeline-label>
          </div>
          <div
            class="video-trimmer-timeline-handle-right primary rounded-r-lg elevation-2"
            v-on="onRight"
          >
            <video-trimmer-timeline-label right>
              {{ model.end | pretty }}
            </video-trimmer-timeline-label>
          </div>
        </v-row>

        <v-fade-transition>
          <div
            v-if="handleWidth > 52"
            class="video-trimmer-timeline-handle-duration text-center primary--text font-weight-bold text-h6"
          >
            {{ trimDuration | pretty }}
          </div>
        </v-fade-transition>
      </div>
    </div>
  </div>
</template>

<script>
  import { prettyTime } from '../../video-player/helpers/helpers'
  import computed from './computed'
  import mouseMixin from './mouse'

  export default {
    props: {
      duration: {
        type: Number,
        default: 0,
      },
      start: {
        type: Number,
        default: 0,
      },
      end: {
        type: Number,
        default: 0,
      },
    },

    mixins: [mouseMixin],

    data() {
      return {
        overHandle: false,
        overSide: '',
        model: {
          start: 0,
          end: 0,
        },
        handleSideWidth: 15,
        containerWidth: 0,
        sliding: false,
        startState: {
          start: 0,
          end: 0,
          x: 0,
          pixVal: 0,
        },

        onHandle: {
          mouseenter: () => (this.overHandle = true),
          mouseleave: () => (this.overHandle = false),
        },
        onLeft: {
          mouseenter: () => this.onEnterSide('left'),
          mouseleave: () => this.onLeaveSide(),
          click: () => this.onSideClick('start'),
        },
        onRight: {
          mouseenter: () => this.onEnterSide('right'),
          mouseleave: () => this.onLeaveSide(),
          click: () => this.onSideClick('end'),
        },
      }
    },
    computed,

    methods: {
      onSlidingLeft() {
        this.$emit('start', this.model.start)
      },
      onSlidingRight() {
        this.$emit('end', this.model.end)
      },
      onSlidingBoth() {
        this.$emit('rage', this.model)
      },

      onSideClick(key) {
        this.$emit(key, this.model[key])
      },

      onEnterSide(lr) {
        if (!this.sliding) this.overSide = lr
      },
      onLeaveSide() {
        if (!this.sliding) this.overSide = ''
      },

      setStart(v) {
        this.model.start = Math.floor(v)
      },

      setEnd(v) {
        this.model.end = Math.floor(v)
      },

      setup() {
        const end = this.end ? this.end : this.duration ? this.duration : 0
        const start = this.start ? this.start : 0
        this.setEnd(end)
        this.setStart(start)
      },
    },

    mounted() {
      this.containerWidth = this.$refs.container.offsetWidth
    },

    beforeMount() {
      if (this.start) this.setStart(this.start)
      if (this.end) this.setEnd(this.end)
      else if (this.duration) this.setEnd(this.duration)
    },

    filters: {
      pretty(v) {
        return prettyTime(v)
      },
    },
  }
</script>
