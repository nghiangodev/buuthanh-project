let initValidation = function() {
	let language = $('html').attr('lang')
	if (typeof $.validator !== 'undefined') {
		if (language === 'vi') {
			$.extend($.validator.messages, {
				required: 'Hãy nhập giá trị.',
				remote: 'Hãy sửa cho đúng.',
				email: 'Hãy nhập email.',
				url: 'Hãy nhập URL.',
				date: 'Hãy nhập ngày.',
				dateISO: 'Hãy nhập ngày (ISO).',
				number: 'Hãy nhập số.',
				digits: 'Hãy nhập chữ số.',
				creditcard: 'Hãy nhập số thẻ tín dụng.',
				equalTo: 'Hãy nhập giống thêm lần nữa.',
				extension: 'Phần mở rộng không đúng.',
				maxlength: $.validator.format('Hãy nhập từ {0} kí tự trở xuống.'),
				minlength: $.validator.format('Hãy nhập từ {0} kí tự trở lên.'),
				rangelength: $.validator.format('Hãy nhập từ {0} đến {1} kí tự.'),
				range: $.validator.format('Hãy nhập từ {0} đến {1}.'),
				max: $.validator.format('Hãy nhập từ {0} trở xuống.'),
				min: $.validator.format('Hãy nhập từ {0} trở lên.'),
			})
		}

		$.validator.addMethod('greaterThan', function(value, element, params) {
			if ($(params[0]).val() !== '' && value !== '') {
				let isTime = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])?$/.test(
					value)

				if (isTime) {
					let beginningTime = moment($(params[0]).val(), 'h:mm')
					let endTime = moment(value, 'h:mm')

					return beginningTime.isBefore(endTime)
				} else {
					// noinspection JSCheckFunctionSignatures
					if (!/Invalid|NaN/.test(new Date(value))) {
						return new Date(value) >
							new Date($(params[0]).val())
					} else {
						return (Number(value) > Number($(params[0]).val()))
					}
				}
			}

			return true
		}, '{1} phải lớn hơn {2}.')

		$.validator.addMethod('pwCheck', function(value) {
			return /^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/.test(value) // consists of only these
		}, __('passwords.strength'))

		$.validator.setDefaults({
			showErrors() {
				let numberOfInvalids = this.numberOfInvalids()
				let message = numberOfInvalids + __(' field(s) are invalid')
				if (numberOfInvalids > 0) {
					if ($('.modal-open').length === 0) {
						flash({message, level: 'danger', hide: false})
					}
				} else {
					window.events.$emit('hide')
				}
				this.defaultShowErrors()
			},
		})
	}
}

module.exports = initValidation