<template>
	<div class="mplayer-controls yellowx">
		<v-row align="center" justify="space-between" no-gutters class="px-4 redx">
			<!-- <v-row class="px-5">
				<slot name="play" />
				<slot name="volume" />
				<div class="white--text"><span>aaa</span> / <span>bbb</span></div>
				<slot name="display-time" />
			</v-row> -->
			<!-- <v-col> -->
			<v-row align="center" justify="start" no-gutters>
				<slot name="play" />
				<slot name="volume" />
				<slot name="display-time" />
			</v-row>
			<!-- </v-col> -->
			<!-- <v-col> -->

			<slot name="captions" />
			<slot name="fullscreen" />
			<!-- </v-col> -->
			<!-- <v-btn icon dark>
					<v-icon>mdi-closed-caption</v-icon>
				</v-btn>
				<v-btn icon dark>
					<v-icon>mdi-cog</v-icon>
				</v-btn>
		-->
		</v-row>
	</div>
</template>
