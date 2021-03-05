<template>
  <v-text-field
    :value="value"
    :placeholder="placeholder"
    :solo="styled"
    :rounded="styled"
    outlined
    label="Video"
    :style="styled ? 'width:350px' : ''"
    :class="styled ? 'ml-video-field-input--centered' : ''"
    @input="input"
  />
</template>

<script>
  import { getVideoMin } from '../helpers/video'
  export default {
    props: {
      styled: Boolean,
      value: {
        type: String,
        default: '',
      },
      placeholder: {
        type: String,
        default: 'https://video-file, YouTube or Vimeo',
      },
    },

    methods: {
      input(v) {
        const value = getVideoMin(v)
        this.$emit('input', value)
        // this.model = value
      },
    },
  }
</script>

<style>
  .ml-video-field-input--centered input {
    text-align: center;
  }
</style>
