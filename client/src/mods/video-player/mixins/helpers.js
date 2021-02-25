export const prettyTime = (secs, hundreds = false, tenths = false) => {
	var hunds = 0

	if (hundreds) {
		hunds = secs - Math.floor(secs)

		if (tenths) {
			hunds = Math.round(hunds * 10)
		} else {
			hunds = Math.floor(hunds * 100)
		}
	}

	secs = Math.floor(secs)

	var hrs = 0,
		mins = 0 //, t = secs;

	if (secs >= 3600) {
		hrs = Math.floor(secs / 3600)
		secs = secs - hrs * 3600
	}

	if (secs >= 60) {
		mins = Math.floor(secs / 60)
		secs = secs - mins * 60
	}

	var display = ''

	if (hrs > 0) {
		// if (hrs < 10) {
		//   display += "0";
		// }
		display += hrs + ':'
	}

	if (mins < 10) {
		mins = '0' + mins
	}
	display += mins + ':'

	if (secs < 0) {
		secs = 0
	}

	if (secs < 10) {
		secs = '0' + secs
	}

	if (hundreds) {
		if (tenths) {
			secs += ':' + hunds
		} else {
			if (hunds < 10) {
				hunds = '0' + hunds
			}
			secs += ':' + hunds
		}
	}

	return display + secs
}

export const loadImage = (url) => {
	return new Promise((resolve, reject) => {
		const image = new Image()

		const onSuccess = () => {
			resolve({ width: image.width, height: image.height })
		}

		const onFail = (e) => {
			reject()
		}

		image.onload = onSuccess
		image.onerror = onFail
		image.src = url
	})
}

export const getAspectRatio = (str, inverse = false) => {
	let value

	if (!str || ['169', '16/9', '16:9'].includes(str)) {
		value = inverse ? 9 / 16 : 16 / 9
	} else {
		let sep = '/'

		let [a, b] = str.split(sep)

		value = inverse ? parseInt(b) / parseInt(a) : parseInt(a) / parseInt(b)
	}

	value = value * 100

	value = Math.round((value + Number.EPSILON) * 100) / 100

	return value
}

export const deepMerge = (t, s) => {
	const o = Object,
		a = o.assign
	for (const k of o.keys(s)) s[k] instanceof o && a(s[k], deepMerge(t[k], s[k]))
	return a(t || {}, s), t
}
