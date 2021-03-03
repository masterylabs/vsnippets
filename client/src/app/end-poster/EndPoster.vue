<template>
  <div>
    <video-player v-bind="videoAttrs" class="mb-6" />

    <form-panel title="End Poster" :active="item.active">
      <template v-slot:actions>
        <v-btn
          @click="playFromStart = !playFromStart"
          hide-details
          class="mb-n2 mr-3"
          icon
          color="grey"
          ><v-icon>mdi-replay</v-icon></v-btn
        >
      </template>
      <v-switch
        slot="active"
        v-model="item.active"
        label="Active"
        hide-details
        :loading="activating"
      />
      <p>
        Setting up end banner here will show the end poster on all vSnippets.
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
        playFromStart: false,
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
            text: 'End Without Controls',
            value: 'noControls',
          },
        ],
      }
    },

    computed: {
      ...mapGetters({
        item: 'endPoster',
        player: 'player',
      }),
      hasChanges() {
        return this.dataStr != JSON.stringify(this.item)
      },
      videoAttrs() {
        return {
          ...this.player,
          remotePlayFromStart: this.playFromStart,
          endPoster: { ...this.item, isPreview: true },
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

        await this.$app.post('end-poster', form)

        this.dataStr = JSON.stringify(this.item)

        this.loading = false

        if (this.activating) {
          this.activating = false
        }

        this.$app.success('Updating!')
      },
    },

    mounted() {
      this.dataStr = JSON.stringify(this.item)
    },
  }
</script>
