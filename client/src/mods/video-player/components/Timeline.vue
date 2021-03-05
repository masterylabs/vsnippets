<template>
  <v-hover v-slot="{ hover }">
    <div
      ref="timeline"
      class="video-player-timeline white--text"
      :style="{ height: `${height}px` }"
      @mousemove="onMousemove"
      @mousedown="onMousedown"
    >
      <div class="video-player-timeline-click" v-on:click="onClick">
        <div
          class="video-player-timeline-bg"
          :style="{ background: color, opacity: bgOpacity }"
        />
        <v-row
          no-gutters
          align="center"
          justify="end"
          style="height:100%"
          class="video-player-timeline-progress"
          :style="{
            background: progressColor || color,
            opacity: progressOpacity,
            width: `${progressWidth}%`,
            borderRight: `1px solid ${iconColor}`,
          }"
        >
          <div class="mr-n11x mr-2"></div>
        </v-row>

        <v-row
          v-if="hover && duration"
          no-gutters
          align="center"
          justify="end"
          style="height:100%"
          class="video-player-timeline-preview"
          :style="{
            ...preview,
            width: `${previewLeft}px`,
            borderRight: `1px solid ${color}`,
          }"
        >
          <div :class="previewTextRight ? 'mr-n5' : 'mr-2'"></div>
        </v-row>
      </div>

      <template v-if="!noTooltips">
        <v-fade-transition>
          <video-player-timeline-tooltip
            v-if="hover && duration"
            :left="previewLeft"
            :value="previewValue"
            px
            :color="color"
            :text-color="iconColor"
          />
        </v-fade-transition>
        <v-fade-transition>
          <video-player-timeline-tooltip
            v-if="hover && duration"
            :left="progressWidth"
            :value="currentTime"
            :color="iconColor"
            :text-color="color"
            is-progress
            easing
          />
        </v-fade-transition>
      </template>

      <div
        v-if="showCurrentTime || showDuration"
        class="video-player-timeline-times"
      >
        <v-row
          class="mx-3"
          align="center"
          :justify="!showCurrentTime ? 'end' : 'space-between'"
          style="height:100%"
          no-gutters
        >
          <div v-if="showCurrentTime">{{ currentTime | pretty }}</div>
          <div v-if="showDuration">{{ duration | pretty }}</div>
        </v-row>
      </div>
    </div>
  </v-hover>
</template>

<script>
  import { prettyTime } from '../helpers/helpers'
  export default {
    props: {
      showCurrentTime: Boolean,
      showDuration: Boolean,
      dark: {
        type: Boolean,
        default: null,
      },
      noTooltips: Boolean,
      currentTime: {
        type: Number,
        default: 0,
      },
      duration: {
        type: Number,
        default: 60,
      },
      height: {
        type: [String, Number],
        default: 40,
      },
      color: {
        type: String,
        default: '',
      },
      progressColor: {
        type: String,
        default: '',
      },
      bgOpacity: {
        type: [String, Number],
        default: 0.4,
      },
      progressOpacity: {
        type: [String, Number],
        default: 0.65,
      },

      defaultColor: {
        type: String,
        default: '',
      },
      defaultDark: {
        type: Boolean,
        default: true,
      },

      progress: {
        type: Object,
        default() {
          return {}
        },
      },
      preview: {
        type: Object,
        default() {
          return {}
        },
      },
      iconColor: {
        type: String,
        default: '',
      },
    },

    data() {
      return {
        previewLeft: 0,
        previewWidth: 50,
        isDrag: 0,
        dragWait: null,
        isMounted: false,
      }
    },

    computed: {
      progressWidth() {
        // if (!this.duration || !this.$refs.timeline) return 0 // start animation from left
        if (!this.duration || !this.isMounted) return 0 // start animation from left
        // const progress = this.currentTime / this.duration
        // const value = progress * 100
        // const width = Math.floor(width)

        return Math.floor((this.currentTime / this.duration) * 100)
      },
      previewValue() {
        if (!this.isMounted) return 0
        // if (!this.$refs.timeline) return 0

        let value = this.previewLeft / this.$refs.timeline.clientWidth
        value = value * this.duration

        if (value < 1) value = 0
        else if (value > this.duration - 1) value = this.duration

        return Math.floor(value)
      },
      previewTextRight() {
        return this.previewLeft < 25 ? true : false
      },
    },

    methods: {
      onClick({ offsetX }) {
        let value = (offsetX / this.$refs.timeline.clientWidth) * this.duration
        this.$emit('click', value)
      },
      onMousemove({ offsetX }) {
        this.previewLeft = offsetX || 0

        if (this.isDrag) {
          clearTimeout(this.dragWait)
          this.dragWait = setTimeout(() => {
            this.onClick({ offsetX })
          }, 10)
        }
      },
      onMousedown() {
        this.isDrag = true
      },

      onMouseup() {
        if (this.isDrag) {
          clearTimeout(this.dragWait)
          this.isDrag = false
        }
      },
    },

    beforeDestroy() {
      document.removeEventListener('mouseup', this.onMouseup)
    },

    mounted() {
      document.addEventListener('mouseup', this.onMouseup)

      this.isMounted = true
    },
    filters: {
      pretty(t) {
        return prettyTime(t)
      },
    },
  }
</script>
