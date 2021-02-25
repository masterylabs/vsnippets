<template>
	<v-row no-gutters align="center" justify="end">
		<!-- <v-btn v-for="item in items" :key="item.value">
			<v-icon>mdi-{{ item.icon }}</v-icon> {{ item.text }}
		</v-btn> -->

		<div v-if="isDelete">
			<v-btn small color="error" class="mr-1" @click="onDelete">Delete?</v-btn>
			<v-btn depressed small @click="isDelete = false">Cancel</v-btn>
		</div>

		<template v-else>
			<v-tooltip v-for="item in items" :key="item.value" bottom>
				<template v-slot:activator="{ on, attrs }">
					<v-btn
						icon
						small
						color="primary"
						:disabled="item.disabled"
						v-bind="attrs"
						v-on="on"
						@click="click(item.value)"
					>
						<v-icon v-text="`mdi-${item.icon}`" />
					</v-btn>
				</template>
				<span>{{ item.text }}</span>
			</v-tooltip>
		</template>
	</v-row>
</template>

<script>
export default {
	props: {
		isFirst: Boolean,
		isLast: Boolean,
	},
	data() {
		return {
			isDelete: false,
			items: [
				{
					text: 'Move Up',
					icon: 'arrow-up',
					value: 'up',
					disabled: this.isFirst,
				},
				{
					text: 'Move Down',
					icon: 'arrow-down',
					value: 'down',
					disabled: this.isLast,
				},
				{
					text: 'Edit',
					icon: 'pencil',
					value: 'edit',
				},
				{
					text: 'Duplicate',
					icon: 'content-copy',
					value: 'duplicate',
				},
				{
					text: 'Delete',
					icon: 'delete',
					value: 'delete',
				},
			],
		}
	},

	methods: {
		click(value) {
			if (value == 'delete') return (this.isDelete = true)
			this.$emit(value)
		},
		onDelete() {
			this.$emit('delete')
			this.isDelete = false
		},
	},
}
</script>
