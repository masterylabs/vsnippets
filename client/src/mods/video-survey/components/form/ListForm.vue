<template>
	<div>
		<drag-sort :value="value" height="37" :disabled="inEdit" @input="onSorted" class="mb-4">
			<template v-slot:item="{ item, index }">
				<v-row align="center" no-gutters class="py-1">
					<v-row no-gutters>
						<slot name="prepend" :item="item" :index="index" :in-edit="inEdit" />
						<div v-if="inEdit && editItem.id == item.id">
							<v-text-field
								v-model="editItem.text"
								hide-details
								class="mt-n3"
								autofocus
								@blur="blur"
								@keyup.enter.native="blur"
							/>
						</div>
						<div v-else class="grey--text text--darken-3" @click="select(item)">
							{{ item.text || emptyTextValue }}
						</div>

						<v-btn icon small class="mb-n1 mt-n2 ml-2" @click="doEdit(item)">
							<v-icon small>mdi-pencil</v-icon>
						</v-btn>
					</v-row>

					<v-row justify="end" no-gutters>
						<video-survey-delete-btn @click="doDelete(item.id)">
							<template slot="before">
								<video-survey-duplicate-btn @click="doDuplicate(item)" />
							</template>
						</video-survey-delete-btn>
					</v-row>
				</v-row>
			</template>
		</drag-sort>

		<v-row no-gutters justify="space-between">
			<slot v-if="!noAddNew" name="add-new">
				<video-survey-add-option-btn @add="addValue" />
			</slot>

			<slot name="footer-options" />
		</v-row>
	</div>
</template>

<script>
const uuidv4 = require('uuid/v4')
export default {
	props: {
		listId: {
			type: String,
			default: 'list_form',
		},
		noAddNew: Boolean,
		value: {
			type: Array,
			default() {
				return []
			},
		},
		duplicateAppendText: {
			type: String,
			default: ' (COPY)',
		},
		emptyTextValue: {
			type: String,
			default: '(EMPTY)',
		},
	},

	data() {
		return {
			editItem: {}, // editing
			selectedItem: {}, // used externally
		}
	},

	computed: {
		inEdit() {
			return this.editItem.id ? true : false
		},
	},

	methods: {
		onSorted(items) {
			this.$emit('input', items)
		},

		addValue(value) {
			const items = [...this.value]
			items.push(value)
			this.$emit('input', items)
		},

		blur() {
			this.editItem = {}
		},
		select(item) {
			this.selectedItem = item
			this.$emit('select', item)
		},
		doEdit(item) {
			if (this.editItem.id && item.id == this.editItem.id) {
				// end end
				this.editItem = {}
				return
			}
			this.editItem = item
		},
		doDelete(id) {
			const items = [...this.value]

			const index = items.findIndex((a) => a.id == id)
			items.splice(index, 1)
			this.$emit('input', items)
		},

		doDuplicate(item) {
			const id = uuidv4()
			const entry = {
				...item,
				id,
			}

			const append = this.duplicateAppendText
			if (append && entry.text && entry.text.indexOf(append) < 0) entry.text += append

			// place below current
			const items = [...this.value]
			const index = items.findIndex((a) => a.id == item.id) + 1
			items.splice(index, 0, entry)

			this.$emit('input', items)
		},
	},
}
</script>
