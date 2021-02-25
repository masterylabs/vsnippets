const onErrorResponse = function(response = {}) {
	console.log('onErrorResponse', response.data.message)
	if (response.data && response.data.message) {
		console.log('YES ERROR')
		this.error(response.data.message)
	} else if (response.statusText) {
		this.error(response.statusText)
	}
}

export default {
	onErrorResponse,
}
