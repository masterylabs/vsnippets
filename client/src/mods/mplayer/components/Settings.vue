<template>
	<v-card width="270" height="175" dark>
		<v-scroll-x-transition>
			<v-list v-if="selectedItem == 'main'" dense>
				<v-list-item-group v-model="selectedItem" color="primary">
					<v-list-item v-for="(item, i) in items" :key="i" @click="selectedItem = item.value">
						<v-list-item-content>
							<!-- <v-container no-gutters> -->
							<v-row no-gutters align="center" justify="space-between" class="caption redx">
								<div v-text="item.text" />

								<div>
									<v-row no-gutters align="center" justify="end" class="mr-n1">
										<v-switch
											v-if="item.value == 'annotations'"
											hide-details
											class="mt-n2 mr-n1"
											:value="true"
											color="youtube"
										/>
										<div v-else v-text="item.statusText" />
										<v-icon size="20">mdi-chevron-right</v-icon>
									</v-row>
								</div>
							</v-row>
							<!-- </v-container> -->
						</v-list-item-content>
					</v-list-item>
				</v-list-item-group>
			</v-list>
		</v-scroll-x-transition>
	</v-card>
</template>
<script>
export default {
	data: () => ({
		selectedItem: 'main',
		items: [
			{ text: 'Annotations', value: 'annotations', icon: 'mdi-clock', statusText: 'Normall' },
			{ text: 'Playback speed', value: 'speed', icon: 'mdi-account', statusText: 'Normall' },
			{ text: 'Subtitles/CC', value: 'subtitles', icon: 'mdi-flag', statusText: 'Off' },
			{ text: 'Quality', value: 'quality', icon: 'mdi-flag', statusText: 'Auto' },
		],
	}),
}
</script>
