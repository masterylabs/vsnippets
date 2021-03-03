<template>
  <div>
    <div class="grey lighten-4 py-6">
      <v-row align="center" justify="center"
        ><m-logo large :text="title" :logo="logo" />
      </v-row>
    </div>
    <div>
      <v-container>
        <slot />
      </v-container>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['logo', 'title'],
  }
</script>
