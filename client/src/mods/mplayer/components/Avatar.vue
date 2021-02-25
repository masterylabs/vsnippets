<template>
	<v-avatar size="44" :tile="tile">
		<a v-if="href" :href="href" target="_blank">
			<v-img :width="width" :height="height" :src="src" />
		</a>
		<v-img v-else :src="src" />
	</v-avatar>
</template>

<script>
export default {
	props: {
		tile: Boolean,
		width: {
			type: [String, Number],
			default: null,
		},
		height: {
			type: [String, Number],
			default: null,
		},
		src: {
			type: String,
			default: '',
		},
		href: {
			type: String,
			default: '',
		},
	},
}
</script>
