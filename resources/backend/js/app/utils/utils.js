'use strict'

window.scrollToTop = function() {
	if (typeof KTUtil !== 'undefined') {
		KTUtil.scrollTop()
	} else {
		window.scrollTo(0, 0)
	}
}

/**
 * Hiện bảng thông báo
 * @param message: Nội dung thông báo
 * @param level: Context class (success, info, warning, danger, primary, brand)
 * @param hide: Tự động ẩn thông báo sau 5s (Default true)
 */
window.flash = function({message, level = 'success', hide = true}) {
	window.events.$emit('flash', {message, level, hide})

	if (!$('.alert').is(':visible')) {
		window.scrollToTop()
	}
}

/**
 * Shortcut block trang
 */
window.blockPage = function(element = '.kt-body') {
	if (typeof KTApp !== 'undefined') {
		if ($(element).length > 0) {
			KTApp.block(element, {opacity: 0.05})
		} else {
			KTApp.block('body', {opacity: 0.05})
		}
	}
}

/**
 * Shortcut unblock
 */
window.unblock = function(element = '.kt-body') {
	if (typeof KTApp !== 'undefined') {
		if ($(element).length > 0) {
			KTApp.unblock(element)
		} else {
			KTApp.unblock('body')
		}
	}
}

window.ajaxErrorHandler = response => {
	if (response === undefined) {
		console.error(response)
	} else {
		console.log(response)
		let message = ''
		let errors = response.data.errors

		if (errors !== undefined) {
			message = '<ul class="mb-0 p-0">'
			Object.entries(errors).forEach(
				([key, values]) => {
					for (let value of values) {
						message += `<li>${value}</li>`
					}
				},
			)
			message += '</ul>'
		} else {
			message = response.data.message
		}

		if (message === '') {
			message = response.statusText
		}

		if ($('.modal:visible').length && $('body').hasClass('modal-open')) {
			let alertHtml = `
				<div role="alert" class="alert alert-dismissible fade show alert-danger">
					<button type="button" data-dismiss="alert" aria-label="Close" class="close"></button>
					<strong>${message}</strong>
				</div>
			`
			$('.modal:visible').find('.modal-body').find('.alert').remove().end().prepend(alertHtml)
		} else {
			flash({message, level: 'danger', hide: false})
		}

	}
	window.scrollToTop()

	return response
}

/**
 * Shortcut để gọi confimation type là info
 * @param callback
 * @param text
 * @param title
 * @returns {jQuery}
 */
window.info = function({callback = undefined, text = __('Info'), title = ''} = {}) {
	return $(document).swal(callback, {showCancelButton: false, type: 'info', confirmButtonText: 'OK', title, text})
}

/**
 * Shortcut để gọi confimation type là question
 * @param callback
 * @param text
 * @param title
 * @returns {jQuery}
 */
window.question = function({callback = undefined, text = __('Question'), title = ''} = {}) {
	return $(document).swal(callback, {showCancelButton: false, type: 'question', confirmButtonText: 'OK', title, text})
}

/**
 * Shortcut để gọi confimation type là success
 * @param callback
 * @param text
 * @param title
 * @returns {jQuery}
 */
window.success = function({callback = undefined, text = __('Success'), title = ''} = {}) {
	return $(document).swal(callback, {showCancelButton: false, type: 'success', confirmButtonText: 'OK', title, text})
}

/**
 * Shortcut để gọi confimation type là warning
 * @param callback
 * @param text
 * @param title
 * @returns {jQuery}
 */
window.warning = function({callback = undefined, text = __('Do you want to continue?'), title = __('Confirm action!!!')} = {}) {
	return $(document).swal(callback, {type: 'warning', title, text})
}

/**
 * Shortcut để gọi confimation type là error
 * @param callback
 * @param text
 * @param title
 * @returns {jQuery}
 */
window.error = function({callback = undefined, text = __('Whoops, something went wrong on our servers.'), title = __('Error')} = {}) {
	return $(document).swal(callback, {showCancelButton: false, confirmButtonText: 'OK', type: 'error', title, text})
}

// Native isPlainObject replacement
window.isPlainObject = function isPlainObject(obj) {
	if (typeof (obj) !== 'object' || obj.nodeType && obj === obj.window) {
		return false
	}

	return !(obj.constructor && !Object.prototype.hasOwnProperty.call(obj.constructor.prototype, 'isPrototypeOf'))
}

/*
* Parse số có format về giá trị số sử dụng numeral().value()
*/
window.unformatNumber = function unformatNumber(number) {
	if (number !== undefined) {
		return numeral(number).value()
	}

	return 0
}

/*
 * Format số theo định dạng (Default 0,00)
 */
window.formatNumber = function formatNumber(number, format = '0,00') {
	if (number !== undefined) {
		return numeral(number).format(format)
	}

	return 'undefined'
}

window.numberToWord = require('./numberToWord')

/**
 * Get a random floating point number between `min` and `max`.
 *
 * @param {number} min - min number
 * @param {number} max - max number
 * @return {number} a random floating point number
 */
window.randomFloat = (min, max) => Math.random() * (max - min) + min

/**
 * Get a random integer between `min` and `max`.
 *
 * @param {number} min - min number
 * @param {number} max - max number
 * @return {number} a random integer
 */
window.randomInt = (min, max) => Math.floor(Math.random() * (max - min + 1) + min)

/**
 * Get a random boolean value.
 *
 * @return {boolean} a random true/false
 */
window.randomBool = () => Math.random() >= 0.5

window.__ = function(text) {
	if (window.lang[text]) {
		return window.lang[text]
	}

	return text
}