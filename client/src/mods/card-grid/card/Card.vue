<template>
  <v-hover v-slot="{ hover }" :disabled="noHover">
    <v-card :elevation="hover ? hoverElevation : elevation" :width="width">
      <slot />

      <!-- Actions  -->
      <v-card-actions>
        <template v-for="(a, i) in actions">
          <v-spacer v-if="i == 2" :key="`actionspacer${i}`" />

          <v-tooltip :key="a.value" top :disabled="!a.tooltip">
            <template v-slot:activator="tooltip">
              <v-btn
                :icon="!a.text"
                v-bind="a.attrs"
                v-on="tooltip.on"
                @click="a.click"
              >
                <v-icon v-text="`mdi-${a.value}`" />
              </v-btn>
            </template>
            <span v-text="a.tooltip" />
          </v-tooltip>
        </template>
      </v-card-actions>

      <v-expand-transition>
        <div v-show="more">
          <v-divider></v-divider>

          <v-card-text>
            <slot name="more" :item="item">
              {{ item.description }}
            </slot>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-tooltip v-if="!del" left>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on" @click="del = true">
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </template>
              <span>Delete</span>
            </v-tooltip>
            <template v-else>
              <v-btn color="error" :loading="deleting" @click="onDelete">
                Delete?</v-btn
              >
              <v-btn depressed class="ml-2" @click="del = false">Cancel</v-btn>
            </template>
          </v-card-actions>
        </div>
      </v-expand-transition>
    </v-card>
  </v-hover>
</template>

<script>
  import { defaultValues } from '../config'
  import getUrlMixin from '@/mixins/get-url'

  export default {
    props: {
      noHover: Boolean,
      deleting: Boolean,
      item: {
        type: Object,
        required: true,
      },
      name: {
        type: String,
        default: '',
      },
      width: {
        type: [String, Number],
        default: defaultValues.cardWidth,
      },
      elevation: {
        type: [String, Number],
        default: defaultValues.elevation,
      },
      hoverElevation: {
        type: [String, Number],
        default: defaultValues.hoverElevation,
      },
    },

    mixins: [getUrlMixin],

    data() {
      return {
        more: false,
        del: false,
        actions: [
          {
            tooltip: 'Copy URL',
            value: 'link',
            click: () => this.copyUrl(),
          },
          {
            tooltip: 'Open Page',
            value: 'open-in-new',
            click: () => this.openLink(),
          },
          {
            tooltip: 'Edit',
            value: 'pencil',
            click: () => this.select(),
            attrs: {
              color: 'primary',
            },
          },
          {
            value: 'chevron-down',
            click: () => (this.more = !this.more),
          },
        ],
      }
    },

    methods: {
      onDelete() {
        this.$emit('delete', this.item.id)
      },
      select() {
        this.$emit('select', this.item.id)
        // this.$router.push({
        //   name: this.name,
        //   params: { id: this.item.id },
        // })
      },

      openLink() {
        const url = this.getUrl(this.item.slug)
        window.open(url)
      },

      async copyUrl() {
        const url = this.getUrl(this.item.slug)
        await this.$copyText(url)
        this.$app.success('Url to Clipboard!')
      },
    },
  }
</script>
