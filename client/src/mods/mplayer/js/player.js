import YouTubePlayer from 'youtube-player'
import props from './yt-vars'
const stateNames = {
	'-1': 'unstarted',
	0: 'ended',
	1: 'playing',
	2: 'paused',
	3: 'buffering', // seeking
	5: 'cued', // video cued
}

class Player {
	pendingPause = false
	isPlayerReady = false
	isVideoReady = false
	// isVideoReady = false
	isCaptions = false
	isVideoLoading = false
	isMuted = false
	playerId = 'mplayer'
	playerVars = props.playerVars
	videoId = ''

	// set on load
	videoTitle = ''
	duration = 0

	// test
	target = {}

	events = {}

	volume = 1

	playerState = 'unstarted'
	currentTime = 0

	/**
	 * methods
	 * */

	// toggleCaptions = () => {
	// 	this.player.loadModule('captions')
	// }

	seekTo = (n) => {
		// this.player.currentTime = n
		if (!['ready', 'paused', 'ended'].includes(this.playerState)) {
			return this.player.seekTo(n, true)
		}

		// seek and stop
		this.pendingPause = true
		this.player.seekTo(n, true)
		this.player.playVideo()
	}

	setMute = (value = true) => {
		if (value) return this.mute()
		this.unmute()
	}

	setVolume = (value) => {
		this.volume = value
		const ytVol = Math.floor(value * 100)
		// youtube
		this.player.setVolume(ytVol)
	}

	mute = () => {
		this.player.mute()
		this.isMuted = true
	}

	unmute = () => {
		this.player.unMute()
		this.isMuted = false
	}

	togglePlay = () => {
		if (['playing', 'buffering'].includes(this.playerState)) {
			return this.player.pauseVideo()
		}
		this.player.playVideo()
	}

	onTimeUpdate = (ct) => {
		this.currentTime = ct
		if (this.events.currentTime) this.events.currentTime(ct)
	}

	pause = () => {
		this.player.pauseVideo()
	}

	play = () => {
		this.player.playVideo()
	}

	on = (eventName, func) => {
		this.events[eventName] = func
	}

	constructor(options = {}) {
		this.videoId = options.src
		this.loadPlayer()
	}

	destroy = () => {
		if (this.player && typeof this.player.destroy == 'function') {
			this.player.destroy()
		}
		let keys = Object.keys(this)
		keys.forEach((key) => {
			delete this[key]
		})
		keys = null
	}

	/**
	 * Events
	 */

	// setPlaybackQuality
	// setPlaybackRate

	onReady = ({ target }) => {
		this.target = target

		this.duration = target.getDuration()

		// this.mute()

		if (typeof target.getVideoData == 'function') {
			// const videoData = target.getVideoData()

			const { title } = target.getVideoData()
			this.videoTitle = title

			if (this.events.title) this.events.title(title)
		}

		this.isPlayerReady = true

		if (this.videoId) this.isVideoReady = true

		if (this.events.ready) {
			this.events.ready(this.duration)
		}

		this.onStateChange('ready')

		this.youtubeTicker()
	}

	onStateChange = (playerState) => {
		this.playerState = playerState

		if (this.events.stateChange) this.events.stateChange(playerState)

		this.youtubeUpdateTime()

		this.target.hideVideoInfo()

		if (this.pendingPause && playerState == 'playing') {
			this.pendingPause = false
			this.pause()
		}
	}

	/**
	 * Getters
	 */

	/**
	 * Loaders
	 */

	loadVideo = (videoId) => {
		this.isVideoReady = false
		this.player.cueVideoById(videoId) // no title
	}

	loadVideoWithTitle = (videoId) => {
		// return this.loadVideo(videoId)
		this.videoId = videoId
		this.player.destroy()
		this.loadPlayer()
	}

	loadPlayer = () => {
		//
		const args = {
			// height: 720,
			// width: 1280,
			playerVars: this.playerVars,
		}

		if (this.videoId) args.videoId = this.videoId

		const player = YouTubePlayer(this.playerId, args)

		player.on('ready', this.onReady)

		player.on('stateChange', (event) => {
			if (!stateNames[event.data]) {
				throw new Error('Unknown state (' + event.data + ').')
			}

			this.onStateChange(stateNames[event.data])
		})

		this.player = player
	}

	currentTime = 0

	youtubeTicker = () => {
		if (this.ticker) return
		this.ticker = setInterval(() => {
			if (this.playerState == 'playing') this.youtubeUpdateTime()
		}, 300)
	}

	youtubeUpdateTime = () => {
		const ct = this.target.getCurrentTime()

		if (ct != this.currentTime) this.onTimeUpdate(ct)
	}
}

export default Player
