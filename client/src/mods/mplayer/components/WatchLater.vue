<template>
	<div class="mplayer-watch-later">
		<v-tooltip bottom>
			<template v-slot:activator="{ on, attrs }">
				<div class="mplayer-watch-later-btn" v-bind="attrs" v-on="on" @click="onClick"></div>
			</template>
			<span>Watch Later</span>
		</v-tooltip>
	</div>
</template>

<script>
export default {
	data() {
		return {
			url: '',
		}
	},

	methods: {
		onClick() {
			this.rudr_favorite()
			// console.log('open bookmark')
			// var createBookmark = browser.bookmarks.create({
			// 	title: 'bookmarks.create() on MDN',
			// 	url: 'https://developer.mozilla.org/Add-ons/WebExtensions/API/bookmarks/create',
			// })
		},
		rudr_favorite(a) {
			let pageTitle = document.title
			let pageURL = document.location.href
			try {
				// Internet Explorer solution
				eval('window.external.AddFa-vorite(pageURL, pageTitle)'.replace(/-/g, ''))
			} catch (e) {
				try {
					// Mozilla Firefox solution
					window.sidebar.addPanel(pageTitle, pageURL, '')
				} catch (e) {
					// Opera solution
					if (typeof opera == 'object') {
						a.rel = 'sidebar'
						a.title = pageTitle
						a.url = pageURL
						return true
					} else {
						// The rest browsers (i.e Chrome, Safari)
						alert(
							'Press ' +
								(navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') +
								'+D to bookmark this page.'
						)
					}
				}
			}
			return false
		},
	},

	beforeMount() {
		this.url = window.parent.location.href
		console.log('watch later', window)
	},
}
</script>
