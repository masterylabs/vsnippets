<template>
	<div>
		<v-tooltip left>
			<template v-slot:activator="{ on, attrs }">
				<v-btn v-bind="attrs" v-on="on" icon color="grey" @click="click"
					><v-icon>mdi-content-copy</v-icon>
				</v-btn>
			</template>
			<span>Duplicate</span>
		</v-tooltip>
	</div>
</template>

<script>
export default {
	props: {
		disabled: Boolean,
		loading: {
			type: Boolean,
			default: null,
		},
	},

	methods: {
		click() {
			this.$emit('click')
		},
	},
}
</script>
