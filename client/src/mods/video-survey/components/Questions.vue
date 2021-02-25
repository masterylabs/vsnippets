<template>
	<div class="pt-4">
		<div v-for="(question, index) in value" :key="question.id" class="pb-4">
			<v-hover v-slot="{ hover }">
				<div>
					<v-row align="center" justify="space-between" no-gutters>
						<video-survey-question-title :class="hover ? 'primary--textx' : ''">
							{{ question.content }}
						</video-survey-question-title>

						<v-fade-transition>
							<video-survey-question-toolbar
								v-show="hover"
								:is-first="index == 0"
								:is-last="index + 1 == value.length"
								@down="moveDown(index)"
								@up="moveUp(index)"
								@edit="editItem(index)"
								@duplicate="duplicateItem(index)"
								@delete="deleteItem(index)"
							/>
						</v-fade-transition>
					</v-row>
					<v-fade-transition>
						<component :is="`video-survey-${question.field_type}`" v-bind="question.options" />
					</v-fade-transition>
				</div>
			</v-hover>
		</div>

		<v-btn outlined color="primary" @click="isAdd = true">
			<v-icon class="mr-1">mdi-plus</v-icon>
			Add Question
		</v-btn>

		<!-- Add Question  -->
		<v-dialog v-model="isAdd" width="700">
			<div style="position:relative">
				<v-card class="py-12 px-8">
					<video-survey-add-question @add="addQuestion" />
				</v-card>
				<m-close-dialog-btn @click="isAdd = false" />
			</div>
		</v-dialog>

		<!-- Edit Question  -->
		<v-dialog v-model="isEdit" width="700" persistentx>
			<div style="position:relative">
				<v-card v-if="isEdit" class="py-12 px-8">
					<v-text-field label="Question" v-model="item.content" class="title" />
					<component v-model="item.options" :is="`video-survey-${item.field_type}-form`" />
					<v-switch v-model="item.is_scheduled" label="Sync question to video"></v-switch>
					<v-expand-transition>
						<div v-if="item.is_scheduled" class="pr-3">
							<video-survey-time-slider v-model="item.show_time" :duration="duration" class="my-4" />
							<video-survey-time-slider
								v-model="item.pause_time"
								:duration="duration"
								:min="item.show_time"
								label="Pause Time"
							/>
						</div>
					</v-expand-transition>
				</v-card>
				<m-close-dialog-btn @click="isEdit = false" />
			</div>
		</v-dialog>
	</div>
</template>

<script>
const uuidv4 = require('uuid/v4')
const arrayMove = require('array-move')
import questionTemplates from '../helpers/question-templates'

export default {
	props: {
		duration: {
			type: [Number, String],
			default: 600,
		},
		value: {
			type: Array,
			default() {
				return []
			},
		},
	},

	data() {
		return {
			isAdd: false,
			isEdit: false,
			item: {},
			editIndex: -1,
		}
	},

	methods: {
		duplicateItem(index) {
			const item = { ...this.value[index] }
			item.id = uuidv4()
			const append = ' (COPY)'
			if (item.content && item.content.indexOf(append) < 0) item.content += append

			if (item.options && item.options.items) {
				item.options.items = item.options.items.map((a) => {
					return {
						...a,
						id: uuidv4(),
					}
				})
			}

			const items = [...this.value]
			items.splice(index + 1, 0, item)
			this.$emit('input', items)

			console.log(items.length)
		},

		moveUp(index) {
			this.move(index, index - 1)
		},
		moveDown(index) {
			this.move(index, index + 1)
		},
		move(from, to) {
			this.$emit('input', arrayMove(this.value, from, to))
		},
		editItem(index) {
			this.editIndex = index
			this.item = this.value[index] // { ...this.value[index] }
			this.isEdit = true
		},

		deleteEditItem() {
			const index = this.value.findIndex((a) => a.id == this.item.id)
			this.deleteItem(index)
			this.item = {}
			this.isEdit = false
		},

		deleteItem(index) {
			const items = [...this.value]
			items.splice(index, 1)
			this.$emit('input', items)
		},

		addQuestion(field_type) {
			this.isAdd = false

			const item = {
				id: uuidv4(),
				...questionTemplates[field_type],
				show_time: 0,
				pause_time: 0,
				is_scheduled: false,
			}

			// requires new id
			if (item.options && item.options.items)
				item.options.items = item.options.items.map((item) => {
					return {
						...item,
						id: uuidv4(),
					}
				})

			// add to page
			const items = [...this.value]

			items.push(item)

			this.$emit('input', items)

			this.item = item

			this.isEdit = true
		},
	},
}
</script>
