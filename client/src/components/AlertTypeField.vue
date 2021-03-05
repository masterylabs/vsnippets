<template>
  <div>
    <m-btn-toggle-field
      v-bind="attrs"
      :items="items"
      :label="label"
      height="36"
      spacing="px-4 py-1"
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
        default: '',
      },
    },

    mixins: [toggleFieldMixin],

    data() {
      return {
        items: [
          {
            value: 'info',
            text: 'Info',
            // icon: 'alert-circle',
            // iconColor: 'info',
          },
          {
            value: 'success',
            text: 'Success',
            // icon: 'check-circle',
            // iconColor: 'success',
          },
          {
            value: 'warning',
            text: 'Attention',
            // icon: 'alert-circle',
            // iconColor: 'orange',
          },
          {
            value: 'error',
            text: 'Error',
            // icon: 'alert',
            // iconColor: 'error',
          },
        ],
      }
    },
  }
</script>
