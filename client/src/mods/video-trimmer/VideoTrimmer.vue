<template>
  <div>
    <video-player
      v-if="value.src"
      v-bind="value"
      :remote-seek-to-and-pause="seekToAndPause"
      get-info
      @info="onInfo"
    >
      <template v-slot:below="{ currentTime, duration, isValidVideo }">
        <v-fade-transition>
          <video-trimmer-timeline
            v-if="duration"
            class="mt-11"
            :duration="duration"
            v-bind="timelineAttrs"
            v-on="onTimeline"
          />
        </v-fade-transition>

        <v-progress-linear
          v-if="!duration && isValidVideo"
          class="mt-10"
          striped
          indeterminate
          height="60"
          color="yellow lighten-4"
        />
        <!-- <dev-raw
          :value="{ currentTime, duration, isValidVideo, value }"
          title="VideoTrimmer"
        /> -->
      </template>
    </video-player>
    <slot name="below" />
  </div>
</template>

<script>
  import vt from './video-trimmer'
  export default vt
</script>

<style scoped>
  .timeline-container {
    height: 60px;
    position: relative;
  }
  .timeline-handle-container {
    cursor: pointer;
    height: 70px;
    background: rgba(31, 105, 255, 0.3);
    position: absolute;
    left: 0;
    top: 0;
    margin-top: -5px;
  }
  .timeline-handle {
    width: 20px;
    background: #1f69ff;
  }
</style>
