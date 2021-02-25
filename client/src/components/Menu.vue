<template>
	<v-list dense nav>
		<template v-for="(item, i) in items">
			<v-divider v-if="item.value == 'divider'" :key="`d${i}`" class="mt-12 mb-4" />
			<v-list-item v-else :key="item.title" link :to="{ name: item.value }" :exact="item.exact">
				<v-list-item-icon>
					<v-icon>mdi-{{ item.icon }}</v-icon>
				</v-list-item-icon>

				<v-list-item-content>
					<v-list-item-title>{{ item.title }}</v-list-item-title>
				</v-list-item-content>
			</v-list-item>
		</template>
	</v-list>
</template>

<script>
export default {
	data() {
		return {
			items: [
				{ title: 'Dashboard', icon: 'home', value: 'home', exact: true },
				{ title: 'Surveys', icon: 'pencil', value: 'surveys', exact: false },
				{ title: 'Respondents', icon: 'account-group', value: 'respondents', exact: false },
				{ value: 'divider' },
				{ title: 'Settings', icon: 'cog', value: 'settings', exact: false },
			],
		}
	},
}
</script>
