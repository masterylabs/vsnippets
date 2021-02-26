<template>
  <v-container class="mt-6">
    <v-fade-transition>
      <div v-if="ready">
        <v-row no-gutters justify="end" class="mb-7">
          <m-dialog
            persistent
            icon="pencil"
            color="primary"
            :remote-close="remoteCloseForm"
            card
            openx
          >
            <form @submit.prevent="updateForm">
              <v-text-field v-model="data.name" label="Name" />
              <v-textarea v-model="data.description" label="Name" />
              <m-video-field v-model="video.src" @input="onVideoChange" />
              <v-text-field v-model="data.image" label="Image" />
              <v-row align="center" justify="space-between" no-gutters>
                <v-btn color="primary" type="submit" :disabled="!canUpdateForm"
                  >Update</v-btn
                >
                <m-delete-btn
                  class="mr-1"
                  :loading="deleting"
                  @click="onDelete"
                />
              </v-row>
            </form>
          </m-dialog>

          <v-btn
            class="ml-3"
            color="primary"
            :disabled="!hasChanges"
            :loading="loading"
            @click="saveVideo"
            >Save Changes</v-btn
          >
        </v-row>
        <video-trimmer v-model="video" @video-title="onVideoTitle" />
      </div>
    </v-fade-transition>

    <!-- <v-btn x-large block class="mt-11" color="success" depressed>Publish</v-btn> -->

    <!-- <dev-raw :value="{ video }" title="Snippet" /> -->
  </v-container>
</template>

<script>
  import form from '../mixins/snippet-form'
  export default {
    data() {
      return {
        ready: false,
        loading: false,
        updatingForm: false,
        remoteCloseForm: false,
        deleting: false,
        form,
        data: {},
        video: {}, //
        videoStr: '',
      }
    },

    computed: {
      endpoint() {
        return `videos/${this.$route.params.id}`
      },
      hasChanges() {
        return this.ready && this.videoStr != JSON.stringify(this.video)
      },
      canUpdateForm() {
        return true
      },
    },

    methods: {
      onVideoTitle(title) {
        if (!this.data.name) {
          this.data.name = title
          // potentially update youtbut thum if no image
          // https://i.ytimg.com/vi/MHj8I6Uh8qs/hqdefault.jpg
          this.updateForm(true, true)
        }
      },

      async onDelete() {
        this.deleting = true
        await this.$app.post(`${this.endpoint}/delete`)
        this.$router.push({ name: 'home' })
      },

      onVideoChange() {
        this.video.trimStart = 0
        this.video.trimEnd = 0
      },

      async updateForm(force = false, noMessage = false) {
        if ((!this.canUpdateForm && !force) || (this.updatingForm && !force))
          return

        this.updatingForm = true

        const content = JSON.stringify(this.video)

        const form = {
          name: this.data.name,
          description: this.data.description,
          image: this.data.image,
          content,
        }

        const { data } = await this.$app.post(this.endpoint, form)
        if (data.updated) this.data.updated = data.updated

        if (!noMessage && data) this.$app.success('Updated!')

        this.videoStr = content

        // const videoChanged =
        // changes made in form
        this.updatingForm = false
        this.remoteCloseForm = !this.remoteCloseForm
      },

      async saveVideo() {
        this.loading = true

        const content = JSON.stringify(this.video)
        // update source if needed

        const { data } = await this.$app.post(this.endpoint, { content })

        // update updated
        if (data.updated) this.data.updated = data.updated

        if (data) this.$app.success('Saved!')

        this.videoStr = content
        this.loading = false
      },
    },

    async beforeMount() {
      const { data } = await this.$app.get(this.endpoint)
      if (!data.id) this.$router.replace({ name: 'home' })
      this.data = data
      if (data.content) this.video = JSON.parse(data.content)

      console.log(this.video)

      this.videoStr = JSON.stringify(this.video)
      this.ready = true
    },
  }
</script>
