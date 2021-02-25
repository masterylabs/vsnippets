<template>
	<v-container>
		<video-player-test />
		<!-- <mplayer-test /> -->
		<!-- <drag-sort v-model="items" height="13">
			<template v-slot:item="{ item }"> item: {{ item }} </template>
		</drag-sort> -->

		<!-- {{ items }} -->
	</v-container>
</template>

<script>
export default {
	data() {
		return {
			items: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'],
		}
	},
}
</script>
