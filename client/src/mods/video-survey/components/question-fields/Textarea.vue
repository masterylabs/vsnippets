<template>
	<div>
		<v-textarea :label="label" :hint="hint" :placeholder="placeholder" :outlined="outlined" hide-details>
		</v-textarea>
	</div>
</template>

<script>
export default {
	props: {
		outlined: Boolean,
		label: {
			type: String,
			default: '',
		},
		placeholder: {
			type: String,
			default: '',
		},
		hint: {
			type: String,
			default: '',
		},
	},
}
</script>
