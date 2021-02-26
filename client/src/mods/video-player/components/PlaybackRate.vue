<template>
  <v-row no-gutters align="center">
    <v-tooltip left>
      <template v-slot:activator="{ on, attrs }">
        <v-icon v-on="on" v-bind="attrs" :color="val != 3 ? color : 'grey lighten-1'" @click="reset"
          >mdi-speedometer{{ getIcon }}</v-icon
        >
      </template>
      <span>Playback Speed</span>
    </v-tooltip>

    <v-col class="px-3">
      <v-slider
        v-model="val"
        max="7"
        :color="color"
        ticks="always"
        tick-size="4"
        hide-details
        thumb-label
        track-color="grey lighten-2"
        @input="input"
      >
        <template v-slot:thumb-label="{ value }">
          {{ items[value] }}
        </template>
      </v-slider>
    </v-col>
  </v-row>
</template>

<script>
  export default {
    props: {
      color: {
        type: String,
        default: '',
      },
      value: {
        type: [Number, String],
        default: 1,
      },
    },
    data() {
      return {
        val: 3,
        items: [0.25, 0.5, 0.75, 1, 1.25, 1.5, 1.75, 2],
      }
    },

    computed: {
      getIcon() {
        const v = this.items[this.val]

        return v > 1 ? '' : v < 1 ? '-slow' : '-medium'
      },
    },

    methods: {
      input(i) {
        const v = this.items[i]
        this.$emit('change', v)
      },
      reset() {
        this.val = 3
        this.input(3)
      },
    },
  }
</script>
