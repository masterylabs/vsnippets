<template>
	<div>
		<v-row no-gutters align="center" justify="start" class="ml-2">
			<v-checkbox v-if="!model.toggle" class="mt-0" hide-details />
			<v-switch v-else class="mt-0" hide-details />

			<div>
				<v-text-field v-model="model.label" hide-details class="mt-n3" autofocus />
			</div>
		</v-row>

		<v-row align="center" justify="end" no-gutters>
			<v-switch v-model="model.toggle" class="mt-0" label="Switch" />
		</v-row>
	</div>
</template>

<script>
import formMixin from '../../mixins/form'
export default {
	mixins: [formMixin],
}
</script>
