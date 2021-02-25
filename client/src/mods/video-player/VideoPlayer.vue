<template>
	<div ref="player-wrap" :class="`video-player-wrap video-player--${playerState}`" :style="wrapStyle">
		<v-card>
			<v-responsive :aspect-ratio="aspectRatio" :style="wrapStyle">
				<div class="video-player-video-container">
					<video
						v-if="videoType == 'file'"
						ref="video"
						:src="props.src"
						@loadedmetadata="onLoadedetadata"
						@pause="onPause"
						@play="onPlay"
						@playing="onPlaying"
						@progress="onProgress"
						@ratechange="onRatechange"
						@seeked="onSeeked"
						@seeking="onSeeking"
						@stalled="onStalled"
						@suspend="onSuspend"
						@timeupdate="onTimeupdate"
						@volumechnage="onVolumechange"
						@waiting="onWaiting"
						@durationchange="onDurationchange"
						@canplay="onCanplay"
						@canplaythrough="onCanplaythrough"
					/>
					<div v-else ref="player" />
				</div>
				<v-expand-transition>
					<video-player-controls
						v-bind="controlsProps"
						@play="togglePlay"
						@timeline="onTimelineClick"
						@fullscreen="toggleFullscreen"
						@toggle-mute="toggleMute"
						@volume="setVolume"
					/>
				</v-expand-transition>
			</v-responsive>
		</v-card>

		<dev-raw :value="controlsProps"></dev-raw>
	</div>
</template>

<script>
import props from './js/props'
import data from './js/data'
import computed from './js/computed'
import watch from './js/watch'
import events from './js/events'
import methods from './js/methods'
import fullscreenMixin from './mixins/fullscreen'

export default {
	props,
	mixins: [fullscreenMixin],
	data,
	computed,
	watch,
	methods: {
		...events,
		...methods,
	},
	mounted() {
		// this.loadPlayer()
	},
}
</script>
