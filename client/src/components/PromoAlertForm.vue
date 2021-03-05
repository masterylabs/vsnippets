<template>
  <div>
    <p>
      Setting up promo alert here will show the pause banner on all vSnippets.
    </p>

    <v-row align="start">
      <v-col :cols="value.useBtn ? 12 : 6">
        <v-text-field
          :value="value.content"
          outlined
          label="Alert Text"
          placeholder="Special promotion now on!"
          hide-details
          @input="onval('content', $event)"
        />
      </v-col>

      <v-col v-if="!value.useBtn">
        <m-link-field
          :value="value.href"
          label="Website Link"
          @input="onval('href', $event)"
        />
      </v-col>
    </v-row>

    <v-expand-transition>
      <v-row v-if="value.useBtn" align="start">
        <v-col v-if="value.useBtn">
          <v-text-field
            :value="value.btnText"
            label="Button Text"
            placeholder="SHOP NOW"
            outlined
            hide-details
            append-icon="mdi-palette"
            @click:append="isBtnColor = true"
            @input="onval('btnText', $event)"
          />
        </v-col>
        <v-col>
          <m-link-field
            :value="value.href"
            label="Website Link"
            @input="onval('href', $event)"
          />
        </v-col> </v-row
    ></v-expand-transition>

    <v-row align="start" class="mt-n6" no-gutters>
      <m-alert-type-field
        :value="value.alertType"
        class="mr-3"
        @input="onval('alertType', $event)"
      />
      <v-col>
        <v-row no-gutters align="start" class="mt-n2">
          <v-checkbox
            v-for="option in options"
            :key="option.value"
            v-model="value[option.value]"
            :label="option.text"
            hide-details
            class="mx-4"
            @change="onval(option.value, $event)"
          ></v-checkbox>
        </v-row>
      </v-col>
    </v-row>

    <m-hms-field :value="value.showTime" @input="onval('showTime', $event)" />
    <!-- showtime: {{ value.showTime }} -->

    <v-dialog v-model="isBtnColor" hide-overlay width="300">
      <v-color-picker
        v-model="value.btnColor"
        @input="onval('btnColor', $event)"
      />
    </v-dialog>
  </div>
</template>

<script>
  import { prettyTime } from '@/helpers/video'
  export default {
    props: {
      value: {
        type: Object,
        default() {
          return {}
        },
      },
      duration: {
        type: Number,
        default: 0,
      },
    },

    data() {
      return {
        isBtnColor: false,
        options: [
          // {
          //   text: 'Can Close',
          //   value: 'dismissible',
          // },
          // {
          //   text: 'Dense',
          //   value: 'dense',
          // },
          // {
          //   text: 'Agressive',
          //   value: 'agressive',
          // },
          {
            text: 'CTA Button',
            value: 'useBtn',
          },
          {
            text: 'No Icon',
            value: 'noIcon',
          },
          {
            text: 'No Close',
            value: 'noClose',
          },
        ],
      }
    },

    methods: {
      onval(key, val) {
        const value = { ...this.value }
        value[key] = val
        this.$emit('input', value)
      },

      input() {
        this.$emit('input', { ...this.value })
      },
    },

    mounted() {
      if (!this.value.btnColor) {
        this.$emit('input', { ...this.value, btnColor: '#F44336FF' })
      }
    },

    filters: {
      pretty(n) {
        return prettyTime(n)
      },
    },
  }
</script>
