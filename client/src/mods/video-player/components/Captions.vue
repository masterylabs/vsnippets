<template>
  <v-row no-gutters align="center">
    <v-tooltip left>
      <template v-slot:activator="{ on, attrs }">
        <v-icon :color="active ? color : 'grey lighten-1'" dark icon v-on="on" v-bind="attrs" @click="toggle"
          >mdi-closed-caption{{ active ? '' : '-outline' }}
        </v-icon>
      </template>
      <span>Closed Captions</span>
    </v-tooltip>

    <v-col class="px-3">
      <v-switch
        v-if="!tracklist || tracklist.length < 2"
        v-model="toggler"
        label="Closed Captions"
        :color="color"
        @change="toggle"
        hide-details
        class="mt-n1"
      ></v-switch>

      <v-select v-else v-model="val" :items="items" hide-details class="mt-n4" @change="change" />
    </v-col>
  </v-row>
</template>

<script>
  export default {
    props: {
      active: Boolean,
      index: {
        type: Number,
        default: 0,
      },
      tracklist: {
        type: Array,
        default() {
          return []
        },
      },
      color: {
        type: String,
        default: '',
      },
    },

    data() {
      return {
        val: '',
        toggler: false,
      }
    },

    computed: {
      items() {
        return this.tracklist.map((a, index) => {
          return {
            text: a.displayName,
            value: index,
          }
        })
      },
    },

    methods: {
      change(v) {
        this.$emit('change', v)
      },
      setVal() {
        this.val = this.index
      },
      toggle() {
        this.$emit('toggle')
      },
    },

    beforeMount() {
      if (this.tracklist && this.tracklist.length) this.setVal()
    },

    watch: {
      index() {
        this.setVal()
      },
      active() {
        this.toggler = this.active
      },
    },
  }
</script>
