<template>
	<v-container fill-height>
		<v-row align="center" justify="center">
			<div>
				<v-card-text>
					<div class="text-h4">Unable to Connect</div>
					<br />
					<h3>1.Check Permalinks (New WP Setup?)</h3>
					<p>
						If this is a new WordPress setup, pease check you <br />have completed your permalinks setup.
						<br />
					</p>
					<p>
						WP Admin > Settings > Permalinks. <br />You have 5 options,
						<u class="yellow lighten-4">select options 2 - 5</u>.
					</p>

					<br />
					<h3>2. Session Expired?</h3>
					<p>Log out of your WordPress admin and back in. <br /></p>

					<br />
					<v-btn color="primary" outlined :loading="loading" @click="reloadPage">Reload Page</v-btn>
				</v-card-text>
			</div>
		</v-row>
	</v-container>
</template>

<script>
export default {
	data() {
		return {
			loading: false,
		}
	},
	methods: {
		reloadPage() {
			this.loading = true
			location.reload()
		},
	},
}
</script>
