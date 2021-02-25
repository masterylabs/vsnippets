<template>
	<div>
		<v-btn color="primary" dark :loading="loading" @click="submit">
			<v-icon class="mr-1">mdi-cart</v-icon>
			Upgrade Now
		</v-btn>

		<v-dialog v-model="dialog" :width="dialogWidth" :height="dialogHeight">
			<v-card v-if="upgrade && upgrade.use_upgrade_dialog" :width="dialogWidth" :height="dialogHeight - 100">
				<div style="position:relative">
					<div v-if="upgrade.content" v-html="upgrade.content"></div>
					<iframe
						v-else-if="upgrade.url"
						:src="upgrade.url"
						frameborder="0"
						style="position:absolute;left:0px;top:0px;width:100%;height:100%"
					></iframe>
				</div>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
	data() {
		return {
			loading: false,
			dialog: false,
			dialogWidth: 500,
			dialogHeight: 500,
		}
	},

	computed: {
		...mapGetters({
			upgrade: 'app/upgrade',
		}),
	},

	methods: {
		async submit() {
			await this.$app.upgrade()

			if (!this.upgrade || !this.upgrade.use_upgrade_dialog) return

			// else
			this.dialogWidth = window.innerWidth - 40
			this.dialogHeight = window.innerHeight - 40
			this.dialog = true
		},
	},
}
</script>
