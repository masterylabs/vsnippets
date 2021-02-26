<template>
  <form @submit.prevent="$emit('submit')">
    <v-text-field
      v-model="q"
      label="Search..."
      rounded
      prepend-inner-icon="mdi-magnify"
      hide-details
      :loading="loading"
      @keyup="keyup"
      @click:clear="keyup"
    />
  </form>
</template>

<script>
  export default {
    props: {
      loading: Boolean,
      value: {
        type: String,
        default: '',
      },
      // canSearch: Boolean,
    },

    data() {
      return {
        q: '',
      }
    },

    methods: {
      keyup() {
        this.$emit('input', this.q)
      },
    },
  }
</script>
