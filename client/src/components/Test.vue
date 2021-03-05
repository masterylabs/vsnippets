<template>
  <v-container>
    <div class="title">Test</div>

    <template v-if="data.logo">
      <v-text-field v-model="data.logo.src" />
      <v-switch v-model="data.logo.tile"></v-switch>
    </template>
    <v-btn @click="update">Update</v-btn>
    <dev-raw :value="data" />
  </v-container>
</template>

<script>
  export default {
    data() {
      return {
        data: {},
        endpoint: 'http://dev-wp.test/vsnippets/api/test',
      }
    },

    methods: {
      async update() {
        const jsonData = JSON.stringify(this.data)

        const response = await this.$app.post(this.endpoint, { jsonData })
      },
    },

    async beforeMount() {
      const { data } = await this.$app.get(this.endpoint)

      this.data = data
    },
  }
</script>
