<template>
	<div class="orange mb-3">
		<v-text-field
			:value="value.content"
			:autofocus="!value.content"
			class="title"
			label="Your Question"
			@input="onContent"
		/>
		QUESTION FORM
	</div>
</template>

<script>
export default {
	props: {
		value: {
			type: Object,
			default() {
				return {}
			},
		},
	},

	data() {
		return {
			model: {},
		}
	},

	beforeMount() {
		this.model = this.value
	},

	methods: {
		onContent(content) {
			const item = { ...this.value, content }
			this.$emit('input', item)
		},
	},
}
</script>
