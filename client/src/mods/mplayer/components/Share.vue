<template>
	<!-- <div> -->

	<div class="mplayer-share">
		<v-row align="center" justify="center">
			<v-btn
				v-for="share in shares"
				:key="share.value"
				:color="share.color"
				class="mx-1"
				dark
				@click="select(share)"
			>
				<v-icon class="mr-1">{{ share.icon }}</v-icon> {{ share.text }}
			</v-btn>
		</v-row>
		<slot />
	</div>
</template>

<script>
export default {
	props: {
		show: Boolean,
	},

	data() {
		return {
			url: '',
			shares: [
				{
					text: 'Facebook',
					value: 'facebook',
					color: '#3B5998',
					icon: 'mdi-facebook',
					url: 'https://www.facebook.com/sharer/sharer.php?u=',
				},
				{
					text: 'Twitter',
					value: 'twitter',
					color: '#2DA1F2',
					icon: 'mdi-twitter',
					url: 'https://twitter.com/intent/tweet?url=',
				},
				{
					text: 'LinkedIn',
					value: 'linkedin',
					color: '#1F77B5',
					icon: 'mdi-linkedin',
					url: 'https://www.linkedin.com/shareArticle/?url=',
				},
			],
		}
	},

	methods: {
		onClose() {
			this.$emit('close')
		},
		select(share) {
			const url = share.url + encodeURIComponent(this.url)

			window.open(
				url,
				share.text,
				`toolbar=no,location=no,
                                    status=no,
                                    menubar=no,
                                    scrollbars=yes,
                                    resizable=yes,
                                    width=640,
                                    height=460`
			)
		},
	},

	beforeMount() {
		this.url = window.parent.location.href
	},
}
</script>
