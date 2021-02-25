<template>
	<div>
		<v-row>
			<v-col v-for="item in items" :key="item.id">
				<v-btn block>{{ item.text }}</v-btn>
			</v-col>
		</v-row>
	</div>
</template>

<script>
export default {
	props: {
		placeholder: {
			type: String,
			default: '',
		},
		items: {
			type: Array,
			default() {
				return []
			},
		},
	},

	data() {
		return {
			val: '',
		}
	},
}
</script>
