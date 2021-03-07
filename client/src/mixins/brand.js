import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters({
      app: 'app/app',
      brand: 'app/brand',
      hasAddon: 'app/hasAddon',
      isBrandClient: 'app/isBrandClient',
      extensions: 'extensions',
    }),
    brandActive() {
      return this.brand && this.brand.active ? true : false
    },

    brandTitle() {
      if (this.brandActive && this.brand.topbar_title)
        return this.brand.topbar_title

      // if (this.hasAddon.premium) return `${this.app.app.name} Premium`

      return this.app.app.name
    },

    brandLogo() {
      return this.$app.config.logo
        ? this.$app.config.logo
        : 'https://masterylabs.com/images/ml-lion.png'
    },

    hasAddonBranded() {
      // remove access
      const hasAddon = { ...this.hasAddon }

      if (!this.brand || !this.brand.active) return hasAddon

      const brand = this.brand

      // disable for branded
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
        title: this.app.name,
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

    settingsPageAccess() {
      if (this.isBrandClient) return this.brand.allow_settings ? true : false
      return this.hasAddon.premium ||
        this.hasAddon.search ||
        this.hasAddon.developer
        ? true
        : false
    },

    hasVideoBranding() {
      return this.hasAddon.premium || this.hasAddon.vbranding
    },

    hasPauseBanner() {
      return this.hasAddon.premium || this.hasAddon.pauseBanner
    },

    hasPromoAlert() {
      return this.hasAddon.premium || this.hasAddon.promoAlert
    },

    hasEndPoster() {
      return this.hasAddon.premium || this.hasAddon.endPoster
    },

    hasQuickLink() {
      return this.extensions['vsnippets-quick-links'] ? true : false
    },

    hasMarketing() {
      return (
        this.hasAddon.premium ||
        this.hasAddon.pauseBanner ||
        this.hasAddon.promoAlert ||
        this.hasAddon.endPoster
      )
    },
  },
}
