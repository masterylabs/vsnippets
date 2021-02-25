<template>
	<div>
		<v-expand-transition>
			<div v-if="isAdd">
				<v-text-field
					v-for="(option, index) in options"
					:key="`addnew${index}`"
					v-model="options[index].text"
					:autofocus="autofocus || true"
					label="Add Option"
					append-outer-icon="mdi-close"
					@click:append-outer="removeNew(index)"
					@keyup.enter.native="onEnter(index)"
				/>
			</div>
		</v-expand-transition>
		<v-btn :color="hasValue ? 'primary' : ''" :depressed="!hasValue" @click="addOption">
			<v-icon>mdi-plus</v-icon>
			Add
		</v-btn>
	</div>
</template>

<script>
const uuidv4 = require('uuid/v4')
export default {
	data() {
		return {
			isAdd: false,
			autofocus: true,
			options: [],
		}
	},

	computed: {
		hasValue() {
			return this.options.find((a) => a.text != '')
			// return this.options.find((a) => a != '')
		},
	},

	methods: {
		removeNew(index) {
			this.options.splice(index, 1)
		},

		onEnter(index) {
			this.addOption()
		},
		addOption() {
			if (this.hasValue) {
				const items = [...this.options]
				items.forEach((item) => {
					if (item.text != '') {
						this.$emit('add', item)
						const index = this.options.findIndex((a) => a.value == item.value)
						this.options.splice(index, 1)
					}
				})
			}

			const entry = {
				id: uuidv4(),
				text: '',
			}
			this.options.push(entry)
			this.isAdd = false
			setTimeout(() => {
				this.isAdd = true
			})
		},
	},
}
</script>
