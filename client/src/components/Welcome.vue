<template>
  <v-row align="center" justify="center">
    <div class="text-center" :style="isOver ? 'pointer-events:none' : ''">
      <m-logo size="100" :color="isOver ? 'success' : 'logo'" />

      <div class="title black--text text-h3 font-weight-regular mb-2">
        {{ isOver ? 'Drop It!' : brandTitle }}
      </div>
      <div class="caption">Drag YouTube {{ text }} here...</div>
      <v-btn
        class="my-4"
        color="primary"
        text
        :disabled="isOver"
        @click="youtube"
        >YouTube<v-icon class="ml-1">mdi-open-in-new</v-icon>
      </v-btn>
      <slot name="below" />
    </div>
  </v-row>
</template>

<script>
  import { openWindowLeft } from '../helpers/window'
  import brandMixin from '@/mixins/brand'

  export default {
    props: {
      isOver: Boolean,
      text: {
        type: String,
        default: 'video',
      },
    },
    mixins: [brandMixin],

    methods: {
      youtube() {
        openWindowLeft('https://youtube.com', 'YouTube')
      },
    },
  }
</script>
