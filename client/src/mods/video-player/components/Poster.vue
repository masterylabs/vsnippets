<template>
  <div class="video-player-poster">
    <v-img v-if="show" :src="src" width="100%" height="100%"></v-img>
  </div>
</template>

<script>
  export default {
    props: {
      inStart: Boolean,
      posterOnPause: Boolean,
      src: {
        type: String,
        default: '',
      },
      playerState: {
        type: String,
        default: '',
      },
    },

    computed: {
      show() {
        if (this.posterOnPause && this.playerState == 'paused') return true
        return ['unstarted', 'ready', 'ended'].includes(this.playerState) || this.inStart
      },
    },

    methods: {
      //
    },

    mounted() {},
  }
</script>
