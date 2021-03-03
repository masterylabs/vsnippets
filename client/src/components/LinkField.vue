<template>
  <v-text-field v-model="model" v-bind="attrs" placeholder="https://" v-on="on">
    <v-btn
      slot="append"
      icon
      class="mt-n2 mr-n1"
      :disabled="!valid"
      :href="model"
      target="_blank"
    >
      <v-icon>mdi-open-in-new</v-icon>
    </v-btn>
  </v-text-field>
</template>

<script>
  import isUrl from '../helpers/is-url'
  import textFieldMixin from '../mixins/model-text-field'
  export default {
    mixins: [textFieldMixin],
    computed: {
      valid() {
        return isUrl(this.model)
      },
    },
  }
</script>
