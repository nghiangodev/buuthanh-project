/* eslint-disable no-undef */

$(function() {
	$$.init()

	$('input').each(function() {
		if (!$(this).attr('placeholder')) {
			$(this).attr('placeholder', __('Please input data'))
		}
	})

	let $body = $('body')

	$body.on('click', '.alert-close .close', function() {
		window.events.$emit('hide')
	})

	$body.on('changeDate', '#txt_from_date', function(selected) {
		let fromDateUnix = selected.date.valueOf()
		let minDate = new Date(fromDateUnix)
		$('#txt_to_date').datepicker('setStartDate', minDate)

		let toDateVal = $('#txt_to_date').val()
		if (toDateVal) {
			let toDateUnix = moment(toDateVal, 'DD-MM-YYYY').unix() * 1000
			if (toDateUnix < fromDateUnix) {
				$('#txt_to_date').val($('#txt_from_date').val())
			}
		}

		$(this).datepicker('hide')
	})

	$body.on('click', '#btn_logout', function() {
		let form = $(this).next()

		$(form).submit()
	})

	$body.on('click', '#link_form_change_password', function() {
		let url = $(this).data('url')

		$('#modal_md').showModal({url})
	})

	$('.modal').on('show.bs.modal', function() {
		$(this).addClass('modal-brand').show()

		// $('select').on('select2:open', function() {
		// 	$('.select2-search input').prop('focus', 0)
		// })
	})

	$('form').on('change', 'select', function() {
		$(this).valid()
	})

	$('form').on('click', '#link_back', function(e) {
		let shouldConfirm = $(this).data('should-confirm')
		e.preventDefault()

		if (shouldConfirm) {
			$(this).swal(result => {
				if (result.value) {
					location.href = $(this).attr('href')
				}
				window.unblock()
			}, {type: 'question', title: __('You have not saved the information!!!')})
		} else {
			location.href = $(this).attr('href')
		}
	})

	if (typeof KTUtil !== 'undefined' && KTUtil.isMobileDevice()) {
		$('select').on('select2:open', function() {
			$('.select2-search input').prop('focus', 0)
		})
	}
})

// require('./components/quicksearch')
require('./components/notification')