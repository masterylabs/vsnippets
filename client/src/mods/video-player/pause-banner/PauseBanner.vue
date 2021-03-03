<template>
  <div v-if="active" class="video-player-pause-banner">
    <v-card
      min-height="145"
      dark
      :height="!poster ? '161' : '100%'"
      :class="!poster ? 'mx-3 mb-3' : ''"
      tile
      elevation="0"
      :color="nobg ? 'rgba(0,0,0,0)' : ''"
      :href="href"
      target="_blank"
      @click="$emit('click')"
    >
      <v-img
        :src="src"
        :max-height="poster ? '' : '161'"
        :contain="contain ? true : false"
      ></v-img>
    </v-card>
  </div>
</template>

<script>
  export default {
    props: {
      active: [Boolean, String],
      poster: [Boolean, String],
      nobg: [Boolean, String],
      contain: [Boolean, String],
      src: {
        type: String,
        default: '',
      },
      href: {
        type: String,
        default: '',
      },
      maxShowWidth: {
        type: [Number, String],
        default: 554,
      },
    },
  }
</script>

<style>
  .video-player-pause-banner {
    position: absolute;
    bottom: 0px;
    /* 12px; */
    left: 0px;
    width: 100%;
    /* height: 157px; */
    z-index: 1;
    opacity: 1;
  }
</style>
