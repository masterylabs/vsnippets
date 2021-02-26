<template>
  <div class="video-player-settings">
    <v-card width="270">
      <v-card-text>
        <slot name="playback-rate" />
        <slot name="captions" />
      </v-card-text>
    </v-card>

    <v-btn icon absolute top right x-small color="grey" class="mt-n3 mr-n3" @click="$emit('close')">
      <v-icon>mdi-close</v-icon>
    </v-btn>

    <slot />
  </div>
</template>

<script>
  export default {
    props: {
      toggle: Boolean,
      color: {
        type: String,
        default: '',
      },
      playbackRate: {
        type: Number,
        default: 1,
      },
    },
    data() {
      return {
        playbackRateOn: {
          //
        },
        captionsOn: {
          //
        },
      }
    },

    computed: {
      playbackRateAttrs() {
        return {
          value: 'PLAYBACK RATE ATT',
        }
      },

      captionsAttrs() {
        return {}
      },
    },
  }
</script>
