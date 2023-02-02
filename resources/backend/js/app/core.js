/* eslint-disable no-undef,no-console */
'use strict'
let $$ = (function($) {
	const handleModal = function() {
		// fix stackable modal issue: when 2 or more modals opened, closing one of modal will remove .modal-open class.
		$(document).on('hidden.bs.modal', function() {
			if ($('.modal:visible').length) {
				$('body').addClass('modal-open')
			}
		})

		// fix page scrollbars issue
		$(document).on('show.bs.modal', '.modal', function() {
			if ($(this).hasClass('modal-scroll')) {
				$('body').addClass('modal-open-noscroll')
			}
		})

		// fix page scrollbars issue
		$(document).on('hidden.bs.modal', '.modal', function() {
			$('body').removeClass('modal-open-noscroll')
		})

		// remove ajax content and remove cache on modal closed
		$(document).on('hidden.bs.modal', '.modal:not(.modal-cached)', function() {
			$(this).removeData('bs.modal')
		})
	}

	const handleJqueryAjax = function() {
		$(document).ajaxComplete(function() {
			unblock()
		})
		$(document).ajaxError(function() {
			unblock()
		})
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			},
		})
	}

	const handleInput = function() {
		//event cho nút check all & single ở table
		$(document).on('click', '.kt-checkbox--all > [type="checkbox"]', function() {
			let cbSingle = $('.kt-checkbox--single > [type="checkbox"]')
			if (!$(this).is(':checked')) {
				cbSingle.prop('checked', '')
			} else {
				cbSingle.prop('checked', 'checked')
			}
		})
		//event cho nút check từng dòng ở table
		$(document).on('click', '.kt-checkbox--single > [type="checkbox"]', function() {
			let cbSingle = $('.kt-checkbox--single > [type="checkbox"]')
			let cbAll = $('.kt-checkbox--all > [type="checkbox"]')
			if ($(this).is(':checked')) {
				let cbSingleChecked = $('.kt-checkbox--single > [type="checkbox"]:checked')
				if (cbSingle.length === cbSingleChecked.length) {
					cbAll.prop('checked', 'checked')
				} else {
					cbAll.prop('checked', '')
				}
			} else {
				cbAll.prop('checked', '')
			}
		})
		//Set select text cho thẻ input focus
		// noinspection JSCheckFunctionSignatures
		$('input, textarea').focus(function() {
			$(this).select()
		})
	}

	const handleAxios = require('./plugins/_axios')

	const handleSelect2 = require('./plugins/_select2')

	const handleDatepicker = require('./plugins/_datepicker')

	const handleHighcharts = require('./plugins/_highcharts')

	const handleMomentJs = require('./plugins/_moment')

	const handleAlphanum = require('./plugins/_alphanum')

	const handleCleave = require('./plugins/_cleave')

	const handleDatatables = require('./plugins/_datatables')

	const handleValidation = require('./plugins/_validations')

	const handlePluginJquery = require('./plugins/_jq_plugins')

	return {
		init() {
			handleAxios()

			handleModal()
			handleJqueryAjax()
			handleInput()

			handleSelect2()
			handleDatepicker()
			handleHighcharts()
			handleMomentJs()
			handleAlphanum()
			handleCleave()
			handleDatatables()
			handleValidation()
			handlePluginJquery()
		},
		handleAlphanum,
		handleCleave,
	}
})(jQuery)

module.exports = $$