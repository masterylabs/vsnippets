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
      if (!this.promoAlert.active) return false

      if (
        this.adminView == 'promoAlert' &&
        ['paused', 'ready', 'ended'].includes(this.playerState)
      )
        return true

      const showTime = this.promoAlert.showTime
        ? parseInt(this.promoAlert.showTime)
        : 0

      if (!showTime) return true

      return this.getCurrentTime >= showTime
    },

    promoAlertAttrs() {
      return this.promoAlert
    },
  },
}
