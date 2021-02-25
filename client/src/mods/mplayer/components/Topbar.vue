<template>
	<div v-if="hasValue" class="mplayer-topbar">
		<v-row justify="space-between" align="center" class="pa-3 rounded" no-gutters style="height:64px">
			<v-row
				no-gutters
				align="center"
				:justify="blockTitle ? 'center' : 'start'"
				:class="blockTitle ? 'py-1' : ''"
				:style="blockTitle ? `background:${color}` : ''"
			>
				<mplayer-avatar v-if="avatar" slot="avatar" :src="avatar" :href="avatarHref" class="mr-1 mb-3" />
				<div
					v-if="title && !noTitle"
					class="mplayer-title mt-1"
					:class="[!avatar ? 'ml-11' : '', blockTitle ? 'title' : '']"
				>
					<div
						style="display: inline-block"
						v-for="(word, index) in titleWords"
						:key="`titleword${index}`"
						:style="`background:${color}; color:${textColor}`"
						class="ont-weight-medium pr-1 mb-1"
						:class="index < 1 ? 'pl-1' : ''"
						v-text="word"
					/>
				</div>
			</v-row>
			<div v-if="useShare">
				<mplayer-share-btn @click="onShare" />
			</div>
		</v-row>
	</div>
</template>

<script>
export default {
	props: {
		useShare: Boolean,
		noTitle: Boolean,
		title: {
			type: String,
			default: '',
		},
		avatar: {
			type: String,
			default: '',
		},
		avatarHref: {
			type: String,
			default: '',
		},
		color: {
			type: String,
			default: '',
		},
		textColor: {
			type: String,
			default: '',
		},
	},

	data() {
		return {
			blockTitle: false,
		}
	},

	computed: {
		titleWords() {
			return this.title.split(' ')
		},
		hasValue() {
			return this.title || this.useShare || this.avatar ? true : false
		},
	},
	methods: {
		onShare() {
			this.$emit('share')
		},
	},
}
</script>
