<template>
	<div class="mt-12">
		<v-row>
			<v-col>
				<v-card>
					<v-row align="center" justify="space-between" no-gutters>
						<v-card-title>UI Branding</v-card-title>
						<v-switch v-model="data.active" label="Active" class="mx-4" @change="onActive" />
					</v-row>
					<v-card-text>
						<v-text-field
							v-for="field in textFields"
							:key="field.value"
							v-model="data[field.value]"
							:label="field.text"
							:placeholder="field.placeholder"
						/>
					</v-card-text>
					<div class="ml-4 mt-n5 mb-6">
						<v-checkbox
							v-for="option in options"
							:key="option.value"
							v-model="data[option.value]"
							:label="option.text"
							hide-details
						/>
					</div>
					<v-expand-transition>
						<div v-if="data.active" class="grey lighten-4 mt-3 pa-2 mx-4 rounded-md mb-6 caption">
							<v-icon small class="mt-n1">mdi-information-outline</v-icon>
							License button will be hidden automatically
						</div>
					</v-expand-transition>

					<v-btn color="primary" class="mb-8 ml-4" :disabled="!hasChanges" :loading="loading" @click="save"
						>Save Changes
					</v-btn>
				</v-card>
			</v-col>
			<v-col>
				<v-color-picker v-model="data.theme_color" @input="onColor" />
				<v-row no-gutters align="center" justify="start">
					<v-btn
						depressed
						small
						outlined
						color="#ee44aa"
						:disabled="data.theme_color == defaultThemeColor"
						@click="resetColor"
						>Reset Theme Color</v-btn
					>
				</v-row>
			</v-col>
		</v-row>
	</div>
</template>

<script>
const getPageSlug = () => {
	const [, a] = window.location.href.split('?page=')
	return a.split('#')[0]
}

const getPageUrl = (slug, page = 'settings') => {
	const [a] = window.location.href.split('?page=')
	return `${a}?page=${slug}#/${page}`
}

import { mapGetters } from 'vuex'
export default {
	data() {
		return {
			defaultThemeColor: '#ee44aa',
			loading: false,
			colorNotActiveNotified: false,
			textFields: [
				{
					text: 'Brand Title',
					value: 'topbar_title',
					placeholder: 'WP Image Drop',
				},
				{
					text: 'Topbar Label',
					value: 'topbar_label',
					placeholder: 'Premium Pro',
				},
				{
					text: 'Menu Title',
					value: 'menu_title',
				},
				{
					text: 'Brand Logo',
					value: 'logo',
					placeholder: 'https:// Optional (used when app is loading)',
				},
			],
			options: [
				{
					text: 'Vault Access',
					value: 'allow_volt',
				},
				{
					text: 'Cloud Access',
					value: 'allow_search',
				},
				{
					text: 'Settings Access',
					value: 'allow_settings',
				},
			],
			dataStr: '',
		}
	},

	computed: {
		...mapGetters({
			data: 'app/brand',
		}),
		hasChanges() {
			return this.dataStr != JSON.stringify(this.data)
		},
	},

	methods: {
		onActive(active) {
			if (!active) {
				this.$vuetify.theme.themes.light.primary = this.defaultThemeColor
				return
			}

			if (this.data.theme_color) {
				this.$vuetify.theme.themes.light.primary = this.data.theme_color
			}
		},

		onColor(value) {
			if (!this.data.active) {
				if (!this.colorNotActiveNotified) {
					this.$app.info('Please activate to see changes')
					this.colorNotActiveNotified = true
				}
				return this.$app.msg
			}
			this.$vuetify.theme.themes.light.primary = value
		},

		resetColor() {
			this.data.theme_color = this.defaultThemeColor
			this.$vuetify.theme.themes.light.primary = this.defaultThemeColor
		},

		async save() {
			this.loading = true
			const { page_slug } = await this.$app.post('brand', this.data)
			this.dataStr = JSON.stringify(this.data)
			this.loading = false

			if (getPageSlug() == page_slug) return this.$app.success('Branding saved!')

			this.$app.info('Redirecting to new URL, one moment please...')

			setTimeout(() => {
				window.location.href = getPageUrl(page_slug)
			}, 300)
		},
	},

	beforeMount() {
		if (!this.data.theme_color) this.data.theme_color = this.defaultThemeColor

		this.dataStr = JSON.stringify(this.data)
	},
}
</script>
