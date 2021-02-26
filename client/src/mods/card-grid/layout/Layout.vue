<template>
  <v-container class="pa-0x" fill-heightx>
    <slot name="toolbar" />

    <div class="py-12">
      <slot />
    </div>

    <slot name="pagin" />
  </v-container>
</template>
