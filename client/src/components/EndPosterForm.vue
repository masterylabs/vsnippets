<template>
  <div>
    <p>
      Setting up end banner here will show the end poster on all vSnippets.
    </p>
    <v-row>
      <v-col>
        <m-media-field v-model="value.src" label="Image URL" />
      </v-col>
      <v-col>
        <m-link-field v-model="value.href" label="Destination Link" />
      </v-col>
    </v-row>

    <v-row class="mt-n6 mb-3">
      <v-checkbox
        v-for="option in options"
        :key="option.value"
        v-model="value[option.value]"
        :label="option.text"
        class="mx-4"
      ></v-checkbox>
    </v-row>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

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
        dataStr: '',
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
            text: 'End Without Controls',
            value: 'noControls',
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
