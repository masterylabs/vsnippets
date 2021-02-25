export default {
	loadPlayer() {
		console.log('loadPlayer', this.props.src)
	},

	seekTo(n) {
		console.log('seekTo', n)
		// this.currentTime =
		this.setTime(n)
		this.player.currentTime = n
	},

	play() {
		console.log('play')
		this.playerState = 'play'
		this.player.play()
	},

	pause() {
		console.log('pause')
		this.playerState = 'pause'
		this.player.pause()
	},

	togglePlay() {
		if (this.canPlay) return this.play()
		this.pause()
	},

	toggleMute() {
		if (this.isMuted) return this.unmute()
		this.mute()
	},

	mute() {
		console.log('mute')
		this.isMuted = true
		this.player.muted = 1
	},

	unmute() {
		console.log('unmute')
		this.isMuted = false
		this.player.muted = 0
		if (this.volume < 1) this.setVolume(1)
	},

	setVolume(n) {
		this.volume = n
		this.player.volume = n
		console.log(n)
	},

	destroy() {
		// remove event listeners
	},

	setTime(n) {
		this.currentTime = Math.floor(n)
	},
}
