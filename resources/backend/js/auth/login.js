$(function() {
	$('#form_login').on('submit', function(e) {
		e.preventDefault()

		let url = $(this).prop('action')
		let formData = new FormData($(this)[0])
		KTApp.block('.kt-login__container', {opacity: 0.05})

		request.doRequest({
			url,
			data: formData,
			method: 'post',
			config: {headers: {'Content-Type': 'multipart/form-data'}},
		}).then(() => {
			location.reload()
		}).catch(error => {
			console.log(error.data)
			let {username = '', password = ''} = error.data

			if (username) {
				$('input[name="username"]').parent().append(`<span class="form-text text-danger"><strong>${username}</strong></span>`)
			}

			if (password) {
				$('input[name="password"]').parent().append(`<span class="form-text text-danger"><strong>${password}</strong></span>`)
			}
		}).finally(() => {
			window.unblock()
			KTApp.unblock('.kt-login__container')
		})
	})
})