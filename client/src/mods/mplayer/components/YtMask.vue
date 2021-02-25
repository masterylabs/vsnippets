<template>
	<div class="mplayer-absolute redx" @click="onClick" />
</template>

<script>
export default {
	methods: {
		onClick() {
			this.$emit('click')
		},
	},
}
</script>
