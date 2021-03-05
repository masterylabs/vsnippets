<template>
  <app-layout :ready="app.ready">
    <view-app-no-auth v-if="app.noAuth" />
    <view-loading v-else-if="!app.ready" />
    <view-upgrade v-else-if="app.expired" />
    <view-welcome v-else-if="!validLicense" />
    <router-view v-else />
    <!-- <m-test /> -->
    <!-- <video-player-test /> -->
    <!-- <video-trimmer-test /> -->
    <!-- <template v-slot:bottom>
      <ml-license-btn v-if="canUse" fixed bottom right fab />
    </template> -->
  </app-layout>
</template>

<script>
  import { mapState, mapGetters } from 'vuex'

  export default {
    computed: {
      ...mapState({
        app: 'app',
      }),
      ...mapGetters({
        // hasAddon: 'app/hasAddon',
        isBrandClient: 'app/isBrandClient',
        validLicense: 'app/validLicense',
      }),
      // canUse() {
      //   return (
      //     this.app.ready &&
      //     this.validLicense &&
      //     !this.app.expired &&
      //     !this.isBrandClient
      //   )
      // },
      showToolbar() {
        return this.app.ready
      },
    },

    async beforeMount() {
      if (this.$app.config.color)
        this.$vuetify.theme.themes.light.primary = this.$app.config.color
      this.$app.start()
    },
  }
</script>

<style lang="scss">
  @import './scss/app.scss';
  @import './scss/wp-admin.scss';
</style>
