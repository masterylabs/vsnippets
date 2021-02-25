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
			<v-icon :color="iconColor" :size="size" v-text="`mdi-${canPlay ? 'play' : 'pause'}`"></v-icon>
		</v-row>
	</v-card>
</template>

<script>
import buttonMixin from '../mixins/buttons'
export default {
	mixins: [buttonMixin],
}
</script>

<style scoped>
::v-deep .v-btn {
	padding-left: 1px;
	padding-right: 1px;
}
div.btn__content {
	padding: 0;
}

div.card__actions .btn {
	min-width: 0;
}
</style>
