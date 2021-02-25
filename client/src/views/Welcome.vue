<template>
	<v-container fill-height>
		<v-row align="center" justify="center">
			<v-col class="text-center">
				<v-card flat max-width="500" class="mx-auto">
					<div class="text-h1">Welcome!</div>
					<p class="mt-2">Please enter your account email and password to get started!</p>
					<p class="caption grey--text text--darken-1 mt-n2">
						(This is the same email and password you use to login to MasteryLabs members area)
					</p>
					<ml-license-form btn-text="Activate License" />
				</v-card>
			</v-col>
		</v-row>
	</v-container>
</template>

<script>
export default {
	mounted() {
		this.$app.info('Welcome, lets active your license!')
	},
}
</script>
