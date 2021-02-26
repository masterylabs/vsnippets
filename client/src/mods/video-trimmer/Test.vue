<template>
  <drag-and-drop-container @videoId="snippet.src = $event">
    <video-trimmer-welcome v-if="!snippet.src">
      <video-trimmer-video-field slot="below" v-model="snippet.src" />
    </video-trimmer-welcome>

    <v-container>
      <video-trimmer v-model="snippet" />

      <!-- <v-row align="center" justify="center" class="mt-12">
        <dev-raw :value="{ snippet }" title="Test" />
      </v-row> -->
    </v-container>
  </drag-and-drop-container>
</template>

<script>
  export default {
    data() {
      return {
        snippet: {
          src: '5S4T-uTvqPY', // 'QbYPCjO2vYg',
          // src: '',
          poster: '',
          trimStart: 279,
          trimEnd: 674,
        },
      }
    },

    beforeMount() {
      // this.snippet.src = 'dI7yH9xa2nY'
      // this.snippet.src = 'QbYPCjO2vYg'
      this.snippet.src = 'QbYPCjO2vYg'
      // this.snippet.src =
      //   'https://www.dropbox.com/s/kr9h38xhsawuknp/countdown.mp4?raw=1'
    },
  }

  /**
   * 
### Test Videos

- https://www.dropbox.com/s/kr9h38xhsawuknp/countdown.mp4?raw=1
- https://vimeo.com/14213714
- https://youtu.be/5S4T-uTvqPY countdown

Three Second Test Video Grey:
https://youtu.be/1O0yazhqaxs

Three Second Test Video Blue
https://youtu.be/18DYQVYKqTU

Three Second Test Video Red
https://youtu.be/-c4yVUrVCzw

Three Second Test Video Green
https://youtu.be/gkZEhCeeXkI

   */
</script>
