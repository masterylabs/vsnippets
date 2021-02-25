<template>
	<div>
		<slot name="content" />

		<slot />

		<v-row justify="end" no-gutters>
			<slot name="delete-btn" />
		</v-row>
	</div>
</template>
