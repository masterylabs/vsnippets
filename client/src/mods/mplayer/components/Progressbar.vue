<template>
	<div>
		<v-row no-gutters align="center" justify="start">
			<div
				class="mplayer-progressbar-outer "
				:class="[isMouseOver ? 'mplayer-progressbar-over' : '', rounded ? 'mplayer-progressbar-rounded' : '']"
				:style="width ? `width:${width}px` : ''"
				style="heightx:40px;"
				@mouseenter="enter"
				@mouseleave="onLeave"
				@mousemove="move"
				@mousedown="mousedown"
			>
				<div ref="container" class="mplayer-progressbar">
					<div class="mplayer-progressbar-inner" :style="`background:${color};width:${valueWidth}%`"></div>

					<slot name="after" :previewWidth="previewWidth" :is-over="isMouseOver" :value-width="valueWidth" />
				</div>
			</div>

			<slot name="append" :previewWidth="previewWidth" :is-over="isMouseOver" :value-width="valueWidth" />
		</v-row>
		<!-- <slot name="after" :previewWidth="previewWidth" :is-over="isMouseOver" :value-width="valueWidth" /> -->
	</div>
</template>

<script>
export default {
	props: {
		showPreview: Boolean,
		rounded: Boolean,
		value: {
			type: Number,
			default: 0.5,
		},
		color: {
			type: String,
			default: '',
		},
		width: {
			type: [Number, String],
			default: '',
		},
	},

	data() {
		return {
			isMouseOver: false,
			isMouseDown: false,
			dragWaiting: false,
			progress: 0,
			leavingWait: null,
		}
	},

	computed: {
		valueWidth() {
			return Math.floor(this.value * 100)
		},
		previewWidth() {
			return Math.floor(this.progress * 100)
		},
	},

	methods: {
		onLeave() {
			this.leavingWait = setTimeout(() => {
				this.isMouseOver = false
			}, 1000)
		},
		enter(e) {
			clearTimeout(this.leavingWait)
			this.isMouseOver = true
		},
		// leave(e) {
		// 	this.isMouseOver = false
		// },
		move(e) {
			if (!this.$refs.container || !this.$refs.container.clientWidth) return

			let val = e.offsetX / this.$refs.container.clientWidth

			if (val < 0) val = 0
			else if (val > 1) val = 1

			this.progress = Math.round((val + Number.EPSILON) * 100) / 100

			// Drag
			if (this.isMouseDown && !this.dragWaiting) this.onDrag()
		},

		onDrag() {
			this.dragWaiting = true

			setTimeout(() => {
				this.dragWaiting = false
				if (this.isMouseDown) this.click()
			}, 125)
		},

		click() {
			this.$emit('input', this.progress)
		},

		mousedown() {
			this.isMouseDown = true
			this.click()
		},
		mouseup() {
			this.isMouseDown = false
		},
	},

	beforeDestroy() {
		document.removeEventListener('mouseup', this.mouseup)
	},

	mounted() {
		document.addEventListener('mouseup', this.mouseup)
	},
}
</script>
