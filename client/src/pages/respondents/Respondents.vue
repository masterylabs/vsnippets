<template>
	<page-layout>
		<m-table endpoint="contacts" :form="form" :headers="headers" :item-filter="itemFilter"> </m-table>
	</page-layout>
</template>

<script>
import form from '@/helpers/forms/respondent'
export default {
	data() {
		return {
			form,
			itemFilter: (item) => {
				if (!item.name) {
					let name = item.first_name ? item.first_name : ''
					if (item.last_name) name += ` ${item.last_name}`
					if (!name) name = `Respondent ${item.id}`
					item.name = name
				}
				return item
			},
			headers: [
				{
					text: 'Name',
					value: 'name',
				},
				{
					text: 'Email',
					value: 'email',
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
