<template>
	<v-img class="mplayer-absolute mplayer-poster" :src="src"></v-img>
</template>

<script>
export default {
	props: {
		src: {
			type: String,
			default: '',
		},
	},
}
</script>
