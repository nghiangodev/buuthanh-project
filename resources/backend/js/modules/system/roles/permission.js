$(function() {
	$('.chk-all-permission').on('click', function() {
		if ($(this).is(':checked')) {
			$(this).parents('tr').find('.chk-permission').prop('checked', true)
		} else {
			$(this).parents('tr').find('.chk-permission').prop('checked', false)
		}
	})

	$('.link-check-all').on('click', function() {
		$(this).parent().parent().find('.chk-permission, .chk-all-permission').prop('checked', true)
	})
	$('.link-uncheck-all').on('click', function() {
		$(this).parent().parent().find('.chk-permission, .chk-all-permission').prop('checked', false)
	})

	function checkCheckAllChkBox() {
		let tr = $(this).parents('tr')
		if (tr.find('.chk-permission:checked').length >= tr.find('.chk-permission').length) {
			$(this).parents('tr').find('.chk-all-permission').prop('checked', true)
		} else {
			$(this).parents('tr').find('.chk-all-permission').prop('checked', false)
		}
	}

	$('.chk-permission').on('click', function() {
		checkCheckAllChkBox.call(this)
	})

	$('.chk-all-permission').each(function() {
		checkCheckAllChkBox.call(this)
	})

	$('.accordion-permission-table').each(function() {
		if ($(this).find('input[type="checkbox"]:checked').length > 0) {
			$(this).find('.collapse').addClass('show')
		}
	})
})