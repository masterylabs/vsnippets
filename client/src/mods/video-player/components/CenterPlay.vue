<template>
  <v-row
    class="video-player-center-play"
    no-gutters
    align="center"
    justify="center"
  >
    <v-btn
      :large="large"
      :height="height"
      :width="width"
      :x-large="xLarge"
      :color="color"
      :dark="dark"
      :fab="fab"
      :icon="icon"
      :tile="tile"
      @click="$emit('click')"
    >
      <v-icon :size="size" v-text="ended ? 'mdi-replay' : 'mdi-play'" />
    </v-btn>
  </v-row>
</template>

<script>
  export default {
    props: {
      // canPlay: Boolean,
      xLarge: Boolean,
      large: Boolean,
      dark: Boolean,
      fab: Boolean,
      icon: Boolean,
      tile: Boolean,
      ended: Boolean,
      size: {
        type: [Number, String],
        default: 40,
      },
      height: {
        type: [Number, String],
        default: 50,
      },
      width: {
        type: [Number, String],
        default: 80,
      },

      color: {
        type: String,
        default: 'primary',
      },
      iconColor: {
        type: String,
        default: 'primary',
      },
    },

    computed: {
      getIconColor() {
        if (this.iconColor) return this.iconColor

        return this.dark ? '#fff' : '#000'
      },
    },
  }
</script>
