<template>
	<page-layout>
		<m-table endpoint="surveys" :form="form" :headers="headers" :item-filter="itemFilter"> </m-table>
	</page-layout>
</template>

<script>
import form from '@/helpers/forms/survey'
export default {
	data() {
		return {
			form,
			itemFilter: (item) => {
				if (!item.name) item.name = `Survey ${item.id}`
				return item
			},
			headers: [
				{
					text: 'Name',
					value: 'name',
				},
				{
					text: 'Created',
					value: 'created',
					width: 170,
				},
				{
					text: 'Updated',
					value: 'updated',
					width: 170,
				},
			],
		}
	},
}
</script>
