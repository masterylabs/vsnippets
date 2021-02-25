<template>
	<div>
		<v-text-field v-model="model.placeholder" label="Placeholder text" />
	</div>
</template>

<script>
import formMixin from '../../mixins/form'
export default {
	mixins: [formMixin],
}
</script>
