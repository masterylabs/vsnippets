<template>
	<v-card
		:icon="icon"
		:tile="tile"
		:depressed="depressed"
		:height="height"
		:loading="!canPlay && !canPause"
		:color="color"
		:dark="dark"
		:width="width"
		@click="$emit('click')"
	>
		<v-row no-gutters align="center" justify="center" style="height:100%">
			<v-icon :color="iconColor" :size="size" v-text="`mdi-fullscreen${isFullscreen ? '-exit' : ''}`"></v-icon>
		</v-row>
	</v-card>
</template>

<script>
import buttonMixin from '../mixins/buttons'
export default {
	props: {
		isFullscreen: Boolean,
	},

	mixins: [buttonMixin],
	data() {
		return {
			active: false,
		}
	},
}
</script>
