<template>
	<v-container fill-height>
		<v-row align="center" justify="center">
			<v-progress-circular indeterminate size="190" width="2" color="primary">
				<v-img v-if="brandLogo" :src="brandLogo" max-width="150" max-height="150" />
			</v-progress-circular>
		</v-row>
	</v-container>
</template>

<script>
import brandMixin from '../mixins/brand'
export default {
	mixins: [brandMixin],
}
</script>
