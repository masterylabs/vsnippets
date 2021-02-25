<template>
	<v-hover v-slot="{ hover }">
		<div ref="container">
			<v-card
				:icon="icon"
				:tile="tile"
				:depressed="depressed"
				:height="height"
				:color="color"
				:dark="dark"
				:width="width"
				@click="click"
				@mousemove="onMousemove"
				@mousedown="onMousedown"
			>
				<div
					v-if="volume < 1"
					class="video-player-volume-layer"
					:style="`opacity:0.3;width:${volume * 100}%;background:${iconColor}`"
				/>
				<div
					v-if="volume < 1 && hover"
					class="video-player-volume-layer"
					:style="`width:${volume * 100}%;border-right: solid 1px ${iconColor}`"
				/>
				<v-row no-gutters align="center" justify="center" style="height:100%;pointer-events:none">
					<v-expand-transition>
						<div
							v-if="hover"
							class="title ml-unselectable"
							:style="{ color: iconColor }"
							v-text="volumeText"
						/>
					</v-expand-transition>
					<v-expand-transition>
						<v-icon
							v-if="!hover"
							:color="iconColor"
							:size="size"
							v-text="`mdi-volume-${iconLevel}`"
						></v-icon>
					</v-expand-transition>
				</v-row>
			</v-card>
		</div>
	</v-hover>
</template>

<script>
import buttonMixin from '../mixins/buttons'
export default {
	props: {
		isMuted: Boolean,
		volume: {
			type: Number,
			default: 1,
		},
	},

	mixins: [buttonMixin],
	data() {
		return {
			isDrag: false,
			dragWait: null,
			waitDown: null,
			startVol: 0,
		}
	},
	computed: {
		iconLevel() {
			if (this.isMuted) return 'off'

			return this.volume > 0.7 ? 'high' : this.volume > 0.3 ? 'medium' : 'low'
		},
		volumeText() {
			return Math.floor(this.volume * 100)
		},
	},
	methods: {
		click() {
			// if not changed then emit toggle volume
			if (this.startVol == this.volume) this.$emit('toggle-mute')
		},
		onMouseup() {
			clearTimeout(this.waitDown)
			this.isDrag = false
		},

		onMousemove({ offsetX }) {
			this.previewLeft = offsetX || 0

			if (this.isDrag) {
				clearTimeout(this.dragWait)
				this.dragWait = setTimeout(() => {
					this.setLevel({ offsetX })
				}, 10)
			}
		},
		onMousedown() {
			this.startVol = this.volume
			this.waitDown = setTimeout(() => {
				this.isDrag = true
			}, 300)
		},

		setLevel({ offsetX }) {
			let value = offsetX / this.$refs.container.clientWidth
			if (value < 0.1) value = 0
			else if (value > 0.9) value = 1

			this.$emit('volume', value)
		},
	},

	beforeDestroy() {
		document.removeEventListener('mouseup', this.onMouseup)
	},

	mounted() {
		document.addEventListener('mouseup', this.onMouseup)
	},
}
</script>

<style scoped>
.video-player-volume-layer {
	position: absolute;
	left: 0;
	top: 0;
	height: 100%;
	pointer-events: none;
}
</style>
