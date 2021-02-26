export const openWindowLeft = (url, name = 'window') => {
	let width = 1000,
		height = 1040,
		top = 100,
		left = 960

	if (screen && screen.width) {
		width = Math.floor(screen.width / 2)
		height = screen.height - 100
		top = 50
		left = width
		if (width > 1260) width = 1260
	}

	window.open(url, name, `width=${width}, height=${height}, top=${top}, left=${left}`)
}
