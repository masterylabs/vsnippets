<template>
	<v-btn icon dark @click="click">
		<v-icon size="28">mdi-closed-caption</v-icon>
	</v-btn>
</template>

<script>
export default {
	props: {
		active: Boolean,
	},
	methods: {
		click() {
			this.$emit('click')
		},
	},
}
</script>
