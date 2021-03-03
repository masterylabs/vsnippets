<template>
  <v-tooltip left>
    <template v-slot:activator="{ on }">
      <v-btn icon v-on="on" @click="click">
        <v-icon>mdi-code-brackets</v-icon>
      </v-btn>
    </template>
    <span>Copy shortcode</span>
  </v-tooltip>
</template>

<script>
  export default {
    props: {
      name: {
        type: String,
        default: 'shortcode',
      },
      id: {
        type: [String, Number],
        default: '',
      },
    },

    methods: {
      click() {
        const code = `[${this.name} id="${this.id}"]`
        this.$copyText(code).then(() => {
          this.$app.success('Copied to Clipboard!')
        })
      },
    },
  }
</script>
