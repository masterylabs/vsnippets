<template>
  <div>
    <p>
      Setting up pause banner here will show the pause banner on all vSnippets.
    </p>
    <v-row>
      <v-col>
        <m-media-field v-model="value.src" label="Image URL" @input="input" />
      </v-col>
      <v-col>
        <m-link-field
          v-model="value.href"
          label="Destination Link"
          @input="input"
        />
      </v-col>
    </v-row>

    <v-row class="mt-n6 mb-3">
      <v-checkbox
        v-for="option in options"
        :key="option.value"
        v-model="value[option.value]"
        :label="option.text"
        class="mx-4"
        @change="input"
      ></v-checkbox>
    </v-row>
  </div>
</template>

<script>
  export default {
    props: {
      value: {
        type: Object,
        default() {
          return {}
        },
      },
    },

    data() {
      return {
        options: [
          {
            text: 'Contain',
            value: 'contain',
          },
          {
            text: 'No Background',
            value: 'nobg',
          },
          {
            text: 'Poster Mode',
            value: 'poster',
          },
        ],
      }
    },

    methods: {
      input() {
        this.$emit('input', { ...this.value })
      },
    },
  }
</script>
