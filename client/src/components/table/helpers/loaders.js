export const loadComponents = (Vue, context, prefix = 'Mod', checkRootComp = true) => {
	context.keys().forEach((fileName) => {
		const componentConfig = context(fileName)
		const componentName = fileName
			.replace(/^\.\/_/, '')
			.replace(/\.\w+$/, '')
			.split('-')
			.map((kebab) => kebab.charAt(0).toUpperCase() + kebab.slice(1))
			.join('')
			.split('/')
			.pop()

		if (checkRootComp && componentName == prefix)
			Vue.component(componentName, componentConfig.default || componentConfig)
		else Vue.component(prefix + componentName, componentConfig.default || componentConfig)
	})
}
