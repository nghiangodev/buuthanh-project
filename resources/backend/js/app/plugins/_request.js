'use strict'

const doPost = ({url, params = {}, callback, config = {}}) => {

	if (typeof callback === 'function') {
		return axios.post(url, params, config).then(callback).finally(unblock)
	}

	return axios.post(url, params, config).finally(unblock)
}
const doGet = ({url, params = {}, callback, config = {}}) => {

	if (typeof callback === 'function') {
		return axios.get(url, Object.assign({}, {params}, config)).then(callback).finally(unblock)
	}

	return axios.get(url, Object.assign({}, {params}, config)).finally(unblock)
}
const doPut = ({url, params = {}, callback, config = {}}) => {

	if (typeof callback === 'function') {
		return axios.put(url, params, config).then(callback).finally(unblock)
	}

	return axios.put(url, params, config).finally(unblock)
}
const doDelete = ({url, params = {}, callback}) => {

	if (typeof callback === 'function') {
		return axios.post(url, Object.assign({}, {_method: 'delete'}, params)).then(callback).finally(unblock)
	}

	return axios.post(url, Object.assign({}, {_method: 'delete'}, params)).finally(unblock)
}
const doRequest = ({url, method = 'get', data = {}, config = {}, callback}) => {
	return axios({
		method,
		url,
		data,
		config,
	}).then(callback).finally(unblock)
}

module.exports = {doPost, doGet, doDelete, doPut, doRequest}