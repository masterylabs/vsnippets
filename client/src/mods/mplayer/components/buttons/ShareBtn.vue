<template>
	<v-tooltip bottom>
		<template v-slot:activator="{ on, attrs }">
			<v-btn
				class="mplayer-share-btn text-none"
				x-small
				height="54"
				dark
				v-bind="attrs"
				v-on="on"
				@click="onClick"
			>
				<v-container>
					<v-row no-gutters align="center" justify="center">
						<v-icon size="30">mdi-share</v-icon>
					</v-row>
					<v-row no-gutters align="center" justify="center" class="body-2">share</v-row>
				</v-container>
			</v-btn>
		</template>
		<span>Share</span>
	</v-tooltip>
</template>

<script>
export default {
	methods: {
		onClick() {
			this.$emit('click')
		},
	},
}
</script>
