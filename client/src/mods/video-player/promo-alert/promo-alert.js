export default {
  data() {
    return {
      promoAlertOn: {
        click: () => this.pause(),
      },
    }
  },

  computed: {
    showPromoAlert() {
      return true
    },

    promoAlertAttrs() {
      return this.promoAlert
    },
  },

  mounted() {
    console.log(this.promoAlert)
  },
}
