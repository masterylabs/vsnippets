<template>
	<v-app>
		<v-app-bar v-if="ready" dense color="white" flat absolute app>
			<v-app-bar-nav-icon @click="drawer = !drawer" />
			<v-icon color="primary">mdi-video</v-icon>
			<v-icon color="primary">mdi-pencil</v-icon>
			<v-toolbar-title class="ml-1 primary--text body-1">WP Video Surveys</v-toolbar-title>
			<v-spacer />
			<!-- <div class="text-caption grey--text pt-2">Discover what your customers are thinking.</div> -->
			<!-- <v-btn icon><v-icon>mdi-cog</v-icon></v-btn> -->
			<wp-fullscreen-btn class="ml-3" />
		</v-app-bar>

		<v-main class="white mt-n1">
			<slot />
		</v-main>

		<v-navigation-drawer v-if="ready" v-model="drawer" app :permanent="drawer" color="#F7F8FA">
			<m-menu />
		</v-navigation-drawer>
		<ml-msg />
	</v-app>
</template>

<script>
export default {
	props: {
		ready: Boolean,
	},
	data() {
		return {
			drawer: true,
		}
	},
}
</script>
