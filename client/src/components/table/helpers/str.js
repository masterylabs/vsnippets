export const toCamel = (str, startCap = false) => {
	str = str.replace(/-([a-z])/g, function(g) {
		return g[1].toUpperCase()
	})
	if (startCap) return str.charAt(0).toUpperCase() + str.slice(1)
	return str
}
