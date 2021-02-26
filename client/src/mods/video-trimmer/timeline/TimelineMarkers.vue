<template>
  <div>
    <div
      v-for="(n, i) in durMins"
      :key="`min${n}`"
      class="video-trimmer-timeline-min"
      :style="`position:absolute;left:${i * minWidth}px`"
    >
      <span v-if="n > 1" class="video-trimmer-timeline-min-label">{{
        getGridValue(i)
      }}</span>

      <div
        v-for="(s, ii) in 6"
        :key="`m${n}s${s}`"
        class="video-trimmer-timeline-sec"
        :class="ii == 3 ? 'video-trimmer-timeline-sec-30' : ''"
        :style="`left:${secWidth * ii}px`"
      ></div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      duration: {
        type: Number,
        default: 0,
      },
      containerWidth: {
        type: Number,
        default: 0,
      },
    },

    data() {
      return {
        // gridRatio: 0,
      }
    },

    computed: {
      gridRatio() {
        let val = Math.ceil(this.duration / 60)

        let digits = Math.floor(val / 30)

        if (digits > 19) return 30
        if (digits > 9) return 15
        if (digits > 5) return 10
        if (digits > 1) return 5

        return 1
      },

      durMins() {
        const val = Math.ceil(this.duration / 60)
        return Math.ceil(val / this.gridRatio)
      },
      minWidth() {
        // minimum minWidth
        return this.containerWidth / this.durMins
      },
      secWidth() {
        return this.minWidth / 6
      },
    },

    methods: {
      getGridValue(n) {
        return n * this.gridRatio
      },
    },
  }
</script>
