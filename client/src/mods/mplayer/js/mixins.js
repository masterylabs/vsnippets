export const itemMixin = {
	props: {
		item: {
			type: Object,
			default() {
				return {}
			},
		},
	},
}

export const fullscreenMixin = {
	data() {
		return {
			fixedHeight: '',
			inFullscreen: false,
			mouseMoveWait: null,
		}
	},

	methods: {
		onFullscreenMouseMove() {
			this.isOver = true

			if (this.mouseMoveWait) {
				clearTimeout(this.mouseMoveWait)
			}

			this.mouseMoveWait = setTimeout(() => {
				this.isOver = false
			}, 1000)
		},

		onFullscreenChange() {
			if (document.fullscreenElement) {
				this.inFullscreen = true
				return
			}
			this.inFullscreen = false
		},

		toggleFullscreen() {
			if (!this.inFullscreen) {
				return this.activateFullscreen()
			}

			this.deactivateFullscreen()
		},

		activateFullscreen() {
			const element = this.$refs['mplayer-container']

			if (element.requestFullscreen) {
				element.requestFullscreen()
			} else if (element.mozRequestFullScreen) {
				element.mozRequestFullScreen()
			} else if (element.webkitRequestFullscreen) {
				element.webkitRequestFullscreen()
			} else if (element.msRequestFullscreen) {
				element.msRequestFullscreen()
			}

			this.inFullscreen = true
			return

			this.fixedHeight = window.screen.height
			setTimeout(() => {
				let height = window.screen.height
				this.$refs['mplayer'].style.height = `${height}px`

				const iframe = document.querySelector('iframe')
				console.log('iframe', iframe.clientHeight)
				iframe.style.height = `${height}px`
				console.log('fullscreenhight', height)
			}, 400)
		},

		deactivateFullscreen() {
			if (document.exitFullscreen) {
				document.exitFullscreen()
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen()
			} else if (document.webkitExitFullscreen) {
				document.webkitExitFullscreen()
			}

			this.inFullscreen = false
			return

			const iframe = document.querySelector('iframe')
			iframe.style.height = `none`
		},
	},

	beforeDestroy() {
		window.removeEventListener('fullscreenchange', this.onFullscreenChange)
	},

	mounted() {
		window.addEventListener('fullscreenchange', this.onFullscreenChange)
	},
}
