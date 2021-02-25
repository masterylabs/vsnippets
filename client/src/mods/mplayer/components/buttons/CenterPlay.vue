<template>
	<div class="mplayer-layer">
		<v-row align="center" justify="center" no-gutters class="pt-n2">
			<v-btn :color="color" :dark="!light" x-large :icon="isIcon" @click="onClick">
				<v-icon x-large :color="inverseColor">mdi-play</v-icon>
			</v-btn>
		</v-row>
	</div>
</template>

<script>
export default {
	props: {
		isIcon: Boolean,
		light: Boolean,
		color: {
			type: String,
			default: '',
		},
		inverseColor: {
			type: String,
			default: '',
		},
	},

	methods: {
		onClick() {
			this.$emit('click')
		},
	},
}
</script>
