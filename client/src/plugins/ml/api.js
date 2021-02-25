import axios from 'axios'

class Api {
	isUrlAuth = false

	constructor(baseURL = '', options = {}) {
		this.api = axios.create({
			baseURL,
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
				Accept: 'application/json',
				Authorization: options.authToken,
			},
		})

		this.api.interceptors.request.use((req) => {
			if (!req.params) {
				req.params = {}
			}

			// secondary
			if (this.isUrlAuth && options.authToken) {
				req.params.auth_token = options.authToken
			}
			// resolve caching
			if (options.cashBuster) req.params.mlcabu = Date.now()

			return req
		})
	}

	get(endpoint = '', params = {}) {
		return this.api.get(endpoint, { params })
	}

	post(endpoint = '', data = {}, params = {}, remove = ['id', 'identifier', 'created', 'updated']) {
		const form = new URLSearchParams()

		for (let k in data) {
			if (!remove.includes(k)) {
				// bools
				if (typeof data[k] == 'boolean') {
					data[k] = data[k] ? 1 : 0
				}

				// objects
				if (typeof data[k] == 'object') {
					data[k] = JSON.stringify(data[k])
				}
				form.append(k, data[k])
			}
		}

		return this.api.post(endpoint, form, { params })
	}
}

export default Api
