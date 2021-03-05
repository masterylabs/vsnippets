const onErrorResponse = function(response = {}) {
  if (response.data && response.data.message) {
    this.error(response.data.message)
  } else if (response.statusText) {
    this.error(response.statusText)
  }
}

export default {
  onErrorResponse,
}
