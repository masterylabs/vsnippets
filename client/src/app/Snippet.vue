<template>
  <v-container class="mt-6">
    <v-fade-transition>
      <div v-if="ready">
        <v-row no-gutters justify="end" class="mb-7">
          <m-snippet-actions :slug="data.identifier" :id="data.id" />
          <m-dialog
            persistent
            icon="pencil"
            color="primary"
            :remote-close="remoteCloseForm"
            tooltip="Edit"
            card
          >
            <form @submit.prevent="updateForm">
              <v-text-field v-model="data.name" label="Name" outlined />
              <v-textarea v-model="data.description" label="Name" outlined />
              <m-video-field
                v-model="video.src"
                @input="onVideoChange"
                outlined
              />
              <v-text-field v-model="data.image" label="Image" outlined />
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
        <video-trimmer
          :value="trimmerValue"
          @input="onInput"
          @video-title="onVideoTitle"
          @ready="onVideoReady"
        />
      </div>
    </v-fade-transition>

    <!-- PREMIUM FEATURES -->
    <div v-if="ready" class="mt-10">
      <v-card v-for="(panel, index) in getPanels" :key="panel.value" tile>
        <v-row
          justify="space-between"
          class="pr-9 ml-pointer"
          no-gutters
          @click="onPanel(index, panel.value)"
        >
          <v-card-title class="py-0" hide-details v-text="panel.text" />
          <div v-on="onPanelActive">
            <v-switch v-model="video[panel.value].active" label="Active" />
          </div>
        </v-row>
        <v-expand-transition>
          <v-card-text v-if="panelIndex == index">
            <component
              :is="panel.component"
              v-model="video[panel.value]"
              :duration="videoDuration"
            />
          </v-card-text>
        </v-expand-transition>
      </v-card>

      <!-- <v-divider class="mb-12"></v-divider> -->

      <!-- <dev-raw :value="video.pauseBanner" /> -->
    </div>

    <v-btn
      v-if="!isPublish"
      large
      block
      class="mt-11 grey lighten-4 text-none font-weight-regular"
      colorx=""
      depressed
      rounded
      @click="publish"
      >Publish</v-btn
    >

    <v-fade-transition>
      <v-card v-if="isPublish" class="mt-10 mb-12">
        <v-card-text>
          <div class="text-center mb-3">
            <span class="yellowx body-1 lighten-4 px-1 black--text body-2">
              To add this video snippet to your website, please use the
              following shortcode your posts and pages.</span
            >
          </div>

          <v-text-field
            class="title font-weight-regular ml-video-field-input--centered"
            label="Shortcode"
            solox
            flatx
            roundedx
            outlined
            readonly
            autofocusx
            hide-details
            :value="shortcode"
          />
        </v-card-text>
      </v-card>
    </v-fade-transition>

    <!-- <dev-raw :value="{ overPanelActive, video }" /> -->
  </v-container>
</template>

<script>
  import { mapGetters } from 'vuex'
  import form from '../mixins/snippet-form'
  import getUrlMixin from '@/mixins/get-url'
  import brandMixin from '@/mixins/brand'

  export default {
    mixins: [getUrlMixin, brandMixin],
    data() {
      return {
        adminView: '',
        videoDuration: 0,
        overPanelActive: false,
        ready: false,
        loading: false,
        updatingForm: false,
        remoteCloseForm: false,
        deleting: false,
        isPublish: false,
        form,
        panelIndex: null,
        data: {},
        video: {
          pauseBanner: {},
          promoAlert: {},
          endPoster: {},
        }, //
        videoStr: '',
        panels: [
          {
            text: 'Pause Banner',
            value: 'pauseBanner',
            component: 'm-pause-banner-form',
            hide: () => !this.hasPauseBanner,
          },
          {
            text: 'Promo Alert',
            value: 'promoAlert',
            component: 'm-promo-alert-form',
            hide: () => !this.hasPromoAlert,
          },
          {
            text: 'End Poster',
            value: 'endPoster',
            component: 'm-end-poster-form',
            hide: () => !this.hasEndPoster,
          },
        ],
        onPanelActive: {
          mouseenter: () => (this.overPanelActive = true),
          mouseleave: () => (this.overPanelActive = false),
        },
      }
    },

    computed: {
      // trimmedDuration() {
      //   let t = 0

      //   if(this.video.trimStart)
      // },

      getPanels() {
        return this.panels.filter((a) => !a.hide || !a.hide())
      },

      endpoint() {
        return `videos/${this.$route.params.id}`
      },
      hasChanges() {
        return this.ready && this.videoStr != JSON.stringify(this.video)
      },
      canUpdateForm() {
        return true
      },
      shortcode() {
        return `[vsnippets id="${this.data.id}"]`
      },
      shareLink() {
        return `${this.$app.config.route}/${this.data.identifier}`
      },
      ...mapGetters({
        playerBranding: 'playerBranding',
      }),
      trimmerValue() {
        const value = {
          ...this.video,
          isAdmin: true,
          adminView: this.adminView,
        }

        if (this.playerBranding) {
          const br = this.playerBranding
          if (br.color) value.color = br.color
          if (br.logo && br.logo.active) value.logo = br.logo
        }

        return value
        // return {
        //   ...this.playerBranding,
        //   ...this.video,
        // }
      },
    },

    methods: {
      onVideoReady(n) {
        this.videoDuration = n
      },

      onPanel(index) {
        if (this.overPanelActive) return
        const value = this.panelIndex !== index ? index : null
        this.panelIndex = value

        if (value !== null) {
          this.adminView = this.panels[value].value
        } else this.adminView = ''
      },
      onInput(video) {
        this.video = video
      },
      publish() {
        if (this.hasChanges) this.saveVideo()
        this.copyShortcode()
        this.isPublish = true
      },

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

        if (this.data.image) this.video.poster = this.data.image

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

      copyShortcode() {
        this.$copyText(this.shortcode).then(() => {
          this.$app.success('Copied to Clipboard!')
        })
      },
    },

    async beforeMount() {
      const { data } = await this.$app.get(this.endpoint)
      if (!data.id) this.$router.replace({ name: 'home' })
      this.data = data
      if (data.content) {
        const video = JSON.parse(data.content)

        if (typeof video == 'object') {
          if (!video.pauseBanner) video.pauseBanner = {}
          if (!video.promoAlert) video.promoAlert = {}
          if (!video.endPoster) video.endPoster = {}
          this.video = video
        }
      }

      this.videoStr = JSON.stringify(this.video)
      this.ready = true
    },
  }
</script>
