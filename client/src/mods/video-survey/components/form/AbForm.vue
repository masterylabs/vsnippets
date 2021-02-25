<template>
	<div>
		<div class="ml-2 mt-n2 mb-4">
			<video-survey-list-form v-model="model.items" />
		</div>
	</div>
</template>

<script>
import formMixin from '../../mixins/form'
export default {
	mixins: [formMixin],
	data() {
		return {}
	},

	methods: {},
}
</script>
