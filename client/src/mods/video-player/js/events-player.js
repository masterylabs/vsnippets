export default {
	onLoadedetadata(e) {
		this.videoWidth = this.$refs.video.videoWidth
		this.videoHeight = this.$refs.video.videoHeight
		this.duration = this.$refs.video.duration

		this.onReady()
	},
	onPause() {
		// console.log('onPause')
		this.playerState = 'paused'
	},
	onPlay() {
		// console.log('onPlay')
		this.playerState = 'play'
	},
	onPlaying() {
		// console.log('onPlaying')
		this.playerState = 'playing'
	},
	onProgress() {
		// console.log('onProgress')
	},
	onRatechange() {
		// console.log('onRatechange')
	},
	onSeeking() {
		this.playerState = 'seeking'
	},
	onSeeked() {
		// this.playerState = 'seeked'
		this.playerState = 'paused'
	},
	onStalled() {
		console.log('onStalled')
	},
	onSuspend() {
		console.log('onSuspend')
	},
	onTimeupdate(n) {
		this.setTime(this.player.currentTime)
		console.log('onTimeupdate', n)
	},
	onVolumechange() {
		console.log('onVolumechange')
	},
	onWaiting() {
		console.log('onWaiting')
	},
	onDurationchange() {
		console.log('onDurationchange')
	},
	onCanplay() {
		// console.log('onCanplay')
	},
	onCanplaythrough() {
		// console.log('onCanplaythrough')
	},
}
