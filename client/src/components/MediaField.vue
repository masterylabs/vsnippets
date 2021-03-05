<template>
  <v-text-field
    v-model="model"
    v-bind="attrs"
    :label="label"
    :placeholder="placeholder"
    append-icon="mdi-image"
    v-on="on"
    @click:append="onClick"
  />
</template>

<script>
  import modelMixin from '../mixins/model-text-field'
  export default {
    props: {
      multiple: Boolean,
      label: {
        type: String,
        default: 'Image',
      },
      placeholder: {
        type: String,
        default: 'https://image',
      },
    },
    mixins: [modelMixin],

    methods: {
      onClick() {
        if (!window.wp || !window.wp.media) {
          return this.$app.error('No WP Media Found')
        }

        const media = window.wp.media({
          title: 'Insert a media',
          // library: {type: 'image'},
          multiple: this.multiple,
        })

        media.on('select', () => {
          const selection = media
            .state()
            .get('selection')
            .first()
            .toJSON()

          this.model = selection.url

          this.$emit('input', selection.url)
        })

        media.open()
      },
    },
  }
</script>
