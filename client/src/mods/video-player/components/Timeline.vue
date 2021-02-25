<template>
	<v-hover v-slot="{ hover }">
		<div
			ref="timeline"
			class="video-player-timeline white--text"
			:style="{ height: `${height}px` }"
			@mousemove="onMousemove"
			@mousedown="onMousedown"
		>
			<div class="video-player-timeline-click" v-on:click="onClick">
				<div class="video-player-timeline-bg" :style="{ background: getColor, opacity: bgOpacity }" />
				<v-row
					no-gutters
					align="center"
					justify="end"
					style="height:100%"
					class="video-player-timeline-progress"
					:style="{
						background: progressColor || getColor,
						opacity: progressOpacity,
						width: `${progressWidth}%`,
						borderRight: `1px solid ${getDark ? iconColor : 'black'}`,
					}"
				>
					<div class="mr-n11x mr-2"></div>
				</v-row>

				<v-row
					v-if="hover"
					no-gutters
					align="center"
					justify="end"
					style="height:100%"
					class="video-player-timeline-preview"
					:style="{
						...preview,
						width: `${previewLeft}px`,
						borderRight: `1px solid ${!getDark ? iconColor : 'rgba(0,0,0,0.5)'}`,
					}"
				>
					<div :class="previewTextRight ? 'mr-n5' : 'mr-2'"></div>
				</v-row>
			</div>

			<template v-if="!noTooltips">
				<v-fade-transition>
					<video-player-tooltip
						v-if="hover"
						:left="progressWidth"
						:value="currentTime"
						:inverse="getDark"
						:icon-color="iconColor"
					/>
				</v-fade-transition>
				<v-fade-transition>
					<video-player-tooltip
						v-if="hover"
						:left="previewLeft"
						:value="previewValue"
						px
						:inverse="!getDark"
					/>
				</v-fade-transition>
			</template>
		</div>
	</v-hover>
</template>

<script>
// import { prettyTime } from '../mixins/helpers'
export default {
	props: {
		dark: {
			type: Boolean,
			default: null,
		},
		noTooltips: Boolean,
		currentTime: {
			type: Number,
			default: 0,
		},
		duration: {
			type: Number,
			default: 60,
		},
		height: {
			type: [String, Number],
			default: 40,
		},
		color: {
			type: String,
			default: '',
		},
		progressColor: {
			type: String,
			default: '',
		},
		bgOpacity: {
			type: [String, Number],
			default: 0.4,
		},
		progressOpacity: {
			type: [String, Number],
			default: 0.65,
		},

		defaultColor: {
			type: String,
			default: '',
		},
		defaultDark: {
			type: Boolean,
			default: true,
		},

		progress: {
			type: Object,
			default() {
				return {}
			},
		},
		preview: {
			type: Object,
			default() {
				return {}
			},
		},
		iconColor: {
			type: String,
			default: '',
		},
	},

	data() {
		return {
			previewLeft: 0,
			previewWidth: 50,
			isDrag: 0,
			dragWait: null,
		}
	},

	computed: {
		getDark() {
			return this.dark !== null ? this.dark : this.defaultDark
		},
		getColor() {
			return this.color ? this.color : this.defaultColor
		},

		progressWidth() {
			return Math.floor((this.currentTime / this.duration) * 100)
		},
		previewValue() {
			if (!this.$refs.timeline) return 0

			let value = this.previewLeft / this.$refs.timeline.clientWidth
			value = value * this.duration

			if (value < 1) value = 0
			else if (value > this.duration - 1) value = this.duration

			return Math.floor(value)
		},
		previewTextRight() {
			return this.previewLeft < 25 ? true : false
		},
	},

	methods: {
		onClick({ offsetX }) {
			let value = (offsetX / this.$refs.timeline.clientWidth) * this.duration
			this.$emit('click', value)
		},
		onMousemove({ offsetX }) {
			this.previewLeft = offsetX || 0

			if (this.isDrag) {
				clearTimeout(this.dragWait)
				this.dragWait = setTimeout(() => {
					this.onClick({ offsetX })
				}, 10)
			}
		},
		onMousedown() {
			this.isDrag = true
		},

		onMouseup() {
			if (this.isDrag) {
				clearTimeout(this.dragWait)
				this.isDrag = false
			}
		},
	},

	// filters: {
	// 	pretty(n) {
	// 		return prettyTime(n)
	// 	},
	// },

	beforeDestroy() {
		document.removeEventListener('mouseup', this.onMouseup)
	},

	mounted() {
		document.addEventListener('mouseup', this.onMouseup)
	},
}
</script>

<style>
.video-player-timeline {
	position: relative;
}
.video-player-timeline-click {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
}
.video-player-timeline-bg,
.video-player-timeline-progress,
.video-player-timeline-preview {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	pointer-events: none;
}

.video-player-timeline-progress {
	transition: width 0.34s ease-in-out;
}

.video-player-timeline-preview {
	transition: width 220ms ease-in;
}
</style>
