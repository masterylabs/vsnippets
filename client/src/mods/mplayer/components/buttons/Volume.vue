<template>
	<v-hover v-slot="{ hover }">
		<div>
			<v-row class="mplayer-volume-container" no-gutters align="center" justify="start">
				<v-btn icon dark :color="color">
					<v-icon v-text="`mdi-volume-${muted ? 'off' : 'high'}`" @click="onMute" />
				</v-btn>

				<mplayer-progressbar
					:color="progressColor"
					:value="value"
					:show-preview="hover"
					:width="hover && !muted ? 80 : 1"
					rounded
					@input="onVolume"
				>
					<template v-slot:append="{ previewWidth, isOver, valueWidth }">
						<v-fade-transition>
							<div
								v-if="hover && !muted"
								class="white--text caption ml-1 mr-3"
								v-text="isOver ? previewWidth : valueWidth"
							/>
						</v-fade-transition>
					</template>
				</mplayer-progressbar>
			</v-row>
		</div>
	</v-hover>
</template>

<script>
export default {
	props: {
		muted: Boolean,
		value: {
			type: Number,
			default: 0.8,
		},
		color: {
			type: String,
			default: '',
		},
		progressColor: {
			type: String,
			default: '',
		},
	},

	methods: {
		onMute() {
			this.$emit('mute')
		},
		onVolume(value) {
			this.$emit('input', value)
		},
	},
}
</script>
