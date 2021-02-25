<template>
	<div>
		<v-switch
			v-if="toggle"
			:label="label"
			class="mt-0 mb-1 pt-0"
			:true-value="trueValue"
			:false-value="falseValue"
			hide-details
		></v-switch>
		<v-checkbox
			v-else
			:label="label"
			class="mt-0 mb-1 pt-0"
			:true-value="trueValue"
			:false-value="falseValue"
			hide-details
		/>
	</div>
</template>

<script>
export default {
	props: {
		toggle: Boolean,
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
		trueValue: {
			type: [Boolean, Number, String],
			default: true,
		},
		falseValue: {
			type: [Boolean, Number, String],
			default: false,
		},
	},
}
</script>
