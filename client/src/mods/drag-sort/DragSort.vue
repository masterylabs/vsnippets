<template>
	<div>
		<div v-for="(item, index) in value" :key="`${listId}${index}`">
			<v-expand-transition>
				<div
					class="ml-drag-sort-placement"
					:class="placementClass"
					:style="`height:${drag.over == index && drag.index > drag.over ? height : 0}px`"
				></div>
			</v-expand-transition>

			<div
				:class="itemClass"
				:draggable="!disabled"
				@dragstart="drag.index = index"
				@dragenter="dragenter(index)"
				@dragend="dragend"
			>
				<slot name="item" :item="item" :index="index" />
			</div>
			<v-expand-transition>
				<div
					class="ml-drag-sort-placement"
					:class="placementClass"
					:style="`height:${drag.over == index && drag.index < drag.over ? height : 0}px`"
				></div>
			</v-expand-transition>
		</div>
	</div>
</template>

<script>
const arrayMove = require('array-move')
export default {
	props: {
		listId: {
			type: String,
			default: 'list_form',
		},
		disabled: Boolean,
		height: {
			type: [String, Number],
			default: 50,
		},
		value: {
			type: Array,
			default() {
				return []
			},
		},
		placementClass: {
			type: String,
			default: 'success lighten-4',
		},
		itemClass: {
			type: String,
			default: '', // pa-4 my-3 elevation-2
		},
	},

	data() {
		return {
			drag: {
				index: -1,
				over: -1,
			},
		}
	},
	methods: {
		dragstart(index) {
			this.drag.index = index
		},

		dragenter(index) {
			if (index == this.drag.index) return
			this.drag.over = index
		},
		dragend() {
			const from = this.drag.index
			const to = this.drag.over

			const value = arrayMove(this.value, from, to)

			this.$emit('input', value)
			this.drag.index = -1
			this.drag.over = -1
		},
	},
}
</script>

<style scoped>
.ml-drag-sort-placement {
	transition: height 0.2s ease-in-out;
}
</style>
