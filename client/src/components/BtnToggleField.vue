<template>
  <div class="mb-4">
    <m-field-label>{{ label }}</m-field-label>

    <v-row no-gutters style="margin: -0px -1px;">
      <!-- <v-card :key="`${item.value}a`"> -->
      <v-tooltip
        v-for="item in items"
        :key="item.value + '1'"
        bottom
        :disabled="!item.tooltip"
        open-delay="300"
      >
        <template v-slot:activator="{ on }">
          <v-hover v-slot="{ hover }">
            <v-card
              :min-width="width"
              :height="height"
              flat
              hover
              :dark="dark || value == item.value"
              :class="spacing"
              tile
              v-on="on"
              :color="
                value == item.value
                  ? 'primary'
                  : item.color
                  ? item.color
                  : valueColor
                  ? `${item.value}`
                  : hover
                  ? 'grey lighten-3'
                  : 'grey lighten-4'
              "
              style="margin:1px"
              class="rounded-sm"
              @click="select(item.value)"
            >
              <v-row no-gutters align="center" justify="center" class="ml-h100">
                <v-icon
                  v-if="item.icon"
                  v-text="`mdi-${item.icon}`"
                  :color="item.iconColor"
                  class="mr-1"
                  >mdi-{{ item.icon }}</v-icon
                >
                {{ item.text }}
              </v-row>
            </v-card>
          </v-hover>
        </template>
        <span v-text="item.tooltip" />
      </v-tooltip>
      <!-- </v-card> -->
    </v-row>
  </div>
</template>

<script>
  export default {
    props: {
      dark: Boolean,
      valueColor: Boolean,
      spacing: {
        type: String,
        default: 'px-3 py-1',
      },
      value: {
        type: [String, Number, Boolean],
        default: null,
      },
      height: {
        type: [Number, String],
        default: 38,
      },
      label: {
        type: String,
        default: '',
      },

      items: {
        type: Array,
        default() {
          return []
        },
      },
      width: {
        type: [String, Number],
        default: 32,
      },
    },

    methods: {
      select(v) {
        this.$emit('input', v)
      },
    },

    // beforeMount() {
    //   // if (this.value !== null) this.model = this.value
    //   // else {
    //   //   if (typeof this.value == 'number') this.model = 0
    //   //   else if (typeof this.value == 'string') this.model = ''
    //   //   else if (typeof this.value == 'boolean') this.model = false
    //   // }
    // },
  }
</script>
