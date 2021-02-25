import { mapGetters } from 'vuex'

export const addonMixin = {
	computed: {
		...mapGetters({
			hasAddon: 'app/hasAddon',
		}),
	},
}

export const brandMixin = {
	computed: {
		...mapGetters({
			brand: 'app/brand',
			hasAddon: 'app/hasAddon',
			isBrandClient: 'app/isBrandClient',
		}),
		hasAddonBranded() {
			// remove access
			const hasAddon = { ...this.hasAddon }

			if (!this.brand || !this.brand.active) return hasAddon

			const brand = this.brand

			hasAddon.premium = false

			const items = ['volt', 'search']

			items.forEach((item) => {
				if (brand[`allow_${item}`]) hasAddon[item] = true
			})
			// addons.premium = true
			return hasAddon
		},

		//
		branding() {
			const branding = {
				title: 'WP Image Drop',
				allow_volt: this.hasAddon.premium || this.hasAddon.premium,
			}

			if (this.brand && this.brand.active) {
				//
			}

			return branding
		},
		isDevAdmin() {
			return this.hasAddon.developer && !this.isBrandClient ? true : false
		},
	},
}

export const pagesMixin = {
	mixins: [addonMixin],
	computed: {
		useVideoSizes() {
			return this.hasAddon.premium || this.hasAddon.video ? true : false
		},
		useRaw() {
			return this.hasAddon.premium || this.hasAddon.raw ? true : false
		},
	},
}
