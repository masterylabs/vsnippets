<template>
	<div class="text-center">
		<!-- Tooltip Fab button  -->
		<v-tooltip v-if="fab" :bottom="top" :top="!top">
			<template v-slot:activator="{ on, attrs }">
				<v-btn
					color="primary"
					:fab="fab"
					large
					:absolute="absolute"
					:fixed="fixed"
					:right="right"
					:top="top"
					:bottom="bottom"
					v-bind="attrs"
					v-on="on"
					:class="fab && top ? 'mt-11' : fab && bottom ? 'mb-5' : ''"
					@click="dialog = true"
				>
					<v-icon large>mdi-license</v-icon>
				</v-btn>
			</template>
			<span>License</span>
		</v-tooltip>

		<v-dialog v-model="dialog" width="500">
			<template v-if="!fab" v-slot:activator="{ on, attrs }">
				<v-btn
					color="primary"
					:icon="!fab && !over && !dialog"
					:fab="fab"
					:outlined="over || dialog"
					large
					:absolute="absolute"
					:right="right"
					:top="top"
					v-bind="attrs"
					v-on="on"
					@mousemove="enter"
					@mouseleave="leave"
				>
					<v-icon large>mdi-license</v-icon>
					<span v-if="over || dialog" class="ml-1">License</span>
				</v-btn>
			</template>

			<v-card class="pb-3">
				<ml-license-plark />

				<v-divider></v-divider>
				<v-toolbar dense elevation="0" color="grey lighten-4">
					<v-spacer></v-spacer>
					<v-toolbar-title class="body-1">Update Your License</v-toolbar-title>
					<v-spacer></v-spacer>
				</v-toolbar>

				<v-card-text class="pt-4">
					<ml-license-form />
				</v-card-text>

				<v-btn v-if="!lic.is_trial" icon dark absolute right top class="mt-n3 mr-n3" @click="dialog = false">
					<v-icon>
						mdi-close
					</v-icon>
				</v-btn>
			</v-card>
		</v-dialog>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
	props: {
		// tooltipBtn: Boolean,
		tooltip: Boolean,
		absolute: Boolean,
		fixed: Boolean,
		top: Boolean,
		bottom: Boolean,
		right: Boolean,
		fab: Boolean,
	},

	data() {
		return {
			over: false,
			dialog: false,
			wait: null,
		}
	},
	computed: {
		...mapGetters({
			lic: 'app/license',
		}),
	},

	methods: {
		enter() {
			clearTimeout(this.wait)
			this.wait = setTimeout(() => {
				this.over = true
			}, 100)
		},
		leave() {
			clearTimeout(this.wait)
			this.wait = setTimeout(() => {
				this.over = false
			}, 300)
		},
	},
}
</script>
