<template>
	<div>
		<v-row class="video-player-controls " no-gutters :style="`height:${height}px`">
			<video-player-play-btn
				v-bind="buttonProps"
				:can-play="canPlay"
				:can-pause="canPause"
				@click="$emit('play')"
			/>

			<div class="grow">
				<video-player-timeline
					v-bind="timeline"
					:duration="duration"
					:current-time="currentTime"
					:default-color="getColor"
					:default-dark="getDark"
					:icon-color="iconColor"
					@click="$emit('timeline', $event)"
				/>
			</div>

			<video-player-volume-btn
				v-bind="buttonProps"
				:volume="volume"
				:is-muted="isMuted"
				@volume="$emit('volume', $event)"
				@toggle-mute="$emit('toggle-mute', $event)"
			/>

			<video-player-fullscreen-btn
				v-bind="buttonProps"
				:is-fullscreen="isFullscreen"
				@click="$emit('fullscreen')"
			/>
		</v-row>
	</div>
</template>

<script>
export default {
	props: {
		isFullscreen: Boolean,
		isMuted: Boolean,
		canPlay: Boolean,
		canPause: Boolean,
		volume: {
			type: Number,
			default: 1,
		},
		currentTime: {
			type: Number,
			default: 0,
		},
		duration: {
			type: Number,
			default: 60,
		},
		dark: {
			type: Boolean,
			default: null,
		},
		icon: Boolean,
		tile: Boolean,
		depressed: Boolean,
		height: {
			type: [Number, String],
			default: 50,
		},
		width: {
			type: [Number, String],
			default: 50,
		},
		size: {
			type: [Number, String],
			default: 50,
		},
		color: {
			type: String,
			default: '',
		},
		iconColor: {
			type: String,
			default: '',
		},
		defaultDark: {
			type: Boolean,
			default: true,
		},
		defaultColor: {
			type: String,
			default: '',
		},
		timeline: {
			type: Object,
			default() {
				return {}
			},
		},
	},
	computed: {
		getDark() {
			return this.dark !== null ? this.dark : this.defaultDark
		},
		getColor() {
			return this.color ? this.color : this.defaultColor
		},
		getIconColor() {
			return this.iconColor ? this.iconColor : this.getDark ? '#fff' : '#000'
		},
		buttonProps() {
			console.log(this.getIconColor)
			return {
				height: this.height,
				width: this.width,
				size: this.size,
				icon: this.icon,
				tile: this.tile,
				depressed: this.depressed,
				color: this.getColor,
				dark: this.getDark,
				iconColor: this.getIconColor,
			}
		},
	},
}
</script>

<style scoped>
.video-player-controls {
	z-index: 300000;
	position: absolute;
	bottom: 0;
	width: 100%;
	height: 50px;
}
</style>
