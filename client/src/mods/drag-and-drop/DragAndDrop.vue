<template>
  <v-container
    :fill-height="isOver || fillHeight"
    fluid
    class="py-0"
    @dragover.prevent="dragenter"
    @drop.prevent="drop"
    :style="`position:absolute;left:0px;top:0px;width:100%;min-height:100%`"
    :class="isOver ? dropClass : ''"
  >
    <v-row justify="center">
      <slot v-if="isOver" name="over">
        <div class="display-2">DROP IT!</div>
      </slot>
      <slot v-else />
    </v-row>
  </v-container>
</template>

<script>
  import { getThumbInfo } from './helpers'
  export default {
    props: {
      disabled: Boolean,
      fillHeight: Boolean,
      text: {
        type: String,
        default: 'video',
      },
      dropClass: {
        type: String,
        default: 'primary white--text',
      },
    },
    data() {
      return {
        isOverWait: null,
        isOver: false,
      }
    },

    methods: {
      dragenter() {
        if (this.disabled) return

        clearTimeout(this.isOverWait)
        this.isOver = true

        this.isOverWait = setTimeout(() => {
          this.isOver = false
        }, 300)
      },

      drop(e) {
        if (this.disabled) return

        const { dataTransfer } = e
        const url = dataTransfer.getData('URL')

        const video = getThumbInfo(dataTransfer)

        if (video.videoId) video.isYouTube = true
        else if (url.indexOf('https://vimeo.com') == 0) {
          const [, vimeoId] = url.split('https://vimeo.com/')
          video.videoId = vimeoId
          video.isVimeo = true
        }

        this.$emit('drop', { dataTransfer, url, video })
      },
    },
  }
</script>
