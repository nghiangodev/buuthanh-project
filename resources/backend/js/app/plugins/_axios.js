'use strict'

const initAxios = () => {
	axios.interceptors.response.use((response) => {
		return response.data
	}, function(error) {
		//note: unauthorized user

		if (error.response !== undefined) {

			const httpCode = error.response.status

			if (httpCode === 401 || httpCode === 419) {
				let text = error.response.data.message || error.message

				window.error({text, callback: () => location.reload()})
			}
			return Promise.reject(ajaxErrorHandler(error.response))
		}

		return Promise.reject(error)
	})
}

module.exports = initAxios