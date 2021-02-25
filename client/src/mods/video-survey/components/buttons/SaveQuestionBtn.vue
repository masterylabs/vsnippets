<template>
	<v-btn color="primary" :disabled="disabled" :loading="loading">{{ isCreate ? 'Add' : 'Update' }}</v-btn>
</template>

<script>
export default {
	props: {
		isCreate: Boolean,
		disabled: Boolean,
		loading: Boolean,
	},
}
</script>
