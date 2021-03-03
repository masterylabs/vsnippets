<template>
  <div>
    <m-btn-toggle-field
      v-bind="attrs"
      :items="items"
      :label="label"
      v-on="on"
    />
  </div>
</template>

<script>
  import toggleFieldMixin from '../mixins/toggle-field'

  export default {
    props: {
      label: {
        type: String,
        default: 'Placement',
      },
    },

    mixins: [toggleFieldMixin],

    data() {
      return {
        items: [
          {
            value: 'tl',
            tooltip: 'Top Left',
            text: 'TL',
          },
          {
            value: 'tr',
            tooltip: 'Top Right',
            text: 'TR',
          },
          {
            value: 'bl',
            tooltip: 'Bottom Left',
            text: 'BL',
          },
          {
            value: 'br',
            tooltip: 'Bottom Right',
            text: 'BR',
          },
        ],
      }
    },
  }
</script>
