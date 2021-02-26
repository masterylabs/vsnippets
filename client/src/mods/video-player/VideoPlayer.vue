<template>
  <div
    ref="player-wrap"
    :class="`video-player-wrap video-player--${getPlayerState}`"
    :style="wrapStyle"
  >
    <v-card v-if="src" @mousemove="onMousemove">
      <v-responsive :aspect-ratio="aspectRatio" :style="wrapStyle">
        <div ref="container" class="video-player-video-container">
          <template v-if="isValidVideo">
            <video
              v-if="videoType == 'file'"
              ref="video"
              v-bind="videoAttrs"
              v-on="videoOn"
            >
              <source :src="attrs.src" type="video/mp4" />
              <track v-if="videoCaptionsTrack" v-bind="videoCaptionsTrack" />
            </video>
            <div ref="player" :id="`${playerId}_player`" />
          </template>
          <template v-else>
            <slot name="no-video">
              <v-row
                align="center"
                justify="center"
                style="height:100%"
                no-gutters
              >
                <div>
                  <v-icon size="100" color="grey lighten-2">mdi-youtube</v-icon>
                </div>
              </v-row>
            </slot>
          </template>
        </div>

        <video-player-mask v-on="maskOn" />

        <video-player-poster v-if="attrs.poster" v-bind="posterAttrs" />

        <!-- CONTROLS -->
        <v-expand-transition v-if="isValidVideo">
          <video-player-controls
            v-if="isOver || isOverControls || attrs.lockControls"
            v-bind="controlsAttrs"
            v-on="controlsOn"
            @mouseenter="onMouseenterControls"
            @mouseleave="onMouseleaveControls"
          >
            <video-player-play-btn
              v-if="attrs.usePlay"
              slot="play-btn"
              v-bind="playAttrs"
              v-on="playOn"
            />
            <video-player-timeline
              v-if="attrs.useTimeline"
              slot="timeline"
              v-bind="timelineAttrs"
              v-on="timelineOn"
            />
            <video-player-captions-btn
              v-if="attrs.useCaptions"
              slot="captions-btn"
              v-bind="captionsBtnAttrs"
              v-on="captionsBtnOn"
            />
            <video-player-settings-btn
              v-if="attrs.useSettings"
              slot="settings-btn"
              v-bind="settingsBtnAttrs"
              v-on="settingsBtnOn"
            />
            <video-player-volume-btn
              v-if="attrs.useVolume"
              slot="volume-btn"
              v-bind="volumeBtnAttrs"
              v-on="volumeBtnOn"
            />
            <video-player-fullscreen-btn
              v-if="attrs.useFullscreen"
              slot="fullscreen-btn"
              v-bind="fullscreenBtnAttrs"
              v-on="fullscreenBtnOn"
            />
          </video-player-controls>
        </v-expand-transition>

        <!-- CENTER PLAY -->
        <video-player-center-play
          v-if="canPlay && !attrs.noCenterPlay"
          v-bind="centerPlayAttrs"
          v-on="centerPlayOn"
        />

        <v-fade-transition>
          <video-player-loading v-if="isLoading" v-bind="loadingAttrs" />
        </v-fade-transition>

        <!-- SETTINGS -->
        <v-expand-transition>
          <video-player-settings
            v-show="isSettings"
            v-bind="settingsAttrs"
            v-on="settingsOn"
          >
            <video-player-captions
              v-if="attrs.useCaptions"
              slot="captions"
              v-bind="captionsAttrs"
              v-on="captionsOn"
            />
            <video-player-playback-rate
              slot="playback-rate"
              v-bind="playbackRateAttrs"
              v-on="playbackRateOn"
            />
          </video-player-settings>
        </v-expand-transition>
      </v-responsive>
    </v-card>

    <!-- <dev-raw :value="{ playerState }" /> -->

    <slot
      name="below"
      :currentTime="currentTime"
      :duration="duration"
      :playerState="getPlayerState"
      :isValidVideo="isValidVideo"
    />
  </div>
</template>

<script>
  import js from './video-player'
  export default js
</script>
