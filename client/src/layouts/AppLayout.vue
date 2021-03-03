<template>
  <v-app>
    <v-app-bar v-if="ready" dense flat absolute app dark>
      <v-btn class="text-none mx-0 px-3" text @click="onHome">
        <m-logo no-text dark />
        <v-toolbar-title class="ml-1 font-weight-bold body-1">{{
          app.app.name
        }}</v-toolbar-title>
      </v-btn>
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
      <wp-fullscreen-btn class="ml-3" />
    </v-app-bar>

    <v-main class="white mt-n1">
      <!-- adding style  -->
      <v-card class="pb-2 lighten-3 primary" tile />
      <slot />
    </v-main>

    <ml-msg />
  </v-app>
</template>

<script>
  import { mapState } from 'vuex'
  export default {
    props: {
      ready: Boolean,
    },
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
              return this.$route.name != 'home'
            },
          },
          {
            text: 'Branding',
            to: { name: 'branding' },
            exact: true,
            icon: 'pencil-ruler',
          },
          {
            text: 'Marketing',
            to: { name: 'marketing' },
            exact: true,
            icon: 'cash-100',
          },
        ],
      }
    },
    computed: {
      ...mapState({
        app: 'app',
      }),
      getItems() {
        return this.items.filter((a) => !a.hide || a.hide())
      },
    },

    methods: {
      onHome() {
        if (this.$route.name != 'home') this.$router.push({ name: 'home' })
      },
    },
  }
</script>
