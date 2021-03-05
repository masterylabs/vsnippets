<template>
  <v-app>
    <video-player v-if="ready" v-bind="video" />
    <!-- <dev-raw :value="{ video }" /> -->
  </v-app>
</template>

<script>
  import { toCamel } from '../helpers/str'

  export default {
    data() {
      return {
        ready: false,
        video: {},
      }
    },

    computed: {
      endpoint() {
        return `video/${this.$app.config.video}`
      },
    },

    async beforeMount() {
      const response = await this.$app.get(this.endpoint)

      if (!response || !response.data) {
        return
      }

      let video = response.data

      if (response.meta)
        for (const k in response.meta) {
          if (response.meta[k]) {
            const key = toCamel(k)
            video[key] = response.meta[k]
          }
        }

      this.video = video
      this.ready = true
    },
  }
</script>
