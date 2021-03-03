<template>
  <v-card class="pb-2">
    <v-row no-gutters justify="space-between" class="pr-4">
      <v-card-title v-text="title" />

      <v-row no-gutters align="center" justify="end">
        <slot name="actions" />
        <div class="mt-n2">
          <slot name="active" />
        </div>
      </v-row>
    </v-row>
    <v-card-text class="mt-n4">
      <slot />
    </v-card-text>
  </v-card>
</template>

<script>
  export default {
    props: ['active', 'title'],
  }
</script>
