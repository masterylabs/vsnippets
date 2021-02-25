<template>
	<page-layout>
		Survey
		<video-survey-builder v-model="survey" />

		<dev-raw class="mt-12" :value="survey" title="Survey" />
	</page-layout>
</template>

<script>
export default {
	data() {
		return {
			survey: {},
		}
	},
	computed: {
		endpoint() {
			return `surveys/${this.$route.params.id}`
		},
	},
}
</script>
