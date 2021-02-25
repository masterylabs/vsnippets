<template>
	<v-btn icon dark :color="color" @click="click">
		<v-icon size="28">mdi-fullscreen{{ active ? '-exit' : '' }}</v-icon>
	</v-btn>
</template>

<script>
export default {
	props: {
		active: Boolean,
		color: {
			type: String,
			default: '',
		},
	},

	methods: {
		click() {
			this.$emit('click')
		},
	},
}
</script>
