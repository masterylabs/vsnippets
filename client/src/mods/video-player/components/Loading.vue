<template>
  <v-row align="center" justify="center" class="video-player-loading" no-gutters>
    <v-progress-circular indeterminate :size="size" :color="color"></v-progress-circular>
  </v-row>
</template>

<script>
  export default {
    props: {
      color: {
        type: String,
        default: 'primary',
      },
      size: {
        type: [Number, String],
        default: 100,
      },
    },
  }
</script>
