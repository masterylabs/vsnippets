<template>
  <div>
    <m-field-label class="ml-2">{{ label }}</m-field-label>
    <v-row style="max-width:250px" class="mx-0">
      <v-text-field
        v-for="field in fields"
        :key="field.value"
        v-model="model[field.value]"
        outlined
        :label="field.text"
        type="number"
        min="0"
        :max="field.max"
        cols="4"
        placeholder="0"
        class="mx-1"
        @input="input"
      />
    </v-row>
  </div>
</template>

<script>
  export default {
    props: {
      value: {
        type: [String, Number],
        default: 0,
      },
      label: {
        type: String,
        default: 'Wait Before Display',
      },
    },

    beforeMount() {
      if (this.value) this.setValue()
    },

    data() {
      return {
        model: {
          hrs: 0,
          mins: 0,
          secs: 0,
        },
        fields: [
          {
            text: 'Hours',
            value: 'hrs',
            max: 10,
          },
          {
            text: 'Mins',
            value: 'mins',
            max: 59,
          },
          {
            text: 'Secs',
            value: 'secs',
            max: 59,
          },
        ],
      }
    },

    methods: {
      setValue() {
        const value = parseInt(this.value)
        if (!value) {
          for (let k in this.model) {
            this.model[k] = 0
          }
          return
        }

        let hrs = 0,
          mins = 0,
          secs = value

        if (secs >= 3600) {
          hrs = Math.floor(secs / 3600)
          secs = secs - hrs * 3600
        }

        if (secs >= 60) {
          mins = Math.floor(secs / 60)
          secs = secs - mins * 60
        }

        this.model.hrs = hrs
        this.model.mins = mins
        this.model.secs = secs
      },
      input() {
        let v = 0

        if (this.model.hrs && this.model.hrs != '0') {
          v = v + parseInt(this.model.hrs) * 3600
        }

        if (this.model.mins && this.model.mins != '0') {
          v = v + parseInt(this.model.mins) * 60
        }

        if (this.model.secs && this.model.secs != '0') {
          v = v + parseInt(this.model.secs)
        }

        this.$emit('input', v)
      },
    },
  }
</script>
