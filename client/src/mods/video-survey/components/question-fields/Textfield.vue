<template>
	<div>
		<v-text-field :label="label" :hint="hint" :placeholder="placeholder" :outlined="outlined" hide-details>
		</v-text-field>
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
