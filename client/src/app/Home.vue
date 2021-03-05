<template>
  <drag-and-drop :fill-height="!hasItems" @drop="onDrop">
    <v-container
      fluid
      class="mb-8"
      :class="hasItems ? 'elevation-2x grey lighten-4 pt-8' : ''"
    >
      <v-row>
        <m-welcome>
          <m-video-field slot="below" styled @input="onVideoField" />
        </m-welcome>
      </v-row>
    </v-container>

    <card-grid name="video" get-total hide-none @total="onTotal">
      <template slot="toolbar-content">
        <m-dialog
          text="Add Snippet"
          persistent
          icon="plus"
          large
          outlined
          color="primary"
        >
          <m-form :form="form" autofocus @created="onCreated" />
        </m-dialog>
      </template>

      <!-- <template v-slot:card-content="{ item }">
        {{ item }}
        <v-img v-if="item.image" :src="item.image"></v-img>
      </template> -->
    </card-grid>

    <v-overlay
      :value="!ready || loading"
      color="white"
      :opacity="!ready ? 1 : 0.5"
    >
      <v-progress-circular indeterminate size="200" color="black">
        <m-logo size="80" />
      </v-progress-circular>
    </v-overlay>
  </drag-and-drop>
</template>

<script>
  import { isYouTube } from '@/helpers/video'
  export default {
    data() {
      return {
        ready: false,
        form: {
          endpoint: 'videos',
          fields: [
            {
              text: 'Name',
              value: 'name',
            },
            {
              text: 'Description',
              value: 'description',
              type: 'textarea',
            },
            {
              text: 'Video',
              value: 'video',
              component: 'm-video-field',
            },
            {
              text: 'Image',
              value: 'image',
            },
          ],
          onCreate: (form) => {
            const content = {}
            if (form.video) content.src = form.video
            if (form.image) content.poster = form.image
            form.content = JSON.stringify(content)
            return form
          },
        },
        loading: false,
        hasItems: false,
      }
    },

    methods: {
      onDrop({ video }) {
        if (!video.videoId) return this.$app.error('Invalid Drop')

        const form = {
          src: video.videoId,
        }
        if (video.isYouTube) {
          form.image = `https://i.ytimg.com/vi/${video.videoId}/hqdefault.jpg`
        }
        this.createSnippet(form)
      },

      onVideoField(src) {
        const form = {
          src,
        }

        if (isYouTube(src))
          form.image = `https://i.ytimg.com/vi/${src}/hqdefault.jpg`

        this.createSnippet(form)
      },

      async createSnippet(form) {
        this.loading = true

        // get video title :TODO
        const snippet = {
          src: form.src,
        }
        if (form.image) snippet.poster = form.image

        form.content = JSON.stringify(snippet)

        const { data } = await this.$app.post('videos', form)

        if (!data || !data.id) {
          this.loading = false
          return this.$app.error('Unable to create video')
        }

        const id = data.id
        this.$router.push({ name: 'video', params: { id } })
      },

      onTotal(n) {
        this.hasItems = n > 0
        this.ready = true
      },
      onCreated({ id }) {
        // add video to email
        this.$router.push({ name: 'video', params: { id } })
      },
    },
  }
</script>
