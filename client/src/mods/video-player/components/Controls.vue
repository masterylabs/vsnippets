<template>
  <div class="video-player-controls">
    <v-card tile flat :style="`height:${height}px`" color="rgba(0,0,0,0)">
      <v-row class="video-player-controls" :align="align" no-gutters>
        <slot v-if="play" name="play-btn" />

        <div v-if="timeline" class="grow">
          <slot v-if="timeline" name="timeline" class="video-player-controls--timeline" />
        </div>

        <slot name="captions-btn" />
        <slot name="settings-btn" />
        <slot name="volume-btn" />
        <slot name="fullscreen-btn" />

        <!--  <video-player-controls-play-btn
          v-if="play"
          v-bind="buttonProps"
          :can-play="canPlay"
          :can-pause="canPause"
          class="video-player-controls--btn"
          @click="$emit('play')"
          @mouseenter="$emit('mouseenter')"
          @mouseleave="$emit('mouseleave')"
        />

       

        <video-player-controls-btn
          v-if="captions"
          v-bind="buttonProps"
          :mdi="`closed-caption${isCaptions ? '' : '-outline'}`"
          class="video-player-controls--btn"
          @click="$emit('toggleCaptions')"
        />

        <video-player-controls-btn
          v-if="settings"
          v-bind="buttonProps"
          mdi="cog"
          class="video-player-controls--btn"
          @click="$emit('settings')"
        />

        <video-player-controls-volume-btn
          v-bind="buttonProps"
          :volume="volume"
          :is-muted="isMuted"
          class="video-player-controls--btn"
          @volume="$emit('volume', $event)"
          @toggleMute="$emit('toggleMute', $event)"
        />

        <video-player-controls-fs-btn
          v-bind="buttonProps"
          :is-fullscreen="isFullscreen"
          class="video-player-controls--btn"
          @click="$emit('fullscreen')"
        />
        -->
      </v-row>
    </v-card>
  </div>
</template>

<script>
  export default {
    props: {
      // states
      isFullscreen: Boolean,
      isMuted: Boolean,
      canPlay: Boolean,
      canPause: Boolean,
      isCaptions: Boolean,

      // bool includes
      play: Boolean,
      timeline: Boolean,
      captions: Boolean,
      settings: Boolean,
      sound: Boolean,
      fullscreen: Boolean,

      // bools design
      icon: Boolean,
      tile: Boolean,
      depressed: Boolean,
      dark: Boolean,

      items: {
        type: Array,
        default() {
          return []
        },
      },

      volume: {
        type: Number,
        default: 1,
      },

      height: {
        type: [Number, String],
        default: 50,
      },
      align: {
        type: [String],
        default: 'center',
      },
      width: {
        type: [Number, String],
        default: 50,
      },
      size: {
        type: [Number, String],
        default: 50,
      },
      color: {
        type: String,
        default: '',
      },
      iconColor: {
        type: String,
        default: '',
      },
    },

    data() {
      return {
        isSettings: false,
      }
    },

    computed: {
      buttonProps() {
        return {
          height: this.height,
          width: this.width,
          size: this.size,
          icon: this.icon,
          tile: this.tile,
          depressed: this.depressed,
          color: this.color,
          dark: this.dark,
          iconColor: this.iconColor,
        }
      },
    },
  }
</script>
