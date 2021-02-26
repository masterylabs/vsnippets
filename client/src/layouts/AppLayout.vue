<template>
  <v-app>
    <v-app-bar v-if="ready" dense flat absolute app dark>
      <v-btn class="text-none mx-0 px-3" text @click="onHome">
        <m-logo dark />
        <v-toolbar-title class="ml-1 font-weight-bold body-1">{{
          app.app.name
        }}</v-toolbar-title>
      </v-btn>
      <v-spacer />
      <v-toolbar-items>
        <v-btn
          v-if="$route.name != 'home'"
          class="text-none font-weight-normal"
          text
          exact
          :to="{ name: 'home' }"
          >Back To Snippets</v-btn
        >
        <v-btn text :to="{ name: 'settings' }" class="text-none"
          >Settings</v-btn
        >
      </v-toolbar-items>
      <wp-fullscreen-btn class="ml-3" />
    </v-app-bar>

    <v-main class="white mt-n1">
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
      }
    },
    computed: {
      ...mapState({
        app: 'app',
      }),
    },

    methods: {
      onHome() {
        if (this.$route.name != 'home') this.$router.push({ name: 'home' })
      },
    },
  }
</script>
