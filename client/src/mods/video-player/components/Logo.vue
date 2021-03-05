<template>
  <v-hover v-slot="{ hover }">
    <a
      class="video-player-logo"
      :style="
        `${x}:10px;${y}:${controls && y == 'bottom' ? 10 : 10}px;opacity:${
          opacity && !hover ? opacity : 1
        }`
      "
      :href="href || null"
      :target="href ? '_blank' : ''"
      :class="controls ? 'mb-12' : ''"
      @click="onClick"
    >
      <!-- <v-avatar :size="size || 75" :tile="tile"> -->
      <v-img
        :src="src"
        :contain="contain"
        :max-width="size || 75"
        :max-height="size || 75"
        :width="round ? size : ''"
        :height="round ? size : ''"
        :class="round ? 'rounded-circle' : ''"
      ></v-img>
      <!-- </v-avatar> -->
    </a>
  </v-hover>
</template>

<script>
  export default {
    props: {
      controls: Boolean,
      contain: Boolean,
      round: Boolean,
      tile: Boolean,
      src: {
        type: String,
        default: '',
      },
      href: {
        type: String,
        default: '',
      },
      size: {
        type: [String, Number],
        default: '',
      },
      position: {
        type: String,
        default: 'tl',
      },
      opacity: {
        type: [String, Number],
        default: 0,
      },
    },

    computed: {
      y() {
        return this.position.indexOf('t') > -1 ? 'top' : 'bottom'
      },
      x() {
        return this.position.indexOf('l') > -1 ? 'left' : 'right'
      },
    },

    methods: {
      onClick() {
        if (this.href) this.$emit('click')
      },
    },
  }
</script>
