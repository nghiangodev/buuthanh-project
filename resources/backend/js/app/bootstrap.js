/* eslint-disable linebreak-style,no-console */

window.$$ = require('./core')
window.request = require('./plugins/_request')
require('./utils/utils')

window._ = require('lodash')
window.numeral = require('numeral')
require('jquery.alphanum')

require('cleave.js')
// require('cleave.js/dist/addons/cleave-phone.i18n')

//OPTIONAL
// require('../../plugins/fileinput/bootstrap-fileinput.js')
// window.Highcharts = require('highcharts')

window.axios = require('axios')
let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
	console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

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
window.events = new Vue()

Vue.component('flash', require('../components/Flash').default)
Vue.component('password',require('../components/Password').default)
Vue.component('iconbox',require('../components/IconBox').default)
Vue.component('avatar',require('../components/Avatar').default)
Vue.component('fileinput',require('../components/FileInput').default)
Vue.component('fileupload',require('../components/FileUpload').default)
Vue.component('filepond',require('../components/FilePond').default)
//END VUE