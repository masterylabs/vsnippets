<template>
  <v-app>
    <v-app-bar v-if="ready" dense flat absolute app dark color="#23282D">
      <v-btn class="text-none mx-0 px-3" text @click="onHome">
        <m-logo no-text dark />
        <v-toolbar-title class="ml-1 font-weight-bold body-1">{{
          brandTitle
        }}</v-toolbar-title>
      </v-btn>
      <v-chip
        v-if="hasAddon.premium && !this.isBrandClient"
        color="purple"
        class="ml-2 text-uppercase"
        >Premium</v-chip
      >
      <v-spacer />
      <v-toolbar-items>
        <v-btn
          v-for="(item, index) in getItems"
          :key="`item${index}`"
          :to="item.to"
          text
          :exact="item.exact"
        >
          <v-icon class="mr-1" v-text="`mdi-${item.icon}`" />
          {{ item.text }}
        </v-btn>
        <!-- <v-btn text :to="{ name: 'settings' }" class="text-none"
          >Settings</v-btn
        > -->
      </v-toolbar-items>
      <ml-license-btn v-if="!isBrandClient" />
      <wp-fullscreen-btn class="ml-3" />
    </v-app-bar>

    <!-- <v-card v-if="hasAddon.premium">
      PREMIUM
    </v-card> -->

    <v-main class="white mt-n1">
      <slot />
    </v-main>

    <ml-msg />

    <slot name="bottom" />
  </v-app>
</template>

<script>
  import { mapState } from 'vuex'
  import brandMixin from '@/mixins/brand'
  export default {
    props: {
      ready: Boolean,
    },
    mixins: [brandMixin],
    data() {
      return {
        drawer: true,
        items: [
          {
            text: 'Back To Snippets',
            to: { name: 'home' },
            exact: true,
            icon: 'arrow-left',
            hide: () => {
              return this.$route.name == 'home'
            },
          },
          {
            text: 'Branding',
            to: { name: 'branding' },
            exact: true,
            icon: 'pencil-ruler',
            hide: () => !this.hasVideoBranding,
          },
          {
            text: 'Marketing',
            to: { name: 'marketing' },
            exact: true,
            icon: 'cash-100',
            hide: () => !this.hasMarketing,
          },
        ],
      }
    },
    computed: {
      ...mapState({
        app: 'app',
      }),
      getItems() {
        return this.items.filter((a) => !a.hide || !a.hide())
      },
    },

    methods: {
      onHome() {
        if (this.$route.name != 'home') this.$router.push({ name: 'home' })
      },
    },
  }
</script>
