<template>
	<div>
		<v-btn width="200" depressed class="mb-4" @click="dialog = true">
			<v-row no-gutters align="center" justify="space-between">
				<div>
					{{ color.text }}
				</div>

				<v-icon :color="val" class="mr-n2">mdi-checkbox-blank-circle</v-icon>
			</v-row>
		</v-btn>
		{{ val }}
		<!-- <v-btn width="200" depressed class="mb-4" @click="dialog = true">
			<v-icon :color="val" class="mr-1">mdi-checkbox-blank-circle</v-icon> {{ color.text }}
		</v-btn> -->
		<v-dialog v-model="dialog" width="300">
			<v-card width="300">
				<v-toolbar dark dense flat tile>
					<v-toolbar-title v-text="color.text" />
					<v-spacer />
					<v-btn icon @click="onInput(color.defaultValue)">
						<v-icon>mdi-refresh</v-icon>
					</v-btn>
					<v-btn icon @click="dialog = false">
						<v-icon>mdi-close</v-icon>
					</v-btn>
				</v-toolbar>
				<v-color-picker v-model="val" @input="onInput" />
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
export default {
	props: {
		value: {
			type: String,
			default: '',
		},
		color: {
			type: Object,
			default() {
				return {}
			},
		},
	},

	data() {
		return {
			dialog: false,
			val: '',
		}
	},

	beforeMount() {
		this.val = this.value
	},

	methods: {
		onInput(value) {
			this.$emit('input', value)
		},
	},
}
</script>
