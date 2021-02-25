import options from './options'
import { deepMerge } from '../mixins/helpers'

export default {
	props() {
		let k
		const propValue = {}
		for (k in options) if (this[k] != null) propValue[k] = this[k]

		return deepMerge(options, propValue)
	},

	videoType() {
		const src = this.props.src
		return !src ? '' : !isNaN(src) ? 'vimeo' : src.length == 11 ? 'youtube' : 'file'
	},

	aspectRatio() {
		if (!this.videoWidth || !this.videoHeight) {
			return 1.7777777777777777 // 16 / 9
		}
		return this.videoWidth / this.videoHeight
	},

	player() {
		return this.videoType == 'file' ? this.$refs.video : this.$refs.player
	},

	canPlay() {
		return ['ready', 'paused', 'ended'].includes(this.playerState)
	},

	canPause() {
		return ['playing', 'seeked'].includes(this.playerState)
	},

	wrapStyle() {
		const style = {}

		if (this.fullscreenMaxHeight) {
			style.maxHeight = `${this.fullscreenMaxHeight}px`
		}

		return style
	},

	controlsProps() {
		return {
			...this.props.controls,
			canPlay: this.canPlay,
			canPause: this.canPause,
			currentTime: this.currentTime,
			duration: this.duration,
			defaultColor: this.props.color,
			defaultDark: this.props.dark,
			isFullscreen: this.isFullscreen,
			isMuted: this.isMuted,
			volume: this.volume,
		}
	},
}
