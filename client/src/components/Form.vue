<template>
  <form @submit.prevent="submit">
    <v-card class="py-4 px-3">
      <v-card-title class="text-capitalize">{{ getTitle }}</v-card-title>
      <v-card-text>
        <template v-for="(field, index) in getFields">
          <v-expand-transition :key="field.value">
            <div v-show="!field.hide || !field.hide(val)">
              <slot
                v-if="slotFields && slotFields.indexOf(field.value) > -1"
                :name="field.value"
              />
              <v-row v-else-if="field.options">
                <template v-for="option in field.options">
                  <v-expand-transition :key="option.value">
                    <v-switch
                      v-show="!option.hide || !option.hide(val)"
                      v-model="val[option.value]"
                      :label="option.text"
                      :disabled="option.disabled ? option.disabled(val) : false"
                      hide-details
                      class="mx-3"
                    />
                  </v-expand-transition>
                </template>
              </v-row>
              <component
                v-else-if="field.component"
                :is="field.component"
                v-model="val[field.value]"
                v-on="field.on"
                v-bind="field.props"
                :label="field.label"
                :disabled="field.disabled ? field.disabled(val) : false"
              />
              <!-- :options="field.componentOptions" -->

              <!-- :labelx="field.text" -->
              <v-textarea
                v-else-if="field.type && field.type == 'textarea'"
                v-model="val[field.value]"
                :label="field.text"
                :rows="field.rows || 3"
                :disabled="field.disabled ? field.disabled(val) : false"
                :outlined="outlined"
              />
              <v-switch
                v-else-if="field.type && field.type == 'switch'"
                v-model="val[field.value]"
                :label="field.text"
                :disabled="field.disabled ? field.disabled(val) : false"
                hide-details
              />
              <v-text-field
                v-else
                v-model="val[field.value]"
                :label="field.text"
                :disabled="field.disabled ? field.disabled(val) : false"
                :autofocus="autofocus && index == 0 && !val[field.value]"
                :outlined="outlined"
              />
            </div>
          </v-expand-transition>
        </template>
      </v-card-text>
      <v-card-actions>
        <v-btn
          type="submit"
          color="primary"
          :loading="loading || remoteLoading"
          :disabled="!canSave"
          v-text="getBtnText"
        />
      </v-card-actions>

      <v-btn
        v-if="canClose"
        large
        absolute
        right
        top
        icon
        @click="$emit('close')"
        ><v-icon>mdi-close</v-icon></v-btn
      >
      <slot name="end" />
    </v-card>
  </form>
</template>

<script>
  export default {
    props: {
      autofocus: Boolean,
      remoteLoading: Boolean,
      outlined: {
        type: Boolean,
        default: true,
      },
      value: {
        type: Object,
        default() {
          return {}
        },
      },
      form: {
        type: Object,
        default: null,
      },
      canClose: Boolean,
      create: Boolean,
      title: {
        type: String,
        default: '',
      },
      btnText: {
        type: String,
        default: '',
      },
      fields: {
        type: Array,
        default() {
          return []
        },
      },
      endpoint: {
        type: String,
        default() {
          return this.$route.path
        },
      },
      slotFields: {
        type: Array,
        default: null,
      },
    },

    data() {
      return {
        loading: false,
        val: {},
        changeStr: '',
      }
    },

    computed: {
      isCreate() {
        return this.create || !this.value.id ? true : false
      },
      getTitle() {
        return this.title
          ? this.title
          : this.form && this.form.title
          ? this.form.title
          : ''
      },
      getFields() {
        return this.form && this.form.fields ? this.form.fields : this.fields
      },
      getBtnText() {
        if (this.form && this.form.btnText) return this.form.btnText
        if (this.btnText) return this.btnText
        return this.isCreate ? 'Add' : 'Update'
        // return this.create || (this.form && this.form.create) ? 'Add' : 'Update'
      },

      canSave() {
        return !this.changeStr || this.changeStr != JSON.stringify(this.val)
      },
    },

    methods: {
      getEndpoint() {
        return this.form.endpoint ? this.form.endpoint : this.endpoint
      },
      async submit() {
        this.loading = true
        const url = this.getEndpoint()

        let form = {
          ...this.val,
        }

        if (this.isCreate && this.form && this.form.onCreate) {
          form = this.form.onCreate(form)
        } else if (!this.isCreate && this.form && this.form.onUpdate) {
          form = this.form.onUpdate(form)
        }

        const data = await this.$app.post(url, form)

        if (this.form && this.form.onCreated) this.form.onCreated(data)

        this.changeStr = JSON.stringify(this.val)

        this.loading = false

        if (this.isCreate) {
          this.$app.success('Added')
          return this.$emit('created', data.data)
        }

        this.$app.success('Updated')
        this.$emit('input', data.data)
      },
    },

    beforeMount() {
      if (this.value) {
        this.val = { ...this.value }
        this.changeStr = JSON.stringify(this.val)
      }
    },
  }
</script>
