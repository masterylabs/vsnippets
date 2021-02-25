<template>
	<v-btn icon dark class="mr-2" :color="color" :loading="loading" @click="click">
		<v-icon size="28" v-text="icon" />
	</v-btn>
</template>

<script>
export default {
	props: {
		playerState: {
			type: String,
			default: '',
		},
		color: {
			type: String,
			default: '',
		},
	},

	computed: {
		icon() {
			if (this.playerState == 'ended') return 'mdi-replay'
			return ['ready', 'paused'].includes(this.playerState) ? 'mdi-play' : 'mdi-pause'
		},
		loading() {
			return ['unstarted', 'buffering'].includes(this.playerState)
		},
	},

	methods: {
		click() {
			this.$emit('click')
		},
	},
}
</script>
