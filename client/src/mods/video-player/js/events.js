import eventsPlayer from './events-player'
export default {
	...eventsPlayer,

	onReady() {
		this.playerState = 'ready'
		console.log('onReady', this.duration)
	},

	onTimelineClick(n) {
		this.seekTo(n)
	},

	// onEnded() {
	// 	console.log('ENDED')
	// },

	// onPause() {
	// 	console.log('pause')
	// },

	// onPlay() {
	// 	console.log('play')
	// },
}
