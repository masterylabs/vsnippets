<template>
  <div>
    <v-icon
      :size="size"
      :color="forceColor ? forceColor : dark ? 'white' : 'black'"
      >mdi-content-cut</v-icon
    >
    <v-icon :size="size" :color="forceColor ? forceColor : color"
      >mdi-youtube</v-icon
    >
  </div>
</template>

<script>
  export default {
    props: {
      dark: Boolean,
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
    },
  }
</script>
