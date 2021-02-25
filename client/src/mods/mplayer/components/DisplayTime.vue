<template>
	<!-- <v-row no-gutters> -->
	<div class="body-2 mx-2 bluex mplayer-display-time">
		<span>{{ currentTime | pretty }}</span> / <span>{{ duration | pretty }}</span>
	</div>
	<!-- </v-row> -->
</template>

<script>
import { prettyTime } from '../js/helpers'
export default {
	props: {
		currentTime: {
			type: Number,
			default: 0,
		},
		duration: {
			type: Number,
			default: 0,
		},
	},
	filters: {
		pretty(t) {
			return prettyTime(t)
		},
	},
}
</script>
