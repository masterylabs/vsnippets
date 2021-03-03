<template>
  <div>
    <div class="text-center">
      <v-icon
        :size="large ? 100 : size"
        :color="forceColor ? forceColor : dark ? 'white' : 'black'"
        v-text="`mdi-${logo}`"
      />
      <v-icon
        :size="large ? 100 : size"
        :color="forceColor ? forceColor : color"
        >mdi-youtube</v-icon
      >
    </div>
    <div
      v-if="!noText"
      class="title black--text text-h3 font-weight-regular mb-2"
    >
      {{ text ? text : 'vSnippets' }}
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      dark: Boolean,
      noText: Boolean,
      large: Boolean,
      size: {
        type: [String, Number],
        default: 20,
      },
      color: {
        type: String,
        default: 'logo',
      },
      color2: {
        type: String,
        default: 'black',
      },
      forceColor: {
        type: String,
        default: '',
      },
      logo: {
        type: String,
        default: 'content-cut',
      },
      text: {
        type: String,
        default: '',
      },
    },
  }
</script>
