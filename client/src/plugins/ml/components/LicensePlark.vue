<template>
	<div>
		<v-card elevation="0" tile class="pb-4">
			<v-card-text class="text-center black white--text">
				<div class="caption text-uppercase mt-n1">Your license</div>
				<div class="title">
					{{ name }}
				</div>
			</v-card-text>
			<v-card-text class="text-center">
				<div class="caption text-uppercase">
					Holder
				</div>
				<div class="body-1 mb-4">{{ lic.contact.first_name }} {{ lic.contact.last_name }}</div>

				<div v-if="lic.is_trial" class="title text-uppercase">
					<div class="caption text-uppercase">Trial</div>
					<div class="mb-4" :class="`${lic.expires_in < 86400 ? 'error' : 'primary'}--text`">
						{{ lic.expires_in | timeRemaining }}
					</div>
					<ml-upgrade-btn v-if="lic.can_upgrade" />
				</div>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
	computed: {
		...mapGetters({
			lic: 'app/license',
		}),
		name() {
			return this.lic.name
				? this.lic.name
				: this.lic.product && this.lic.product.name
				? this.lic.product.name
				: ''
		},
	},

	filters: {
		timeRemaining(t) {
			if (t > 86400) return `${Math.floor(t / 86400)} Days`

			if (t > 3600) return `${Math.floor(t / 3600)} Hours`

			if (t > 60) return `${Math.floor(t / 60)} Minutes`

			if (t > 0) return `${Math.floor(t / 60)} Seconds`

			return 'Expired'
		},
	},
}
</script>
