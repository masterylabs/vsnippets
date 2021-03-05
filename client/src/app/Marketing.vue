<template>
  <page-layout title="vMarketing" logo="cash-100">
    <v-tabs v-model="tab" icons-and-text centered>
      <v-tabs-slider></v-tabs-slider>
      <v-tab v-for="tab in tabs" :key="tab.icon" class="px-10"
        >{{ tab.text }}
        <v-icon v-text="`mdi-${tab.icon}`" />
      </v-tab>

      <v-tab-item class="mt-6">
        <pause-banner />
      </v-tab-item>
      <v-tab-item class="mt-6">
        <promo-alert />
      </v-tab-item>
      <v-tab-item class="mt-6">
        <end-poster />
      </v-tab-item>
    </v-tabs>
  </page-layout>
</template>

<script>
  import pauseBanner from './pause-banner/PauseBanner'
  import promoAlert from './promo-alert/PromoAlert'
  import endPoster from './end-poster/EndPoster'
  import brandMixin from '@/mixins/brand'
  export default {
    components: {
      pauseBanner,
      promoAlert,
      endPoster,
    },

    mixins: [brandMixin],

    data() {
      return {
        tab: 0,
        tabs: [
          {
            text: 'Pause Banner',
            icon: 'pause',
          },
          {
            text: 'Promo Alert',
            icon: 'alert',
          },
          // {
          //   text: 'Contact Panel',
          //   icon: 'card-account-phone-outline',
          // },
          {
            text: 'End Poster',
            // icon: 'ray-end',
            icon: 'image-area-close',
          },
        ],
      }
    },

    beforeMount() {
      if (!this.hasMarketing) this.$router.replace({ name: 'home' })
    },
  }
</script>
