'use strict'

let jqueryPlugins = function() {
	/**
	 * Tạo mảng giá trị từ nhiều input cùng class
	 * @param attribute (optional): tên của data attribute
	 * @param parse (optional): parse dữ liệu (Number, String, Boolean)
	 * @return array
	 */
	$.fn.getValue = function({attribute, parse} = {}) {
		let elements = this.toArray()

		elements = attribute !== undefined ? elements.map(elem => elem.getAttribute(`data-${attribute}`)) : elements.map(elem => elem.value)

		return parse !== undefined ? elements.map(parse) : elements
	}

	/**
	 * Lưu form sử dụng Form data
	 * @param url
	 * @param formData
	 * @param data: custom data
	 * @param returnEarly: return promise without handle by default
	 * @return Promise
	 */
	$.fn.submitData = function({url, formData, data, returnEarly} = {}) {
		blockPage()
		const method = 'post'
		url = url === undefined ? $(this).attr('action') : url
		if (formData === undefined) {
			// noinspection JSCheckFunctionSignatures
			formData = this.is('form') ? new FormData(this[0]) : new FormData()
		}
		if (data !== undefined && typeof data === 'object') {
			Object.entries(data).forEach(([key, value]) => formData.append(key, value))
		}

		if (returnEarly !== undefined && returnEarly) {
			return request.doRequest({
				url,
				data: formData,
				method,
				config: {headers: {'Content-Type': 'multipart/form-data'}},
			})
		}

		return request.doRequest({
			url,
			data: formData,
			method,
			config: {headers: {'Content-Type': 'multipart/form-data'}},
			callback: data => {
				if (data.message !== undefined && data.message !== '') {
					flash({message: data.message})
				}

				return data
			},
		})
	}

	/**
	 * Hiện modal xác nhận hành động
	 * @param callback: hàm xử lý hành động
	 * @param text: nội dung
	 * @param title: tiêu đề
	 * @param type: loại modal xác nhận (warning, info, danger)
	 * @param showCancelButton: hiện nút cancel hoặc không (default true)
	 * @param confirmButtonText: text cho button confirm
	 */
	$.fn.swal = function(callback, {text = __('Do you want to continue?'), title = __('Confirm action!!!'), type = 'warning', showCancelButton = true, confirmButtonText = __('Yes')} = {}) {
		let confirmTitle = $(this).data('confirm-title') || title
		let confirmText = $(this).data('confirm-text') || text
		let contextClass = type

		if (contextClass === 'error') {
			contextClass = 'danger'
		}
		if (contextClass === 'question') {
			contextClass = 'primary'
		}

		let icons = {
			danger: '<i class="fad kt-font-danger fa-times"></i>',
			warning: '<i class="fad kt-font-warning fa-exclamation"></i>',
			success: '<i class="fad kt-font-success fa-check"></i>',
			info: '<i class="fad kt-font-info fa-info"></i>',
			primary: '<i class="fad kt-font-primary fa-question"></i>',
		}

		window.blockPage()
		const fire = Swal.fire({
			title: confirmTitle,
			text: confirmText,
			icon: type,
			showCancelButton,
			customClass: {
				confirmButton: `btn btn-${contextClass}`,
				cancelButton: `btn btn-outline-hover-${contextClass}`,
				header: `header-${contextClass}`,
			},
			confirmButtonText,
			cancelButtonText: __('No'),
			buttonsStyling: false,
			iconHtml: icons[contextClass]
		})

		if (callback !== undefined) {
			fire.then(callback)
		}

		fire.finally(function() {
			window.unblock()
		})

		return fire
	}

	/**
	 * Hiện modal với content load ajax
	 * @param url: đường dẫn gọi form modal
	 * @param params: tham số truyền vào request
	 * @param method: phương thức của ajax request
	 * @param backdrop
	 * @param withModalBody
	 * @returns {*}
	 */
	$.fn.showModal = function({url, params = {}, method = 'get', backdrop = false, withModalBody = false}) {
		blockPage()

		return request.doRequest({
			url,
			data: params,
			method,
			callback: data => {

				if (withModalBody) {
					this.find('.modal-content').html(`<div class="modal-body">${data}</div>`)
				} else {
					this.find('.modal-content').html(data)
				}

				if (backdrop) {
					this.modal({
						backdrop: 'static',
						keyboard: true,
					})
				} else {
					this.modal()
				}
			},
		})
	}

	/**
	 * Clear form co select2
	 */
	$.fn.resetForm = function(option = 'clear_all') {
		if (option === 'clear_all') {
			this.find('input, select').val(null).trigger('change')
		} else {
			this[0].reset()
		}
	}
}

module.exports = jqueryPlugins