/* eslint-disable linebreak-style,no-console */

window.$$ = require('./core')
require('./utils/utils')

window.axios = require('axios')
let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
	console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}
window.request = require('./plugins/_request')

//VUE
window.Vue = require('vue')

Vue.mixin({
	data: function() {
		return {
			get window() {
				return window
			},
		}
	},
})

Vue.component('flash', require('../components/Flash').default)
Vue.component('password',require('../components/Password').default)

window.events = new Vue()

window.vueApp = new Vue({
	el: '#app',
})
//END VUE