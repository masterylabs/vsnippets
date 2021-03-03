<template>
  <div v-if="active" class="video-player-end-poster">
    <a v-if="href" :href="href" target="_blank">
      <v-img :src="src" :contain="contain ? true : false" />
    </a>

    <v-img v-else :src="src" :contain="contain ? true : false" />
  </div>
</template>

<script>
  export default {
    props: {
      active: [Boolean, String],
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
  .video-player-end-poster {
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
