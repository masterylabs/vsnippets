<template>
	<div class="px-4 py-4">
		<v-row align="center" justify="center">
			<div class="title grey--text">What Type of Question?</div>
		</v-row>
		<v-row>
			<v-col v-for="item in questions" :key="item.value" cols="4">
				<v-hover v-slot="{ hover }">
					<v-card height="200" :elevation="hover ? 12 : 0" @click="add(item.value)">
						<v-container fill-height>
							<v-row align="center" justify="center">
								<div class="text-center">
									<v-icon size="50" color="primary">mdi-{{ item.icon }}</v-icon>
									<div class="body-1 mt-2">{{ item.text }}</div>
								</div>
							</v-row>
						</v-container>
					</v-card>
				</v-hover>
			</v-col>
		</v-row>
	</div>
</template>

<script>
export default {
	data() {
		return {
			questions: [
				{
					text: 'Single Choice',
					value: 'multiple-choice',
					icon: 'order-bool-descending',
				},
				{
					text: 'Multi Choice',
					value: 'multiple-choice-multi',
					icon: 'checkbox-multiple-marked-outline',
				},
				{
					text: 'This or That',
					value: 'ab',
					icon: 'ab-testing',
				},
				{
					text: 'Short Text',
					value: 'textfield',
					icon: 'text-short',
				},
				{
					text: 'Long Text',
					value: 'textarea',
					icon: 'text',
				},
				{
					title: 'Checkbox',
					text: 'Checkbox',
					value: 'checkbox',
					icon: 'check-box-outline',
				},
			],
		}
	},

	methods: {
		add(value) {
			this.$emit('add', value)
		},
	},
}
</script>
