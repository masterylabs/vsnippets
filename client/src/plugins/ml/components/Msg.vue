<template>
	<div class="text-center ma-2">
		<v-snackbar v-model="open" :color="message.color" :timeout="6000">
			{{ message.text }}
			<template v-slot:action="{ attrs }">
				<v-btn text v-bind="attrs" @click="close">
					Close
				</v-btn>
			</template>
		</v-snackbar>
	</div>
</template>

<script>
export default {
	computed: {
		message() {
			return this.$store.state.msg.message
		},
		open: {
			get() {
				return this.$store.state.msg.open
			},
			set() {
				this.$store.commit('msg/CLOSE')
			},
		},
	},
	methods: {
		close() {
			this.$store.commit('msg/CLOSE')
		},
	},
}
</script>
