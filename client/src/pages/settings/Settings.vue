<template>
	<v-container>
		<!-- dataStr: {{ dataStr }}, {{ data }} -->
		<v-row justify="center" align="center">
			<v-card width="500" color="white" class="mt-12">
				<v-card-title>Unsplash API</v-card-title>
				<v-card-text>
					<p>
						Enter your Unsplash Access Key and Secret Key below.
						<v-btn href="https://unsplash.com/oauth/applications" target="_blank" color="primary" icon small
							><v-icon>mdi-open-in-new</v-icon></v-btn
						>
					</p>
					<v-text-field
						v-model="data.unsplash_access_key"
						:type="focusedShow ? 'text' : 'password'"
						label="Access Key"
						@focus="focusedShow = true"
						@blur="focusedShow = false"
					/>
				</v-card-text>
				<v-card-actions class="mx-2">
					<v-btn @click="submit" color="primary" :loading="loading" :disabled="!canSave">Save Changes</v-btn>
				</v-card-actions>
				<br />
			</v-card>
		</v-row>

		<dev-settings v-if="isDevAdmin" />
	</v-container>
</template>

<script>
import { mapGetters } from 'vuex'
import DevSettings from './DevSettings'
import brandMixins from '../../mixins/brand'

export default {
	components: {
		DevSettings,
	},

	mixins: [brandMixins],

	data() {
		return {
			focusedShow: false,
			loading: false,
			showSecret: false,
			dataStr: '',
		}
	},

	computed: {
		...mapGetters({
			data: 'app/settings',
		}),
		canSave() {
			return this.data.unsplash_access_key != this.dataStr
			// return this.dataStr != JSON.stringify(this.data)
		},
	},

	methods: {
		async submit() {
			this.loading = true
			await this.$app.saveSettings()
			this.dataStr = this.data.unsplash_access_key // JSON.stringify(this.data)
			this.loading = false
		},
	},

	beforeMount() {
		return
		if (!this.settingsPageAccess) return this.$router.replace({ name: 'home' })
		console.log('settings', this.settingsPageAccess)
		// console.log()
		// this.dataStr = this.
		if (this.data.unsplash_access_key) this.dataStr = this.data.unsplash_access_key
	},
}
</script>
