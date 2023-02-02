window.vueApp = new Vue({
	el: '#app',
})

$(function() {
	let $userForm = $('#users_form')
	let isConfirm = $userForm.data('confirm')
	let isAjax = $userForm.data('ajax')

	$userForm.validate({
		// define validation rules
		rules: {
			password: {
				pwCheck() {
					return $('#txt_password').val() !== ''
				},
				required() {
					let userId = $('#txt_user_id').val()
					return userId === ''
				},
			},
			password_confirmation: {
				required() {
					return $('#txt_password').val() !== ''
				},
				equalTo: '#txt_password',
			},
			email: {
				email() {
					return $('#txt_email').val() !== ''
				},
			},
			'otp_type[]': {
				required() {
					return $('#select_use_otp').val() === '1'
				},
			},
			'subscribe_type[]': {
				required() {
					return $('#select_subscribe').val() === '1'
				},
			},
		},
		messages: {
			password: {
				require: __('This field is required.')
			},
			password_confirmation: __('passwords.same_password'),
			'otp_type[]': __('Please select a method'),
			'subscribe_type[]': ['Please select a method'],
		},
		submitHandler: isAjax && function(form, e) {
			window.blockPage()
			e.preventDefault()

			function save() {
				const avatar = vueApp.$children[3].$refs.pond.getFile()
				let formData = new FormData(form)
				if (avatar) {
					let fileToUpload = avatar.file
					let isFileObject = fileToUpload instanceof File
					if (!isFileObject) {
						fileToUpload = new File([fileToUpload], fileToUpload.name, {lastModified: fileToUpload.lastModified})
					}
					formData.append('file_avatar', fileToUpload)
				}

				$(form).submitData({returnEarly: true, formData}).then(data => {
					let msg = data.message

					let redirectUrl = data.redirect_url
					if (redirectUrl !== undefined) {
						window.success({text: msg, callback: () => location.href = redirectUrl})
					}
				})
			}

			if (isConfirm) {
				$(form).swal(result => {
					if (result.value) {
						save()
					}
				})
			} else {
				save()
			}
		},
	})

	$('#select_use_otp').on('change', function() {
		let value = $(this).val()

		const $otpTypeSection = $('#otp_type_section')
		if (value && value === '1') {
			$otpTypeSection.removeClass('d-none')
		} else {
			$otpTypeSection.addClass('d-none')
		}
	})

	$('#select_subscribe').on('change', function() {
		let value = $(this).val()

		const $subscribeTypeSection = $('#subscribe_type_section')
		if (value && value === '1') {
			$subscribeTypeSection.removeClass('d-none')
		} else {
			$subscribeTypeSection.addClass('d-none')
		}
	})
})