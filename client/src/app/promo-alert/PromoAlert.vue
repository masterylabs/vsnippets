<template>
  <div>
    <video-player v-bind="videoAttrs" class="mb-6" />
    <form-panel title="Promo Alert" :active="item.active">
      <v-switch
        slot="active"
        v-model="item.active"
        label="Active"
        hide-details
        :loading="activating"
      />
      <p>
        Setting up promo alert here will show the pause banner on all vSnippets.
      </p>

      <v-row align="start">
        <v-col :cols="item.useBtn ? 12 : 6">
          <v-text-field
            v-model="item.content"
            outlined
            label="Alert Text"
            placeholder="Special promotion now on!"
            hide-details
          />
        </v-col>

        <v-col v-if="!item.useBtn">
          <m-link-field v-model="item.href" label="Website Link" />
        </v-col>
      </v-row>

      <v-expand-transition>
        <v-row v-if="item.useBtn" align="start">
          <v-col v-if="item.useBtn">
            <v-text-field
              v-model="item.btnText"
              label="Button Text"
              placeholder="SHOP NOW"
              outlined
              hide-details
              append-icon="mdi-palette"
              @click:append="isBtnColor = true"
            />
          </v-col>
          <v-col>
            <m-link-field v-model="item.href" label="Website Link" />
          </v-col> </v-row
      ></v-expand-transition>

      <v-row align="start" class="mt-n6" no-gutters>
        <m-alert-type-field v-model="item.alertType" class="mr-3" />
        <v-col>
          <v-row no-gutters align="start" class="mt-n2">
            <v-checkbox
              v-for="option in options"
              :key="option.value"
              v-model="item[option.value]"
              :label="option.text"
              hide-details
              class="mx-4"
            ></v-checkbox>
          </v-row>
        </v-col>
      </v-row>

      <v-btn
        color="primary"
        :disabled="!hasChanges"
        :loading="loading"
        @click="save"
        >Save Changes
      </v-btn>
    </form-panel>

    <v-dialog v-model="isBtnColor" hide-overlay width="300">
      <v-color-picker v-model="item.btnColor" />
    </v-dialog>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    data() {
      return {
        activating: false,
        loading: false,
        isBtnColor: false,
        dataStr: '',
        options: [
          {
            text: 'Can Close',
            value: 'dismissible',
          },
          {
            text: 'Dense',
            value: 'dense',
          },
          {
            text: 'CTA Button',
            value: 'useBtn',
          },
          {
            text: 'No Icon',
            value: 'noIcon',
          },
        ],
      }
    },

    computed: {
      ...mapGetters({
        item: 'promoAlert',
        player: 'player',
      }),
      hasChanges() {
        return this.dataStr != JSON.stringify(this.item)
      },
      videoAttrs() {
        return {
          ...this.player,
          promoAlert: { ...this.item, isPreview: true },
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

        this.dataStr = JSON.stringify(this.item)

        await this.$app.post('promo-alert', form)

        this.loading = false

        if (this.activating) {
          this.activating = false
        }

        this.$app.success('Updating!')
      },
    },

    mounted() {
      if (!this.item.btnColor) this.item.btnColor = '#F44336FF'
      this.dataStr = JSON.stringify(this.item)
    },
  }
</script>
