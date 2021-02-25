<template>
	<div class="mplayer-timeline-container">
		<mplayer-progressbar :value="progress" :color="color" rounded @input="onInput">
			<template v-slot:after="{ previewWidth, isOver, valueWidth }">
				<v-fade-transition>
					<mplayer-tooltip v-if="isOver" :left="previewWidth" :value="getTime(previewWidth)" inverse />
				</v-fade-transition>
				<v-fade-transition>
					<mplayer-tooltip v-if="isOver" :left="valueWidth" :value="getTime(valueWidth)" easing />
				</v-fade-transition>
			</template>
		</mplayer-progressbar>
	</div>
</template>

<script>
export default {
	props: {
		color: {
			type: String,
			default: '',
		},
		duration: {
			type: Number,
			default: 0,
		},
		currentTime: {
			type: Number,
			default: 0,
		},
	},

	data() {
		return {}
	},

	computed: {
		progress() {
			if (!this.currentTime || !this.duration) return 0

			if (Math.ceil(this.currentTime) == this.duration) return 1

			return this.currentTime / this.duration
		},
	},

	methods: {
		onInput(n) {
			n = this.duration * n
			this.$emit('input', n)
		},
		getTime(n) {
			n = (n / 100) * this.duration
			if (n > this.duration - 0.1) n = this.duration
			else n = Math.floor(n)
			return n
		},
	},
}
</script>

<style lang="scss" scoped>
.mplayer-timeline-container {
	position: absolute;
	left: 0px;
	bottom: 40px;
	width: 100%;
	padding: 0px 10px;
}
</style>
