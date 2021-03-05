<template>
  <page-layout title="vBranding" logo="pencil-ruler">
    <!--  -->
    <v-row>
      <v-col>
        <video-player
          v-bind="player"
          always-show-content
          lock-controls
          class="mb-8"
        >
          <!-- <template v-slot:content>
            <v-card
              width="100%"
              height="100%"
              color="grey lighten-4"
              tile
              invisible-video
            >
            </v-card>
          </template> -->
        </video-player>

        <v-card>
          <v-card-title>Watermark</v-card-title>
          <v-card-text>
            <branding-logo />
          </v-card-text>
        </v-card>
      </v-col>
      <v-col class="shrink">
        <v-btn
          class="mb-6"
          large
          block
          color="primary"
          :disabled="!hasChanges"
          :loading="loading"
          @click="save"
          >Save</v-btn
        >
        <v-color-picker
          v-if="ready"
          palette
          show-swatches
          swatches-max-height="163"
          v-model="item.color"
          class="mb-5"
        />
      </v-col>
    </v-row>
  </page-layout>
</template>

<script>
  import { mapGetters } from 'vuex'
  import isDark from '@/helpers/is-dark'
  import brandingLogo from './PlayerBrandingLogo'

  export default {
    components: {
      brandingLogo,
    },

    data() {
      return {
        ready: false,
        loading: false,
        dataStr: '',
      }
    },
    computed: {
      ...mapGetters({
        item: 'playerBranding',
        player: 'player',
      }),
      dark() {
        return isDark(this.item.color, true)
      },
      playerAttrs() {
        return {
          ...this.player,
        }
      },
      hasChanges() {
        return this.dataStr != JSON.stringify(this.item)
      },
    },

    methods: {
      async save() {
        this.$app.warning('Updating...')
        this.loading = true

        const jsonData = JSON.stringify(this.item)
        await this.$app.post('player-branding', { jsonData })

        this.dataStr = jsonData

        this.loading = false

        this.$app.success('Updated!')
      },
    },

    mounted() {
      if (!this.item.color) this.item.color = this.$app.config.colors.primary
      this.dataStr = JSON.stringify(this.item)
      this.ready = true
    },
  }
</script>
