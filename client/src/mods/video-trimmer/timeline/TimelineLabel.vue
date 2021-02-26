<template>
  <div
    class="video-trimmer-timeline-handle-label primary mt-n2 py-1 rounded-lg"
    :class="`m${right ? 'r' : 'l'}-n12`"
  >
    <slot />
  </div>
</template>

<script>
  export default {
    props: {
      right: Boolean,
    },
  }
</script>
