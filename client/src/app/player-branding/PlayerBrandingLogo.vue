<template>
  <div>
    <!-- branding {{ branding }} -->
    <!-- <dev-raw :value="{ branding }" /> -->
    <v-row>
      <v-col>
        <m-media-field
          v-model="branding.logo.src"
          label="Branding Logo or Image"
        />
      </v-col>
      <v-col>
        <m-link-field v-model="branding.logo.href" label="Website Link" />
      </v-col>
    </v-row>

    <v-row class="mt-n3">
      <v-slider
        v-model="branding.logo.size"
        label="Logo Size"
        thumb-label
        min="25"
        max="125"
        class="mx-4"
      />
      <v-slider
        v-model="branding.logo.opacity"
        label="Logo Opacity"
        thumb-label
        max="1"
        min="0.1"
        step="0.1"
        class="mx-4"
      />
    </v-row>

    <v-row no-gutters class="mt-n3" align="center">
      <m-placement-field v-model="branding.logo.position" />
      <v-checkbox
        label="No Crop"
        v-model="branding.logo.contain"
        class="ml-5 mb-n4"
      />
      <v-checkbox
        label="Round"
        v-model="branding.logo.round"
        class="ml-5 mb-n4"
      />
    </v-row>

    <!--  -->
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  export default {
    computed: {
      ...mapGetters({
        branding: 'playerBranding',
      }),
    },
  }
</script>
