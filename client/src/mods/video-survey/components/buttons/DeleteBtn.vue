<template>
	<v-row justify="end">
		<slot v-if="!confirm" name="before" />
		<template v-if="confirm">
			<v-btn color="error" dark :loading="loading" @click="click">Delete?</v-btn>
			<v-btn depressed class="ml-1" @click="confirm = false">Cancel</v-btn>
		</template>
		<v-tooltip v-else left :disabled="outlined || confirm">
			<template v-slot:activator="{ on, attrs }">
				<!--  -->
				<v-btn
					v-if="outlined"
					v-bind="attrs"
					v-on="on"
					depressed
					class="grey--text text--darken-1"
					@click="confirm = true"
					><v-icon class="mr-1">mdi-delete</v-icon> Delete
				</v-btn>
				<v-btn v-else v-bind="attrs" v-on="on" icon color="grey" @click="confirm = true"
					><v-icon>mdi-delete</v-icon>
				</v-btn>
			</template>
			<span>Delete</span>
		</v-tooltip>
	</v-row>
</template>

<script>
export default {
	props: {
		outlined: Boolean,
		disabled: Boolean,
		loading: {
			type: Boolean,
			default: null,
		},
	},

	data() {
		return {
			confirm: false,
		}
	},

	methods: {
		click() {
			this.$emit('click')

			// no using loading
			if (this.loading == null) this.confirm = false
		},
	},
}
</script>
