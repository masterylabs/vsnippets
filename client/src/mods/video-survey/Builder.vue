<template>
	<div>
		<mplayer v-bind="video">
			<template v-slot:below="{ duration, currentTime }">
				<v-tabs v-model="tabs" grow>
					<v-tab>Video Setup</v-tab>
					<v-tab>Questions</v-tab>
					<v-tab>Survey Options</v-tab>

					<v-tab-item>
						<mplayer-admin v-model="video" :duration="duration" @input="onVideo" />
					</v-tab-item>
					<v-tab-item>
						<video-survey-questions v-model="questions" :current-time="currentTime" :duration="duration" />
					</v-tab-item>
					<v-tab-item>
						survey options
					</v-tab-item>
				</v-tabs>
			</template>
		</mplayer>

		<v-dialog v-model="editQuestionDialog" width="700">
			<div style="position:relative">
				<v-card v-if="question" class="py-12 px-8">
					<component
						v-if="editQuestionDialog"
						v-model="question"
						:is="`video-survey-${question.field_type}-form`"
					/>
				</v-card>
				<m-close-dialog-btn @click="editQuestionDialog = false" />
			</div>
		</v-dialog>

		<!-- <dev-raw :value="questions" title="questions" /> -->

		<v-row class="mt-12 grey lighten-3">
			<v-col>
				<dev-raw :value="video" title="video" />
			</v-col>
			<v-col>
				<dev-raw :value="questions" />
			</v-col>
		</v-row>
	</div>
</template>

<script>
const uuidv4 = require('uuid/v4')
import questionTemplates from './helpers/question-templates'
import sampleData from './helpers/sample-data'

export default {
	data() {
		return {
			editQuestionDialog: false,
			closeAddQuestion: false,
			tabs: 0, //1,
			video: {},
			question: null, //
			questions: [], // [...sampleData.questions],
		}
	},

	methods: {
		onVideo(video) {
			console.log('onVideo', video)
		},
		addQuestion(field_type) {
			this.closeAddQuestion = !this.closeAddQuestion

			const question = {
				id: uuidv4(),
				...questionTemplates[field_type],
			}

			// if (question.items)
			// 	question.items = question.items.map((item) => {
			// 		console.log('item', item)
			// 	})

			// if (question.items) {
			// 	question.items = question.items.map((text) => {
			// 		if (typeof text == 'string') {
			// 			return {
			// 				text,
			// 				id: uuidv4(),
			// 			}
			// 		}

			// 		// if text is an object
			// 		return {
			// 			...text,
			// 			id: uuidv4(),
			// 		}
			// 	})
			// }

			this.question = question

			this.editQuestionDialog = true
		},
	},

	mounted() {
		this.questions = [...sampleData.questions]
		// TEST
		// this.addQuestion('textarea')
		// this.addQuestion('textfield')
		// this.addQuestion('ab')
		// this.addQuestion('multiple-choice-multi')
		// this.addQuestion('checkbox')
		// this.addQuestion('switch')
	},
}
</script>
