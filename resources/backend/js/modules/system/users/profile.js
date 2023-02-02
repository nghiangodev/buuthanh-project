window.vueApp = new Vue({
	el: '#app',
})

$(function() {
	let $userForm = $('#users_form')
	let isConfirm = $userForm.data('confirm')

	function editFormProfile() {
		$('#btn_edit').prop('hidden', false)
		$('#btn_save').prop('hidden', true)
		$('#btn_cancel').prop('hidden', true)
		$('#txt_name').prop('disabled', true)
		$('#txt_email').prop('disabled', true)
	}

	$userForm.validate({
		// define validation rules
		rules: {
			password: {
				required(element) {
					let val = $(element).data('value')
					return val === ''
				},
				pwCheck(element) {
					let val = $(element).data('value')
					return val === ''
				},
			},
			password_confirmation: {
				required() {
					return $('#txt_password').val() !== ''
				},
				equalTo: '#txt_password',
			},
			email: {
				email(element) {
					let val = $(element).data('value')
					return val === ''
				},
			},
		},
		messages: {
			password_confirmation: 'Vui lòng nhập mật khẩu giống mật khẩu vừa nhập',
		},
		submitHandler: isConfirm && function(form, e) {
			window.blockPage()
			e.preventDefault()

			$(form).swal(result => {
				if (result.value) {
					$(form).submitData({returnEarly: true}).then(data => {
						let msg = data.message

						let redirectUrl = data.redirect_url
						if (redirectUrl !== undefined) {
							window.success({text: msg, callback: () => location.href = redirectUrl})
						}
					})
				}
			})
		},
	})
	//
	editFormProfile()
	$('#btn_edit').on('click', function() {
		$('#btn_edit').prop('hidden', true)
		$('#btn_save').prop('hidden', false)
		$('#btn_cancel').prop('hidden', false)
		$('#txt_name').prop('disabled', false)
		$('#txt_email').prop('disabled', false)
	})
	$('#btn_cancel').on('click', function() {
		editFormProfile()
	})
})