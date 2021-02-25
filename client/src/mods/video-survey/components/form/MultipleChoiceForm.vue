<template>
	<video-survey-question-layout>
		<v-radio-group>
			<video-survey-list-form v-model="model.items" list-id="2">
				<template v-slot:prepend="{ inEdit }">
					<v-checkbox v-if="model.multiple" :class="inEdit ? 'mt-0' : 'mt-n1'" hide-details />
					<v-radio v-else class="mb-0" />
				</template>

				<v-switch slot="footer-options" v-model="model.multiple" class="mt-0" label="Multi-Select" />
			</video-survey-list-form>
		</v-radio-group>

		<slot slot="delete-btn" name="delete-btn" />
	</video-survey-question-layout>
</template>

<script>
import formMixin from '../../mixins/form'
import itemsEditMixin from '../../mixins/form-items-edit'
export default {
	mixins: [formMixin, itemsEditMixin],
}
</script>
