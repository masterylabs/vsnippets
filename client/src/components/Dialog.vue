<template>
  <div class="text-center">
    <v-dialog v-model="dialog" :width="width" :persistent="persistent">
      <template v-slot:activator="{ on, attrs }">
        <v-tooltip top :disabled="!tooltip">
          <template v-slot:activator="tooltip">
            <v-btn
              :dark="dark"
              :icon="!text && icon ? true : false"
              :outlined="outlined"
              :depressed="depressed"
              :class="btnClass"
              :disabled="disabled"
              :rounded="rounded"
              :color="color"
              :block="block"
              :large="large"
              v-bind="attrs"
              v-on="{ ...on, ...tooltip.on }"
            >
              <v-icon v-if="icon" :class="text ? 'mr-1' : ''"
                >mdi-{{ icon }}</v-icon
              >
              {{ text }}
            </v-btn>
          </template>
          <span>{{ tooltip }}</span>
        </v-tooltip>
      </template>

      <div style="position: relative">
        <template v-if="!lazy || dialog">
          <v-card v-if="card">
            <v-card-text>
              <slot />
            </v-card-text>
          </v-card>
          <slot v-else />
        </template>
        <v-btn
          absolute
          right
          top
          icon
          class="mt-n2 mr-n2"
          @click="dialog = false"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </div>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    props: {
      lazy: Boolean,
      open: Boolean,
      dark: Boolean,
      outlined: Boolean,
      depressed: Boolean,
      card: Boolean,
      remoteClose: Boolean,
      persistent: Boolean,
      disabled: Boolean,
      rounded: Boolean,
      block: Boolean,
      large: Boolean,
      color: {
        type: String,
        default: '',
      },
      text: {
        type: String,
        default: '',
      },
      icon: {
        type: String,
        default: '',
      },
      width: {
        type: String,
        default: '500',
      },
      btnClass: {
        type: String,
        default: '',
      },
      tooltip: {
        type: String,
        default: '',
      },
    },
    data() {
      return {
        dialog: false,
      }
    },

    beforeMount() {
      if (this.open) this.dialog = true
    },

    watch: {
      remoteClose() {
        this.dialog = false
      },
    },
  }
</script>
