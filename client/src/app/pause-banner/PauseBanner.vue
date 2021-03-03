<template>
  <div>
    <!-- <dev-raw :value="{ item, videoAttrs }" /> -->
    <video-player v-bind="videoAttrs" class="mb-6" />

    <form-panel title="Pause Banner" :active="item.active">
      <v-switch
        slot="active"
        v-model="item.active"
        label="Active"
        hide-details
        :loading="activating"
      />
      <p>
        Setting up pause banner here will show the pause banner on all
        vSnippets.
      </p>
      <v-row>
        <v-col>
          <m-media-field v-model="item.src" label="Image URL" />
        </v-col>
        <v-col>
          <m-link-field v-model="item.href" label="Destination Link" />
        </v-col>
      </v-row>

      <v-row class="mt-n6 mb-3">
        <v-checkbox
          v-for="option in options"
          :key="option.value"
          v-model="item[option.value]"
          :label="option.text"
          class="mx-4"
        ></v-checkbox>
      </v-row>
      <v-btn
        color="primary"
        :disabled="!hasChanges"
        :loading="loading"
        @click="save"
        >Save Changes
      </v-btn>
    </form-panel>
    <!-- <dev-raw :value="{ item, videoAttrs }" /> -->
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    data() {
      return {
        activating: false,
        loading: false,
        dataStr: '',
        options: [
          {
            text: 'Contain',
            value: 'contain',
          },
          {
            text: 'No Background',
            value: 'nobg',
          },
          {
            text: 'Poster Mode',
            value: 'poster',
          },
        ],
      }
    },

    computed: {
      ...mapGetters({
        item: 'pauseBanner',
        player: 'player',
      }),
      hasChanges() {
        return this.dataStr != JSON.stringify(this.item)
      },
      videoAttrs() {
        return {
          ...this.player,
          pauseBanner: { ...this.item, showOnReady: true },
        }
      },
    },

    methods: {
      async save() {
        this.$app.warning('Updating...')
        this.loading = true
        const form = {
          ...this.item,
        }

        await this.$app.post('pause-banner', form)

        this.dataStr = JSON.stringify(this.item)

        this.loading = false

        if (this.activating) {
          this.activating = false
        }

        this.$app.success('Updated!')
      },
    },

    mounted() {
      this.dataStr = JSON.stringify(this.item)
    },
  }
</script>
