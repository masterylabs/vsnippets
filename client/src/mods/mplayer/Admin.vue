<template>
	<div v-if="ready">
		<slot name="player" :value="val" />
		<v-row>
			<template v-for="field in fields">
				<v-fade-transition :key="field.value">
					<v-col v-if="!field.hide || !field.hide()">
						<v-text-field v-model="val[field.value]" :label="field.text" :placeholder="field.placeholder" />
					</v-col>
				</v-fade-transition>
			</template>
		</v-row>

		<template v-for="color in colors">
			<v-fade-transition :key="color.value">
				<mplayer-color-picker
					v-if="!color.advanced || isAdvanced"
					v-model="val[color.value]"
					:color="color"
					@input="onInput"
				/>
			</v-fade-transition>
		</template>

		<template v-for="option in options">
			<v-fade-transition :key="option.value">
				<v-checkbox
					v-if="!option.advanced || isAdvanced"
					v-model="val[option.value]"
					:label="option.text"
					hide-details
				/>
			</v-fade-transition>
		</template>
		<v-divider class="mt-6" />
		<v-switch label="Show Advanced" v-model="isAdvanced" @change="onAdvanced" />

		<!-- required to track color change  -->
		<span v-if="isChanged" />
	</div>
</template>

<script>
import data from './admin/data'
export default {
	props: {
		advanced: Boolean,
		value: {
			type: Object,
			default() {
				return {}
			},
		},
		noVideo: Boolean,
		noPoster: Boolean,
		noTitle: Boolean,
	},

	data,

	watch: {
		val: {
			handler: function(oldValue, newValue) {
				// tqRfYYLeVK0
				if (this.ready) this.$emit('input', { ...newValue })
			},
			deep: true,
		},
	},

	methods: {
		onAdvanced() {
			this.$emit('advanced', this.isAdvanced)
		},
		onInput() {
			this.isChanged = !this.isChanged
			// colors do not change watcher
			console.log('onInput', this.val.color)
			this.$emit('input', { ...this.val })
		},
	},

	beforeMount() {
		this.val = { ...this.value }

		// setup color pickers
		this.colors.forEach(({ value, defaultValue }) => {
			if (!this.val[value]) this.val[value] = defaultValue
		})

		if (this.advanced) this.isAdvanced = true

		this.ready = true
	},
}
</script>
