<template>
	<app-layout :ready="app.ready">
		<view-app-no-auth v-if="app.noAuth" />
		<view-loading v-else-if="!app.ready" />
		<view-upgrade v-else-if="app.expired" />
		<view-welcome v-else-if="!app.license" />
		<router-view v-else />
	</app-layout>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
export default {
	computed: {
		...mapState({
			app: 'app',
		}),
		...mapGetters({
			hasAddon: 'app/hasAddon',
			isBrandClient: 'app/isBrandClient',
		}),
		canUse() {
			return this.app.ready && this.app.license && !this.app.expired && !this.isBrandClient
		},
		showToolbar() {
			return this.app.ready
		},
	},

	beforeMount() {
		if (this.$app.config.color) this.$vuetify.theme.themes.light.primary = this.$app.config.color
		this.$app.start()
	},
}
</script>

<style lang="scss">
@import './scss/app.scss';
@import './scss/wp-admin.scss';
</style>
