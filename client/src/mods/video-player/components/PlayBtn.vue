<template>
  <v-card v-bind="design" v-on="on" class="video-player-controls--btn">
    <v-row no-gutters align="center" justify="center" style="height:100%">
      <v-icon
        :color="design.iconColor"
        :size="design.size"
        v-text="`mdi-${ended ? 'replay' : canPlay ? 'play' : 'pause'}`"
      ></v-icon>
    </v-row>
  </v-card>
</template>

<script>
  import buttonMixin from '../mixins/controls/button'

  export default {
    props: {
      canPlay: Boolean,
      canPause: Boolean,
      ended: Boolean,
    },

    mixins: [buttonMixin],
  }
</script>
