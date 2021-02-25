<template>
	<v-btn icon @click="toggle">
		<v-icon v-text="`mdi-fullscreen${fs.isFullscreen ? '-exit' : ''}`"></v-icon>
	</v-btn>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

export default {
	computed: {
		...mapState({
			fs: 'wp-fullscreen-btn',
		}),
	},
	methods: {
		...mapMutations({
			toggle: 'wp-fullscreen-btn/TOGGLE',
		}),
	},
}
</script>
