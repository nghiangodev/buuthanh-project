let initDatepicker = function() {
	let i18nObject = {
		days: [
			'Chủ nhật',
			'Thứ hai',
			'Thứ ba',
			'Thứ tư',
			'Thứ năm',
			'Thứ sáu',
			'Thứ bảy'],
		daysShort: [
			'CN',
			'Thứ 2',
			'Thứ 3',
			'Thứ 4',
			'Thứ 5',
			'Thứ 6',
			'Thứ 7'],
		daysMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
		months: [
			'Tháng 1',
			'Tháng 2',
			'Tháng 3',
			'Tháng 4',
			'Tháng 5',
			'Tháng 6',
			'Tháng 7',
			'Tháng 8',
			'Tháng 9',
			'Tháng 10',
			'Tháng 11',
			'Tháng 12'],
		monthsShort: [
			'Th1',
			'Th2',
			'Th3',
			'Th4',
			'Th5',
			'Th6',
			'Th7',
			'Th8',
			'Th9',
			'Th10',
			'Th11',
			'Th12'],
		meridiem: '',
		today: 'Hôm nay',
		clear: 'Xóa',
	}
	let language = $('html').attr('lang')

	if (typeof $.fn.datepicker === 'function') {
		$.extend(true, $.fn.datepicker.defaults, {
			format: 'dd-mm-yyyy',
			autoclose: true,
			orientation: 'bottom left',
			todayHighlight: true,
			language: language,
			todayBtn: 'linked',
			// clearBtn: true
		})
		$.fn.datepicker.dates['vi'] = i18nObject

		$('.text-datepicker, .input-group.date').datepicker()

		let d = new Date()
		d.setFullYear(d.getFullYear() - 10)
		d.setDate(31)
		d.setMonth(11)

		$('.text-datepicker-dob').datepicker({
			endDate: d,
			todayBtn: false
		})
	}

	if (typeof $.fn.datetimepicker === 'function') {
		$.extend(true, $.fn.datetimepicker.defaults, {
			format: 'dd-mm-yyyy hh:ii:ss',
			autoclose: true,
			orientation: 'bottom left',
			todayHighlight: true,
			language: language,
			todayBtn: 'linked',
			forceParse: false,
			// clearBtn: true
		})
		$.fn.datetimepicker.dates['vi'] = i18nObject

		$('.text-dateptimepicker, .input-group.datetime').datetimepicker()
	}

	if (typeof $.fn.timepicker === 'function') {
		$.extend(true, $.fn.timepicker.defaults, {
			showMeridian: false,
			explicitMode: true,
			// defaultTime: '00:00',
			defaultTime: false
		})
		$('.text-timepicker, .input-group.time').timepicker()
	}
}

module.exports = initDatepicker
