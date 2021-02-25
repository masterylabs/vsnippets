<template>
	<div>
		<v-slider
			v-model="val"
			:label="label"
			min="0"
			:max="getDuration"
			thumb-label="always"
			track-color="grey lighten-1"
			:color="getColor"
			:thumb-color="getColor"
			@input="input"
		>
			<template v-slot:thumb-label="{ value }">
				<v-chip :color="getColor"> {{ value | t }}</v-chip>
			</template>
		</v-slider>
		<v-expand-transition>
			<div v-if="isInvalid" :type="getColor">
				<span class="yellow lighten-4 px-2 py-1 body-2"> {{ errorMessage }}</span>
			</div>
		</v-expand-transition>
	</div>
</template>

<script>
import { prettyTime } from '@/mods/mplayer/js/helpers'
export default {
	props: {
		value: {
			type: [Number, String],
			default: 0,
		},
		min: {
			type: [Number, String],
			default: 0,
		},
		label: {
			type: String,
			default: 'Show Time',
		},
		duration: {
			type: [String, Number],
			default: 600, // 10 mins
		},
		errorMessage: {
			type: String,
			default: 'Pause Time should come after Show Time',
		},
	},

	beforeMount() {
		if (this.value) this.val = parseInt(this.value)
	},

	data() {
		return {
			val: 0,
		}
	},

	computed: {
		getDuration() {
			return parseInt(this.duration)
		},
		getMin() {
			let min = parseInt(this.min)
			return min ? min : 0
		},
		isInvalid() {
			return this.val > 0 && this.val < this.min
		},
		getColor() {
			return this.isInvalid ? 'warning' : this.val > 0 ? 'primary' : 'grey lighten-1'
		},
	},

	methods: {
		input() {
			this.$emit('input', this.val)
		},
	},

	filters: {
		t(n) {
			return prettyTime(n)
		},
	},
}
</script>
