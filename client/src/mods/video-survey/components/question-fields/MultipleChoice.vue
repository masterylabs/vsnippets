<template>
	<div>
		<template v-if="multiple">
			<div v-for="item in items" :key="item.id">
				<v-checkbox :label="item.text" :value="item.id" hide-details class="mt-0 mb-1" />
			</div>
		</template>
		<v-radio-group v-else v-model="val" class="mt-0" hide-details>
			<v-radio
				v-for="item in items"
				:key="item.id"
				:label="item.text"
				:value="item.id"
				class="mt-0 mb-1"
			></v-radio>
		</v-radio-group>
	</div>
</template>

<script>
export default {
	props: {
		multiple: Boolean,
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
		defaultValue: {
			type: Array,
			default() {
				return []
			},
		},
	},

	data() {
		return {
			val: '',
			multiVal: [],
		}
	},
}
</script>
