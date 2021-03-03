<template>
  <div class="video-player-promo-alert">
    <v-alert
      :value="active && !isClosed"
      :type="alertType || 'warning'"
      class="mx-3 my-3"
      :class="!isUseBtn && href ? 'ml-pointer' : ''"
      :dense="isDense"
      :icon="noIcon ? false : null"
      @click="onClick"
      @close="onClose"
    >
      <v-row no-gutters justify="space-between" align="center">
        <div>{{ content || 'Promo Alert' }}</div>
        <v-row no-gutters align="center" justify="end">
          <v-btn
            v-if="useBtn"
            :dark="btnIsDark"
            class="text-none"
            :color="btnColor || 'red'"
            :class="[
              `my-n${isDense ? 1 : 2}`,
              `${btnIsDark ? 'white' : 'black'}--text`,
            ]"
            :href="href"
            target="_blank"
            >{{ btnText || 'BUY NOW' }}
          </v-btn>
          <v-btn v-if="dismissible" class="my-n1 ml-2" icon @click="onClose"
            ><v-icon>mdi-close-circle</v-icon>
          </v-btn>
        </v-row>
      </v-row>
    </v-alert>
  </div>
</template>

<script>
  import isDark from '@/helpers/is-dark'
  export default {
    props: {
      isPreview: Boolean,
      active: [Boolean, String],
      dense: [Boolean, String],
      dismissible: [Boolean, String],
      alertType: [Boolean, String],
      useBtn: [Boolean, String],
      noIcon: [Boolean, String],
      btnText: {
        type: String,
        default: '',
      },
      btnColor: {
        type: String,
        default: '',
      },
      content: {
        type: String,
        default: 'Promo Alert Text!',
      },
      src: {
        type: String,
        default: '',
      },
      href: {
        type: String,
        default: '',
      },
      maxShowWidth: {
        type: [Number, String],
        default: 554,
      },
    },

    data() {
      return {
        isClosed: false,
      }
    },

    computed: {
      isDense() {
        return this.dense ? true : false
      },
      isDismissible() {
        return this.dismissible ? true : false
      },
      isUseBtn() {
        return this.useBtn ? true : false
      },
      btnIsDark() {
        return this.btnColor ? isDark(this.btnColor) : true
      },
    },

    methods: {
      onClick() {
        this.$emit('click')
        if (!this.isUseBtn && this.href) window.open(this.href)
      },

      onClose() {
        this.isClosed = true
        if (this.isPreview) {
          setTimeout(() => {
            this.isClosed = false
          }, 2000)
        }
      },
    },
  }
</script>

<style>
  .video-player-promo-alert {
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    z-index: 1;
    opacity: 1;
  }
</style>
