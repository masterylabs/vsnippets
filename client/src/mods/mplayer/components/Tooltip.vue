<template>
	<div
		class="mplayer-tooltip-container"
		:class="[isProgress ? 'mplayer-tooltip-progress' : '', easing ? 'mplayer-tooltip-easing' : '']"
		:style="`left:${left}%`"
	>
		<div class="mplayer-tooltip text-center" :class="inverse ? 'mplayer-tooltip-inverse' : ''">
			<template v-if="noFormat">{{ value }}</template>
			<template v-else>{{ value | pretty }}</template>
		</div>
	</div>
</template>

<script>
import { prettyTime } from '../js/helpers'
export default {
	props: {
		isProgress: Boolean,
		inverse: Boolean,
		noFormat: Boolean,
		easing: Boolean,
		left: {
			type: Number,
			default: 0,
		},
		value: {
			type: Number,
			default: 0,
		},
	},
	filters: {
		pretty(t) {
			return prettyTime(t)
		},
	},
}
</script>
