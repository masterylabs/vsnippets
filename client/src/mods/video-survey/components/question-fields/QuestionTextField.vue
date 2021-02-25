<template>
	<v-text-field
		v-model="model"
		label="Your Question"
		placeholder="Type in your question here..."
		outlined
		:autofocus="autofocus"
		@input="input"
	/>
</template>

<script>
export default {
	props: {
		value: {
			type: String,
			default: '',
		},
	},

	watch: {
		value() {
			if (this.value != this.model) this.model = this.value
		},
	},

	data() {
		return {
			autofocus: false,
			model: '',
		}
	},

	methods: {
		input() {
			this.$emit('input', this.model)
		},
	},

	beforeMount() {
		if (this.value) this.model = this.value
		this.autofocus = !this.value ? true : false
	},
}
</script>
