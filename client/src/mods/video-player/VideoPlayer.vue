<template>
  <div
    ref="player-wrap"
    :class="`video-player-wrap video-player--${getPlayerState}`"
    :style="wrapStyle"
  >
    <v-card @mousemove="onMousemove" tile>
      <v-responsive :aspect-ratio="aspectRatio" :style="wrapStyle">
        <div
          ref="container"
          class="video-player-video-container"
          :style="invisibleVideo ? 'opacity:0' : ''"
        >
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

            <vue-vimeo-player
              v-if="videoType === 'vimeo'"
              ref="vimPlayer"
              v-bind="vimAttrs"
              v-on="vimOn"
              class="video-player-vim"
            />

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

          <div class="video-player-content"><slot name="content" /></div>
        </div>

        <video-player-mask v-on="maskOn" />

        <video-player-poster v-if="attrs.poster" v-bind="posterAttrs" />

        <video-player-end-poster
          v-if="showEndPoster"
          v-bind="endPosterAttrs"
          v-on="endPosterOn"
        />

        <video-player-pause-banner
          v-if="showPauseBanner"
          v-bind="pauseBannerAttrs"
          v-on="pauseBannerOn"
        />
        <video-player-logo
          v-bind="logo"
          @click="pause"
          :controls="showControls"
        />

        <video-player-promo-alert
          v-if="showPromoAlert"
          v-bind="promoAlertAttrs"
          v-on="promoAlertOn"
          style="z-index:10000"
        />

        <!-- CONTROLS -->
        <v-expand-transition v-if="isValidVideo || previewMode">
          <video-player-controls
            v-if="showControls"
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
          v-if="canPlay && !attrs.noCenterPlay && !endPosterNoControls"
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
    <!-- <div
      id="myVideo"
      data-vimeo-id="14213714"
      data-vimeo-width="1280"
      data-vimeo-height="720"
    ></div> -->
    <!-- <div id="vimPlayer" ref="vimeoPlayer" v-on="vimOn"></div> -->
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
