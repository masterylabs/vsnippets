export default {
	ready: false,
	create: false,
	edit: false,
	editItem: null,
	loading: true,
	deleting: false,
	refreshing: false,
	searchFocused: false,
	isSelectedDelete: false,
	deletingSelected: false,

	selectingAll: false,

	isQuickSelectAll: false,

	isFilters: false,

	options: {},

	data: null,
	pagin: null,
	selected: [],
	deleteId: null,
	activatingId: null,
	query: {
		q: '',
		page: 1,
		pages: 1,
		limit: 25,
		order: 'desc',
		orderby: 'updated',
	},
	actions: [
		{
			text: 'Delete',
			value: 'delete',
			icon: 'mdi-delete',
			// click: (item) => {
			// 	this.deleteId = item.id
			// },
			selectedClick: () => {
				this.isSelectedDelete = true
			},
		},
		{
			text: 'Edit',
			value: 'edit',
			icon: 'mdi-pencil',
			// click: (item) => {
			// 	console.log('edit', item)
			// },
		},
	],
}
