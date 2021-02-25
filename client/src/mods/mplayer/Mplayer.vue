<template>
	<div>
		<div @mouseenter="onEnter" @mouseleave="onLeave">
			<!-- theAspectRatio: {{ theAspectRatio }} -->
			<div ref="mplayer-container" class="mplayer-container" :class="inFullscreen ? 'mplayer-in-fullscreen' : ''">
				<div ref="inner" class="mplayer-inner-container" :style="`padding-bottom: ${theAspectRatio}%;`">
					<div :id="playerId" ref="mplayer" class="mplayer-player mx-auto" />
				</div>

				<!-- Poster -->
				<mplayer-poster v-if="showPoster" :src="val.poster" />
				<mplayer-yt-mask @click="onMaskClick" />

				<v-fade-transition>
					<div v-if="showControls" class="mplayer-controls-bg" />
				</v-fade-transition>

				<!-- Topbar  -->
				<v-fade-transition v-if="val.useTopbar">
					<mplayer-topbar
						v-if="showTopbar"
						:title="val.title"
						:avatar="val.avatar"
						:avatar-href="val.avatarHref"
						:use-share="!isMobile && val.useShare"
						:color="val.titleColor"
						:text-color="val.titleTextColor"
						:no-title="val.noTitle"
						@share="isShare = true"
					/>
				</v-fade-transition>

				<v-fade-transition>
					<mplayer-loading v-if="showLoading" />
				</v-fade-transition>

				<mplayer-center-play
					v-if="showCenterPlay"
					:color="val.color"
					:inverse-color="val.inverseColor"
					:player-state="playerState"
					:is-icon="val.useSimplePlayBtn"
					@click="togglePlay"
				/>

				<!-- Controls  -->
				<v-fade-transition>
					<mplayer-controls v-if="showControls">
						<mplayer-play-btn
							slot="play"
							:player-state="playerState"
							:color="val.controlsColor"
							@click="togglePlay"
						/>

						<mplayer-volume
							slot="volume"
							class="mr-1"
							:value="volume"
							:muted="muted"
							:progress-color="val.color"
							:color="val.controlsColor"
							@mute="toggleMuted"
							@input="setVolume"
						/>
						<mplayer-display-time
							slot="display-time"
							:current-time="currentTime"
							:duration="duration"
							:color="val.controlsColor"
						/>

						<mplayer-fullscreen
							v-if="!isMobile && !val.noFullscreen"
							:color="val.controlsColor"
							slot="fullscreen"
							@click="toggleFullscreen"
						/>
					</mplayer-controls>
				</v-fade-transition>

				<!-- Timeline  -->
				<v-fade-transition v-if="!val.noTimeline">
					<mplayer-timeline
						v-if="showTimeline"
						:color="val.color"
						:current-time="currentTime"
						:duration="duration"
						@input="onTimeline"
					/>
				</v-fade-transition>

				<!-- Share -->
				<v-fade-transition>
					<mplayer-share v-if="isShare">
						<v-btn absolute right top icon dark large @click="isShare = false">
							<v-icon>mdi-close</v-icon>
						</v-btn>
					</mplayer-share>
				</v-fade-transition>
			</div>
		</div>
		<slot name="below" :currentTime="currentTime" :duration="duration" />
	</div>
</template>

<script>
import options from './js/options'
import Player from './js/player'
import { loadImage, getAspectRatio } from './js/helpers' // getAspectRatio
import { fullscreenMixin } from './js/mixins'
import props from './js/props'

export default {
	props,

	mixins: [fullscreenMixin],

	data() {
		return {
			isMobile: false,
			leaveWait: null,
			isCaptions: false,
			playerReady: false,
			topbarWait: null,
			containerWidth: 0,
			isOver: false,
			isOverDelay: false,
			muted: false,
			isPauseState: true,
			defaultPoster: '',
			volume: 0.5,
			playerState: 'unstarted',
			isShare: false,
			duration: 0,
			currentTime: 0,
			ticker: null,
			status: 'unstarted',
			player: {},
			defaultValue: {
				...options,
			},
		}
	},

	computed: {
		theAspectRatio() {
			let str = '16/9'

			if (this.val.aspectRatio) str = this.val.aspectRatio

			return getAspectRatio(str, true)
		},
		ratioHeight() {
			if (!this.playerReady || !this.containerWidth || !this.aspectRatio) return 0
			// return this.containerWidth
			return Math.ceil((1 / this.aspectRatio) * this.containerWidth)
		},
		val() {
			const values = {
				...this.defaultValue,
			}

			for (let k in values) {
				if (this[k] != null) values[k] = this[k]
			}

			return values
		},

		showLoading() {
			return ['unstarted', 'buffering'].includes(this.playerState)
		},

		showTimeline() {
			// return true
			return this.isOver || this.val.lockControls
		},
		showControls() {
			// return true
			if (this.val.noControls) return false
			return this.isOver || this.val.lockControls
		},
		showCenterPlay() {
			return ['ready', 'paused', 'ended'].includes(this.playerState)
		},
		showPoster() {
			if (this.val.posterOnPause && (this.isPauseState || this.playerState == 'paused')) return true
			return ['unstarted', 'buffering', 'ready', 'ended'].includes(this.playerState)
		},

		showTopbar() {
			return ['unstarted', 'ready', 'ended', 'paused'].includes(this.playerState) || this.isOverDelay
		},
	},

	methods: {
		onEnter() {
			this.isOver = true
			this.isOverDelay = true
		},
		onLeave() {
			clearTimeout(this.leaveWait)
			this.leaveWait = setTimeout(() => {
				this.isOver = false
				this.leaveWait = setTimeout(() => {
					this.isOverDelay = false
				}, 2400)
			}, 1000)
		},

		onTimeline(n) {
			this.player.seekTo(n)
		},

		onMaskClick() {
			this.player.togglePlay()
		},

		toggleMuted() {
			this.muted = !this.muted
			this.player.setMute(this.muted)
		},

		setVolume(value) {
			this.volume = value
			this.player.setVolume(value)
		},

		togglePlay() {
			this.isPauseState = this.playerState == 'playing' ? true : false
			this.player.togglePlay()
		},
	},

	beforeDestroy() {
		if (this.player.destroy) this.player.destroy()
	},

	async beforeMount() {
		if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
			// true for mobile device
			this.isMobile = true
		}
		// load backup image
		if (this.val.src && !this.val.poster) {
			const videoId = this.val.src
			this.defaultValue.poster = `https://i.ytimg.com/vi/${videoId}/default.jpg`
			console.log('setposter default', this.defaultValue.poster)

			let url = `https://i.ytimg.com/vi/${videoId}/maxresdefault.jpg`

			let size = await loadImage(url)

			if (size.width && size.width > 120) {
				this.defaultValue.poster = url
				console.log('setposter maxresdefault', url)
			} else {
				url = `https://i.ytimg.com/vi/${videoId}/hqdefault.jpg`
				size = await loadImage(url)

				if (size.width && size.width > 120) {
					this.defaultValue.poster = url
					console.log('setposter hqdefault', url)
				}
			}
		}
	},

	mounted() {
		this.player = new Player({ ...this.val })
		this.player.on('title', (title) => {
			this.defaultValue.title = title
		})
		this.player.on('ready', (dur) => {
			this.duration = dur
			this.muted = this.player.isMuted
			this.playerState = 'ready'
			this.playerReady = true
		})

		this.player.on('stateChange', (status) => {
			this.playerState = status
		})

		this.player.on('currentTime', (currentTime) => {
			this.currentTime = currentTime
		})
	},
}
</script>
