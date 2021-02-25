<template>
	<v-container>
		<v-row>
			<v-col>
				<div class="title">Admin</div>
				<!-- <mplayer-admin v-model="video" /> -->
			</v-col>
			<v-col>
				<div class="title">Player</div>
				<mplayer :v-bind="video" />
			</v-col>
		</v-row>

		<v-btn v-for="item in videos" :key="item" @click="setVideo(item)" v-text="item" />

		<div class="mt-8">
			<dev-raw :value="video" />
		</div>
	</v-container>
</template>

<script>
export default {
	data() {
		return {
			videos: ['9em32dDnTck', 'Y5_6V7E6PXA', 'kYVbHh9BigU'],
			video: {
				src: '9em32dDnTck', //'Y5_6V7E6PXA', //'kYVbHh9BigU',
				posterx: 'https://i.ytimg.com/vi/kYVbHh9BigU/maxresdefault.jpg',
				avatarx: 'https://img.youtube.com/vi/dJuAA0zttBM/2.jpg',
				avatarLink: '',
				posterOnPause: true,
				// color: '',
				// start: 0,
				// end: 0,
				// controls: ['timeline', 'center-player', 'play', 'volume', 'fullscreen'],
				// title: 'My Video Title',
				// duration: true,
				// progress: true,
				// lockControls: true,
				// logo: '',
				// logoPos: 'tr',
				// logoOpacity: 0.5,
				// logoLink: '',
				// linkLogo: false,
				// useLogo: false,
			},
		}
	},

	methods: {
		setVideo(video) {
			this.video.src = video
		},
	},
}
</script>
