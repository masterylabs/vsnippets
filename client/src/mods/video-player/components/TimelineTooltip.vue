<template>
  <div
    class="video-player-tooltip-container"
    :class="[isProgress ? 'video-player-tooltip-progress' : '', easing ? 'video-player-tooltip-easing' : '']"
    :style="`left:${left}${px ? 'px' : '%'}`"
  >
    <div
      class="video-player-tooltip text-center"
      :class="inverse ? 'video-player-tooltip-inverse' : ''"
      :style="`background:${color};color:${textColor}`"
    >
      <template v-if="noFormat">{{ value }}</template>
      <template v-else>{{ value | pretty }}</template>
    </div>
  </div>
</template>

<script>
  import { prettyTime } from '../helpers/helpers'
  export default {
    props: {
      isProgress: Boolean,
      inverse: Boolean,
      noFormat: Boolean,
      easing: Boolean,
      px: Boolean,
      left: {
        type: Number,
        default: 0,
      },
      value: {
        type: Number,
        default: 0,
      },
      color: {
        type: String,
        default: '#fff',
      },
      textColor: {
        type: String,
        default: '',
      },
    },
    filters: {
      pretty(t) {
        return prettyTime(t)
      },
    },
  }
</script>
