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
        default: 'Rounded',
      },
    },

    mixins: [toggleFieldMixin],

    data() {
      return {
        items: [
          {
            value: '0',
            tooltip: 'None',
            text: '-',
          },
          {
            value: 'sm',
            tooltip: 'Small',
            text: 'S',
          },
          {
            value: 'md',
            tooltip: 'Medium',
            text: 'M',
          },
          {
            value: 'lg',
            tooltip: 'Large',
            text: 'L',
          },
          // {
          //   value: 'xl',
          //   tooltip: 'X-Large',
          //   text: 'XL',
          // },
          {
            value: 'pill',
            tooltip: 'Oval',
            text: 'O',
          },
          {
            value: 'circle',
            tooltip: 'Round',
            text: 'R',
          },
        ],
      }
    },
  }
</script>
